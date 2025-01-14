<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProbeStatus: int implements HasColor, HasLabel
{
    //
    case reserve = 99; //預定
    case inStock = 1; //有庫存
    case shipped = 2; //已出貨
    case returned = 3; //退回待修
    case fault = 4; //故障
    case lent = 5; //借出

    public function getLabel(): ?string
    {
        return match ($this) {
            self::inStock => '庫存',
            self::reserve => '已預定',
            self::shipped => '已出貨',
            self::returned => '退貨',
            self::fault => '故障',
            self::lent => '已借出',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::inStock => 'success',
            self::reserve => 'danger',
            self::shipped => 'warning',
            self::returned => 'gray',
            self::fault => 'danger',
            self::lent => 'info',
        };
    }
}
