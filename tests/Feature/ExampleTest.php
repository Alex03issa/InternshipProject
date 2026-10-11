<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // The homepage is built from the "Homepage" category's posts.
        \App\Models\Category::create(['title' => 'Homepage', 'slug' => 'homepage']);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
