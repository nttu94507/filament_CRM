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
                TextInput::make('probe_id')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->options([
                        'P110' => 'P110',
                        'P120' => 'P120',
                        'P360' => 'P360',
                    ])->required(),
                Forms\Components\DatePicker::make('date_of_shipment')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'company_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('company_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company_phone')
                            ->label('Phone number')
                            ->tel()
                            ->required(),
                    ])
                    ->required(),

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
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('date_of_shipment')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.company_name')
                    ->searchable(),

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
