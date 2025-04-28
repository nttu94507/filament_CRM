<?php

namespace App\Filament\Reserve\Resources\BookingResource\Pages;

use App\Filament\Reserve\Resources\BookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
    public function getTitle(): string
    {
        return __('reserve.form.create_booking'); // 🚀 用語系檔
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
            ->label(__('reserve.form.submit')), // 只拿預設「送出」按鈕
            $this->getCancelFormAction()
            ->label(__('reserve.form.cancel'))
        ];
    }

    protected function formActions()
    {

    }

}
