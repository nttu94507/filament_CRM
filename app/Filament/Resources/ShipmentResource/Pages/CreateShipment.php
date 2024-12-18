<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $ShipmentTodayCounts = Shipment::whereDate('created_at', now()->toDateString())->count() + 1;
        $serial_no = str_pad($ShipmentTodayCounts, 5, 0, STR_PAD_LEFT);
        $case_no = 'PIXIS'.date('ymd').$serial_no;

        $shipment = new Shipment;
        $shipment_info = $data;
        unset($shipment_info['probes']);

        $shipment->fill($shipment_info);
        $shipment->user_id = auth()->id();
        $shipment->case_id = $case_no;
        $shipment->save();

        dd($shipment->id);

        foreach ($data['probes'] as $shipment_item) {
            $shipment_item = new ShipmentItem;
            $shipment_item->shipment_id = $shipment->id;
        }
        $shipment_item = new ShipmentItem;
        return static::getModel()::create($data);
    }

    //    protected function mutateFormDataBeforeCreate(array $data): array
    //    {
    //        $shipment_counts = Shipment::query()->whereDate('created_at', now()->toDateString())->count() + 1;
    //        $serial_no = str_pad($shipment_counts, 5, 0, STR_PAD_LEFT);
    //        $data['user_id'] = auth()->id();
    //        $data['case_id'] = 'PIXIS'.date('ymd').$serial_no;
    //        //        dd($data);
    //
    //        return $data;
    //    }
}
