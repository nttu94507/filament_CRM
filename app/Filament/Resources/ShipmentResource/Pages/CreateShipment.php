<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use App\Models\Probe;
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

        //        dd($data['probes']);

        foreach ($data['probes'] as $key => $probe) {
            //            dd($probe);
            $shipment_item = new ShipmentItem;
            $shipment_item->shipment_id = $shipment->id;
            $shipment_item->probe_id = $probe;
            $shipment_item->save();
        }

        //依據action_type 更新所有probe 狀態
        switch ($data['action_type']) {
            case '1':
                Probe::query()
                    ->whereIn('id', $data['probes'])
                    ->update(['status' => 1]);
                break;
            case '2':
                Probe::query()
                    ->whereIn('id', $data['probes'])
                    ->update(['status' => 4]);

                break;
            case '3':
                Probe::query()
                    ->whereIn('id', $data['probes'])
                    ->update(['status' => 2]);

                break;
            case '4':
                Probe::query()
                    ->whereIn('id', $data['probes'])
                    ->update(['status' => 4]);
                break;

        }

        return $shipment;
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
