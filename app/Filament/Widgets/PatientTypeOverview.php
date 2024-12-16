<?php

namespace App\Filament\Widgets;

use App\Models\Probe;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('P110', Probe::query()->where('type', 'P110')->where('status', 0)->count()),
            Stat::make('P120', Probe::query()->where('type', 'P120')->where('status', 0)->count()),
            Stat::make('P140', Probe::query()->where('type', 'P140')->where('status', 0)->count()),
            Stat::make('P220', Probe::query()->where('type', 'P220')->where('status', 0)->count()),
            Stat::make('P360', Probe::query()->where('type', 'P360')->where('status', 0)->count()),
            Stat::make('P560', Probe::query()->where('type', 'P560')->where('status', 0)->count()),

        ];
    }
}
