<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShipments extends ListRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    //    protected function mutateFormDataBeforeFill(array $data): array
    //    {
    //        dd($data);
    //
    //        $data['user_id'] = auth()->id();
    //
    //        return $data;
    //    }
}
