<?php

namespace App\Filament\Reserve\Resources\BookingResource\Pages;

use App\Filament\Reserve\Resources\BookingResource;
use App\Models\Booking;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;

class BookingCheckPage extends Page
{
    protected static string $resource = BookingResource::class;

    protected static string $view = 'filament.reserve.resources.booking-resource.pages.booking-check-page';
    protected static ?string $navigationIcon = null;
//    protected static string $view = 'filament.pages.booking-check-page';
    protected static bool $shouldRegisterNavigation = false;

    public ?Booking $booking = null;
    public string $editDate = '';
    public string $editTime = '';

    public function mount(Request $request)
    {
        if ($request->filled(['phone', 'booking_code'])) {
            $this->booking = Booking::where('phone', $request->input('phone'))
                ->where('booking_code', strtoupper($request->input('booking_code')))
                ->first();

            if ($this->booking) {
                $this->editDate = $this->booking->date;
                $this->editTime = $this->booking->time;
            }
        }
    }

    public function deleteBooking()
    {
        if ($this->booking) {
            $this->booking->delete();
            $this->booking = null;
            session()->flash('success', '預約已取消');
        }
    }

    public function updateBooking()
    {
        if (!$this->booking) {
            session()->flash('success', '查無預約');
            return;
        }

        $this->validate([
            'editDate' => 'required|date',
            'editTime' => 'required|date_format:H:i:s',
        ]);

        $this->booking->update([
            'date' => $this->editDate,
            'time' => $this->editTime,
        ]);

        session()->flash('success', '預約時間已更新！');
    }
}
