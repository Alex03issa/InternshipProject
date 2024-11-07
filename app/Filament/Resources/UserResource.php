<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Users';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\FileUpload::make('profile_image')
                            ->directory('profile_images')
                            ->label('Profile Image')
                            ->image()
                            ->preserveFilenames() 
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->columnSpanFull()
                            ->alignment('center'),
                        
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->nullable()
                            ->columnSpan(6),
                            
                        Forms\Components\TextInput::make('user_name')
                            ->label('User Name')
                            ->nullable()
                            ->columnSpan(6)
                            ->required(),


                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->label('Email Address')
                            ->columnSpanFull()
                            
                            ->rules(function ($get) {
                                $uniqueRule = 'unique:users,email';
                        
                                if ($get('id')) {
                                    $uniqueRule .= ',' . $get('id');
                                }
                        
                                return [$uniqueRule];
                            }),
                        
                        
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->minLength(8)
                            ->label('Password')
                            ->reactive()
                            ->columnSpan(6)
                            ->confirmed(),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->revealable()
                            ->label('Confirm Password')
                            ->columnSpan(6)
                            ->reactive()
                            ->suffixIcon(fn ($get) => $get('password') === $get('password_confirmation') ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                            ->suffixIconColor(fn ($get) => $get('password') === $get('password_confirmation') ? 'success' : 'danger')
                            ->requiredWith('password') 
                            ->dehydrated(false),
                    
                    
                        
                        Forms\Components\Select::make('user_type')
                            ->options([
                                'user' => 'User',
                                'admin' => 'Admin',
                            ])
                            ->default('admin')
                            ->required()
                            ->label('User Type')
                            ->columnSpan(2),
                        
                        Forms\Components\Hidden::make('timezone')
                            ->default(fn () => 
                                now()->setTimezone(\IntlTimeZone::createDefault()->getID())->getTimezone()->getName()
                            ),
                    ])
                    ->columns(12)
                    ->columnSpan(12)
                    ->label('User Information')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('User ID')
                    ->sortable(),
                ImageColumn::make('profile_image')
                    ->label('Profile Image')
                    ->circular()
                    ->url(fn ($record) => $record->profile_image ? url(Storage::url($record->profile_image)) : null),
                TextColumn::make('display_name')
                    ->label('Username/Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('user_type')
                    ->label('User Type')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->formatStateUsing(function ($state, $record) {
                        $postTimezone = $record->timezone ?? 'UTC'; 
                        return Carbon::parse($state)->setTimezone($postTimezone);
                    })                    
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->formatStateUsing(function ($state, $record) {
                        $postTimezone = $record->timezone ?? 'UTC'; 
                        return Carbon::parse($state)->setTimezone($postTimezone);
                    })                    
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_type')
                    ->options([
                        'admin' => 'Admin Users',
                        'user' => 'Regular Users',
                    ]),
                Filter::make('created_at')
                    ->form([
                        Section::make('Filter by Created Date') 
                            ->schema([
                                Forms\Components\DatePicker::make('from')
                                    ->label('From'),
                                Forms\Components\DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible()  
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('created_at', '>=', Carbon::parse($data['from']));
                        }
    
                        if ($data['until']) {
                            $query->whereDate('created_at', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('Created Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "Created from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "Created from {$data['from']}";
                        } elseif ($data['until']) {
                            return "Created until {$data['until']}";
                        }
                        return null;
                    }),
    
                Filter::make('updated_at')
                    ->form([
                        Section::make('Filter by Updated Date') 
                            ->schema([
                                Forms\Components\DatePicker::make('from')
                                    ->label('From'),
                                Forms\Components\DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible()  
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('updated_at', '>=', Carbon::parse($data['from']));
                        }
    
                        if ($data['until']) {
                            $query->whereDate('updated_at', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('Updated Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "Updated from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "Updated from {$data['from']}";
                        } elseif ($data['until']) {
                            return "Updated until {$data['until']}";
                        }
                        return null;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('')
                    ->size('xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}