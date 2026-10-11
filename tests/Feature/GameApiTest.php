<?php

namespace Tests\Feature;

use App\Models\Background;
use App\Models\GameInfo;
use App\Models\Skin;
use App\Models\User;
use App\Support\EmailEncryption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GameApiTest extends TestCase
{
    use RefreshDatabase;

    private function makePlayer(string $email = 'player@example.com', string $password = 'Secret#123'): User
    {
        return User::create(EmailEncryption::attributes($email) + [
            'username' => strtok($email, '@'),
            'password' => Hash::make($password),
            'is_verified' => true,
            'provider' => 'sidetoside',
            'timezone' => 'UTC',
        ]);
    }

    public function test_register_creates_user_with_encrypted_email_and_game_info(): void
    {
        Mail::fake();

        $response = $this->postJson('/api/register', [
            'username' => 'newplayer',
            'email' => 'new@example.com',
            'password' => 'Secret#123',
            'password_confirmation' => 'Secret#123',
            'timezone' => 'UTC',
        ]);

        $response->assertStatus(201)->assertJson(['success' => true]);

        $user = User::where('hashed_email', EmailEncryption::hash('new@example.com'))->firstOrFail();
        $this->assertNotSame('new@example.com', $user->email);
        $this->assertSame('new@example.com', EmailEncryption::decrypt($user->email));
        $this->assertNotNull($user->gameInfo, 'game_info row should be created for new users');

        // Same e-mail again is rejected (uniqueness is checked on the hash).
        $this->postJson('/api/register', [
            'username' => 'otherplayer',
            'email' => 'new@example.com',
            'password' => 'Secret#123',
            'password_confirmation' => 'Secret#123',
        ])->assertStatus(422);
    }

    public function test_login_returns_a_usable_plain_sanctum_token(): void
    {
        $user = $this->makePlayer();

        $response = $this->postJson('/api/login', [
            'email' => 'player@example.com',
            'password' => 'Secret#123',
        ]);

        $response->assertOk()->assertJsonPath('user.id', $user->id);
        $token = $response->json('token');
        $this->assertMatchesRegularExpression('/^\d+\|/', $token);

        $profile = $this->withToken($token)->getJson('/api/user-profile');
        $profile->assertOk()->assertJsonPath('username', 'player')->assertJsonMissingPath('email');

        $this->postJson('/api/login', [
            'email' => 'player@example.com',
            'password' => 'wrong-password',
        ])->assertStatus(401);
    }

    public function test_game_endpoints_require_a_token(): void
    {
        $user = $this->makePlayer();

        $this->postJson('/api/update-score-coins', [
            'user_id' => $user->id, 'score' => 10, 'coin' => 10, 'retry_times' => 1,
        ])->assertStatus(401);
        $this->getJson("/api/user-profile/{$user->id}")->assertStatus(401);
        $this->postJson('/api/purchase-item', ['user_id' => $user->id])->assertStatus(401);
        $this->postJson('/api/reset-score-retry', ['user_id' => $user->id])->assertStatus(401);
    }

    public function test_user_cannot_read_another_users_profile(): void
    {
        $me = $this->makePlayer();
        $other = $this->makePlayer('other@example.com');

        Sanctum::actingAs($me);

        $this->getJson("/api/user-profile/{$me->id}")->assertOk();
        $this->getJson("/api/user-profile/{$other->id}")->assertForbidden();
    }

    public function test_update_score_adds_bounded_deltas_to_the_token_owner(): void
    {
        $me = $this->makePlayer();
        $other = $this->makePlayer('other@example.com');

        Sanctum::actingAs($me);

        $this->postJson('/api/update-score-coins', [
            'user_id' => $other->id, // ignored: the token decides the player
            'score' => 150,
            'coin' => 20,
            'retry_times' => 1,
        ])->assertOk()
            ->assertJsonPath('data.user_id', $me->id)
            ->assertJsonPath('data.score', 150)
            ->assertJsonPath('data.coin', 20);

        $this->assertSame(0, (int) $other->gameInfo()->value('score'));

        $this->postJson('/api/update-score-coins', [
            'score' => -1000, 'coin' => 0, 'retry_times' => 0,
        ])->assertStatus(422);

        $this->postJson('/api/update-score-coins', [
            'score' => 0, 'coin' => config('game.max_coin_delta') + 1, 'retry_times' => 0,
        ])->assertStatus(422);
    }

    public function test_purchase_and_select_item(): void
    {
        $me = $this->makePlayer();
        $me->gameInfo->update(['coin' => 100]);

        $skin = Skin::create(['skin_name' => 'Fire', 'skin_image' => 'skins/fire.png', 'cost' => 60]);
        $background = Background::create(['background_name' => 'Night', 'background_image' => 'bg/night.png', 'cost' => 80]);

        Sanctum::actingAs($me);

        $this->postJson('/api/purchase-item', ['item_type' => 'skin', 'item_id' => $skin->id])
            ->assertOk()->assertJson(['success' => true]);

        $gameInfo = GameInfo::where('user_id', $me->id)->first();
        $this->assertSame(40, (int) $gameInfo->coin);
        $this->assertSame([$skin->id], $gameInfo->unlocked_skins);

        // Buying it again doesn't charge twice.
        $this->postJson('/api/purchase-item', ['item_type' => 'skin', 'item_id' => $skin->id])
            ->assertJson(['success' => false]);
        $this->assertSame(40, (int) $gameInfo->fresh()->coin);

        // Not enough coins for the background.
        $this->postJson('/api/purchase-item', ['item_type' => 'background', 'item_id' => $background->id])
            ->assertJson(['success' => false, 'message' => 'Not enough coins.']);

        $this->postJson('/api/select-item', ['item_type' => 'skin', 'item_id' => $skin->id])
            ->assertJson(['success' => true]);
        $this->postJson('/api/select-item', ['item_type' => 'background', 'item_id' => $background->id])
            ->assertJson(['success' => false]);

        $list = $this->getJson('/api/skins-and-backgrounds')->assertOk();
        $list->assertJsonPath('skins.0.isUnlocked', true)
            ->assertJsonPath('skins.0.isSelected', true)
            ->assertJsonPath('backgrounds.0.isUnlocked', false);

        $this->getJson('/api/user-profile')->assertJsonPath('unlocked_skins', [$skin->id]);
    }

    public function test_admin_create_command_makes_an_admin_who_can_sign_in(): void
    {
        $this->artisan('admin:create', [
            '--email' => 'admin@example.com',
            '--password' => 'Admin#Pass1',
        ])->assertSuccessful();

        $admin = User::where('hashed_email', EmailEncryption::hash('admin@example.com'))->firstOrFail();
        $this->assertTrue($admin->isAdmin());

        $this->post('/login', ['email' => 'admin@example.com', 'password' => 'Admin#Pass1'])
            ->assertRedirect(route('filament.admin.pages.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_panels_and_ad_reports_are_restricted(): void
    {
        $player = $this->makePlayer();
        $admin = $this->makePlayer('admin@example.com');
        $admin->update(['user_type' => 'admin']);

        $this->get('/ads/admin-report')->assertRedirect(route('login'));

        $this->actingAs($player)->get('/admin')->assertForbidden();
        $this->actingAs($player)->get('/ads/admin-report')->assertForbidden();

        $this->actingAs($admin)->get('/user')->assertForbidden();
        $this->actingAs($admin)->get('/ads/admin-report')->assertOk();
        // (The admin dashboard charts use MySQL date functions, so the page
        // itself isn't rendered on SQLite; check the panel gate directly.)
        $this->assertTrue($admin->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')));
        $this->assertFalse($player->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')));
    }

    public function test_player_dashboard_shows_the_players_own_items(): void
    {
        $skin = Skin::create(['skin_name' => 'Fire', 'skin_image' => 'skins/fire.png', 'cost' => 0]);
        $background = Background::create(['background_name' => 'Night', 'background_image' => 'bg/night.png', 'cost' => 0]);

        $other = $this->makePlayer('other@example.com');
        $other->gameInfo->update(['ball_skin_selected' => 'someone-elses-skin.png']);

        $player = $this->makePlayer();
        $player->gameInfo->update([
            'unlocked_skins' => [$skin->id],
            'unlocked_backgrounds' => [$background->id],
            'ball_skin_selected' => $skin->id,
            'background_selected' => $background->id,
        ]);

        $this->actingAs($player)->get(route('filament.user.pages.user-dashboard'))
            ->assertOk()
            ->assertSee('skins/fire.png')
            ->assertSee('bg/night.png')
            ->assertDontSee('someone-elses-skin.png');
    }

    public function test_login_and_signup_pages_render_without_apple_button(): void
    {
        $this->get('/login')->assertOk()->assertDontSee('Apple ID');
        $this->get('/signup')->assertOk()->assertDontSee('Apple ID');
    }
}
