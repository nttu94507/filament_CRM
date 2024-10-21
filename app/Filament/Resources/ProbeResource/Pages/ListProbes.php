<?php

namespace App\Filament\Resources\ProbeResource\Pages;

use App\Filament\Resources\ProbeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProbes extends ListRecords
{
    protected static string $resource = ProbeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
