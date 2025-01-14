<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum ShipmentStatus: int implements HasLabel
{
    //
    //        case reserve = 99; //預定
    case shipped = 1; //出貨
    //    case replace = 2; //換貨
    case lend = 3; //借出
    case returned = 4; //歸還/

    public function getLabel(): ?string
    {
        return match ($this) {
            self::shipped => '出貨',
            self::returned => '歸還',
            //            self::replace => '換貨',
            self::lend => '借出',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::shipped => '出貨',
            self::returned => '退貨',
            //            self::replace => '換貨',
            self::lend => '借出',
        };
    }
}
