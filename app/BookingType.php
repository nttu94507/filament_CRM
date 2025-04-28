<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum BookingType: string implements HasLabel
{
    case Experience = 'experience';
    case Practice = 'practice';

    public function getLabel(): ?string
    {
        return match($this) {
            self::Experience => __('reserve.booking_type.experience'),
            self::Practice => __('reserve.booking_type.practice'),
        };
    }
}