<?php

namespace App\Filament\Reserve\Resources\BookingResource\Pages;

use App\Filament\Reserve\Resources\BookingResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;


    public function getTitle(): string
    {
        return __('reserve.title.View_booking'); // 🚀 用語系檔
    }
}
