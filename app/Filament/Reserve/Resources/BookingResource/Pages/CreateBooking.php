<?php

namespace App\Filament\Reserve\Resources\BookingResource\Pages;

use App\Filament\Reserve\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Holiday;
use Filament\Resources\Pages\CreateRecord;
use Nette\Schema\ValidationException;

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $date = $data['date'];
        $time = $data['time'];
        $phone = $data['phone'];
        $peopleCount = $data['people_count'];
        $type = $data['booking_type'];
        $maxPeople = 10;

        $holiday = Holiday::where('date', $data['date'])->first();

        if ($holiday) {
            $bookingTime = $data['time'];

            if (is_null($holiday->start_time)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'date' => '此日期場地休息，無法預約。',
                ]);
            }

            if ($bookingTime >= $holiday->start_time) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'time' => '場地該日從 ' . substr($holiday->start_time, 0, 5) . ' 起休息，請選擇較早時段。',
                ]);
            }
        }

        // 2. 檢查同手機同時段是否已預約
        $duplicate = Booking::where('phone', $phone)
            ->where('date', $date)
            ->where('time', $time)
            ->exists();

        if ($duplicate) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'time' => '您已預約該時段，請勿重複預約。',
            ]);
        }

        // 3. 檢查人數名額是否已滿
        if($type == 'experience')
        {
            $currentCount = Booking::where('date', $date)
                ->where('time', $time)
                ->sum('people_count');

            if (($currentCount + $peopleCount) > $maxPeople) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'people_count' => '此時段名額已滿，請選擇其他時間。',
                ]);
            }
        }
        return $data;
    }


}
