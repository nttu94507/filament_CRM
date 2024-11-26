<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProbeResource;
use App\Models\Patient;
use App\Models\Probe;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('P110', Probe::query()->where('type', 'P110')->count()),
            Stat::make('P120', Patient::query()->where('type', 'P120')->count()),
            Stat::make('P140', Patient::query()->where('type', 'P140')->count()),
            Stat::make('P220', Patient::query()->where('type', 'P220')->count()),
            Stat::make('P360', Patient::query()->where('type', 'P360')->count()),
            Stat::make('P560', Patient::query()->where('type', 'P560')->count()),

        ];
    }
}
