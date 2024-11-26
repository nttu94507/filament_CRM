<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->pages([

            ])
            ->domain('jagres.com');

    }
}

