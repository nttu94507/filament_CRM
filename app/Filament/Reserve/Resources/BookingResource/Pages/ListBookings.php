<?php

namespace App\Filament\Reserve\Resources\BookingResource\Pages;

use App\Filament\Reserve\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    public function getTitle(): string
    {
        return __('reserve.list.booking'); // 🚀 用語系檔
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
