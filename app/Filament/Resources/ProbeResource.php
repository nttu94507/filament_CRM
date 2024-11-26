<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProbeResource\Pages;
use App\Filament\Resources\ProbeResource\RelationManagers;
use App\Models\Probe;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProbeResource extends Resource
{
    protected static ?string $model = Probe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Section::make('add Probe')
                ->schema([
                    TextInput::make('probe_id')
                        ->required()
                        ->maxLength(255),
                    Select::make('type')
                        ->options([
                            'P110' => 'P110',
                            'P110+' => 'P110+',
                            'P120' => 'P120',
                            'P140' => 'P140',
                            'P220' => 'P220',
                            'P360' => 'P360',
                            'P560' => 'P560',
                        ])->required(),
                    Forms\Components\DatePicker::make('date_of_shipment')
                        ->required()
//                        ->maxDate(now())
                        ->default(now()),
                    TextInput::make('cost'),
                    Select::make('manufacturer')
                    ->options([
                        'eui' => 'EUI',
                        'google' => 'Google',
                    ])
//                    Forms\Components\Select::make('customer_id')
//                        ->relationship('customer', 'company_name')
//                        ->searchable()
//                        ->preload()
//                        ->createOptionForm([
//                            Forms\Components\TextInput::make('company_name')
//                                ->required()
//                                ->maxLength(255),
//                            Forms\Components\TextInput::make('email')
//                                ->label('Email address')
//                                ->email()
//                                ->required()
//                                ->maxLength(255),
//                            Forms\Components\TextInput::make('company_phone')
//                                ->label('Phone number')
//                                ->tel()
//                                ->required(),
//                        ])
//                        ->required(),
                ])
                ->columns(5)
            ]);
        //            ->columnSpan(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('probe_id')
                    ->searchable()
                    ->label('ProbeID'),
                Tables\Columns\TextColumn::make('type')
                    ->label('型號')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_shipment')
                    ->label('進貨日')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Manufacturer')
                    ->label('廠商')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost')
                ->label('成本')
                ->sortable(),
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
            RelationManagers\EventsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProbes::route('/'),
            'create' => Pages\CreateProbe::route('/create'),
            'edit' => Pages\EditProbe::route('/{record}/edit'),
        ];
    }
}
