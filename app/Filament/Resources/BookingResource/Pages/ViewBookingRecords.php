<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Models\Booking;
use App\Models\User;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ViewBookingRecords extends Page
{
    use InteractsWithTable;
    use InteractsWithRecord;

    protected static string $resource = \App\Filament\Resources\BookingResource::class;

    protected static string $view = 'filament.resources.booking-resource.pages.view-booking-records';

    public function getTitle(): string
    {
        return '查看預約紀錄 - ' . $this->record->user->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()->where('user_id', $this->record->user_id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('類型'),
                Tables\Columns\TextColumn::make('location')->label('地點'),
                Tables\Columns\TextColumn::make('date')->label('日期')->date(),
                Tables\Columns\TextColumn::make('time')->label('時段'),
                Tables\Columns\TextColumn::make('status')->label('狀態'),
            ]);
    }
}

