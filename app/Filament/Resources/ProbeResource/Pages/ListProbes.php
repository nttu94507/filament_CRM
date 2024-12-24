<?php

namespace App\Filament\Resources\ProbeResource\Pages;

use App\Filament\Resources\ProbeResource;
use Filament\Resources\Pages\ListRecords;

class ListProbes extends ListRecords
{
    protected static string $resource = ProbeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        //        dd($data);

        $data['user_id'] = auth()->id();

        return $data;
    }
}
