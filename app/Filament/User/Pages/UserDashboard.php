<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class UserDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.userdashboard';
    protected static ?string $navigationLabel = 'User Dashboard';
}
