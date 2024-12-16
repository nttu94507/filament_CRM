<?php

namespace App\Filament\Resources\ProbeResource\Pages;

use App\Filament\Resources\ProbeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProbe extends CreateRecord
{
    protected static string $resource = ProbeResource::class;

    protected static ?string $title = '新增probe';

    protected static bool $canCreateAnother = false;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('送出'),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            $this->getCancelFormAction()
                ->label('取消'),
        ];
    }
}
