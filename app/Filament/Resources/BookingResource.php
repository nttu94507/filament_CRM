<?php

namespace App\Filament\Resources;

use App\BookingType;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\User;
use App\Models\Coach;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationLabel = '預約管理';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = '課程系統';

    public static function form( $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('學員')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('type')
                    ->label('課程類型')
                    ->options([
                        'experience' => '體驗課',
                        'practice' => '自行練習',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('location')->label('地點')->required(),
                Forms\Components\DatePicker::make('date')->label('日期')->required(),
                Forms\Components\TimePicker::make('time')->label('開始時間')->required(),
                Forms\Components\TextInput::make('duration')->label('時長 (分鐘)')->numeric()->required(),

                Forms\Components\Select::make('status')
                    ->label('狀態')
                    ->options([
                        'booked' => '已預約',
                        'cancelled' => '已取消',
                        'attended' => '已完成',
                    ])
                    ->required(),

                Forms\Components\Select::make('coach_id')
                    ->label('教練')
                    ->relationship('coach', 'name')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Textarea::make('notes')->label('備註')->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('學員')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('類型')->formatStateUsing(fn ($state) => BookingType::from($state)->label()),
                Tables\Columns\TextColumn::make('location')->label('地點'),
                Tables\Columns\TextColumn::make('date')->label('日期')->date(),
                Tables\Columns\TextColumn::make('time')->label('時間'),
                Tables\Columns\TextColumn::make('duration')->label('時長')->suffix(' 分鐘'),
                Tables\Columns\TextColumn::make('coach.name')->label('教練'),
                Tables\Columns\TextColumn::make('status')->label('狀態')->badge()->color(fn ($state) => match ($state) {
                    'booked' => 'info',
                    'attended' => 'success',
                    'cancelled' => 'danger',
                }),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('課程類型')
                    ->options([
                        'experience' => '體驗課',
                        'practice' => '自行練習',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('狀態')
                    ->options([
                        'booked' => '已預約',
                        'attended' => '已完成',
                        'cancelled' => '已取消',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
