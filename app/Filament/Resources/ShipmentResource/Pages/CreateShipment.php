<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use App\Models\Shipment;
use Filament\Resources\Pages\CreateRecord;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $shipment_counts = Shipment::query()->whereDate('created_at', now()->toDateString())->count() + 1;
        $serial_no = str_pad($shipment_counts, 5, 0, STR_PAD_LEFT);
        $data['user_id'] = auth()->id();
        $data['case_id'] = 'PIXIS'.date('ymd').$serial_no;
        dd($data);

        return $data;
    }
}
