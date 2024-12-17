<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Probe;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('action_type')
                    ->options([
                        0 => '出貨',
                        1 => '換貨',
                        2 => '借測',
                        3 => '退貨',
                    ]),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'company_name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('company_name'),
                        Forms\Components\TextInput::make('company_address'),
                        Forms\Components\TextInput::make('company_phone'),
                    ]),
                Forms\Components\Select::make('probes')
                    ->relationship(
                        name: 'probe',
                        titleAttribute: 'probe_id',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('id'),
                    )
                    ->getSearchResultsUsing(fn(string $search): array => Probe::all()->limit(50)->pluck('probe_id', 'id')->toArray())
                    ->getOptionLabelFromRecordUsing(fn(Probe $record) => "{$record->probe_id}.'      '.{$record->type}")
                    ->searchable()
//                    ->createOptionForm([
//                        Forms\Components\TextInput::make('name'),
//                    ])
                    ->preload(),

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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
            'new' => Pages\NewCreateShipment::route('/new'),
        ];
    }
}
