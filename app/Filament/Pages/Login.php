<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class Login extends Page
{
protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
protected static string $view = 'filament.admin.login'; // Blade 路徑
protected static ?string $title = '登入';
protected static ?string $slug = 'login'; // 可指定網址 /admin/login
protected static string $layout = 'filament-panels::components.layout.simple';


    public static function shouldRegisterNavigation(): bool
    {
        return false; // 不要出現在側邊欄
    }
}