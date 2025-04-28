<?php

namespace App\Filament\Reserve\Resources;

use App\BookingType;
use App\Filament\Reserve\Resources\BookingResource\Pages;
use App\Filament\Reserve\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
//    protected static ?string $navigationIcon = 'heroicon-o-collection';
//    protected static ?string $navigationGroup = '預約';

    public static function getNavigationLabel(): string
    {
        return __('reserve.booking.sidebar');
        // 👈 可以用語系檔，或直接回傳字串
//        return '預約管理';
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('reserve.form.name'))
                ->required(),
                Forms\Components\Select::make('booking_type')
                    ->default(BookingType::Experience->value)
                    ->label(__('reserve.form.booking_type'))
                    ->options(BookingType::class)
                    ->required()
                    ->reactive()
                    ->placeholder(null)
                    ->afterStateUpdated(fn (callable $set) => $set('time', null)),

                Forms\Components\Select::make('time')
                    ->label(__('reserve.form.time'))
                    ->options(function (callable $get) {
                        $bookingType = $get('booking_type');

                        if ($bookingType === BookingType::Experience->value) {
                            return [
                                '09:00:00' => '09:00',
                                '13:00:00' => '13:00',
                                '15:00:00' => '15:00',
                            ];
                        }

                        if ($bookingType === BookingType::Practice->value) {
                            // 產生從 06:00 到 16:00 的每小時選項
                            return collect(range(6, 16))
                                ->mapWithKeys(fn ($hour) => [
                                    str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00:00' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                                ])
                                ->toArray();
                        }

                        return [];
                    })
                    ->default('09:00:00')
                    ->required()
                    ->placeholder(null)
                    ->reactive(),
                Forms\Components\TextInput::make('people_count')
                    ->label(__('reserve.form.people_count')) // 👈 語系（等一下我給你範例）
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->maxValue(10)
                    ->required(),
                Forms\Components\Textarea::make('note')
                ->label(__('reserve.form.note'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
