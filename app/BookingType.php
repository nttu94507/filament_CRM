<?php

namespace App;

enum BookingType: string
{
    case Experience = 'experience';
    case Practice = 'practice';

    public function label(): string
    {
        return match($this) {
            self::Experience => '體驗課',
            self::Practice => '自行練習',
        };
    }
}