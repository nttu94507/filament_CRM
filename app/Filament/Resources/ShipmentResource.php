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
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('action_type')
                            ->options([
                                0 => '出貨',
                                1 => '換貨',
                                2 => '借測',
                                3 => '退貨',
                            ])
                            ->required(),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'company_name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('company_name'),
                                Forms\Components\TextInput::make('company_address'),
                                Forms\Components\TextInput::make('company_phone'),
                            ])
                            ->required(),
                        Forms\Components\Select::make('probes')
                            ->getSearchResultsUsing(function (string $search): array {
                                return Probe::query()
                                    ->where(function (Builder $builder) use ($search) {
                                        $searchString = "%$search%";
                                        $builder->where('probe_id', 'like', $searchString)
                                            ->orWhere('type', 'like', $searchString);
                                    })
                                    ->orderBy('date_of_manufacturing')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn($probe) => [$probe->id => $probe->probe_id.'-'.$probe->type])
                                    ->toArray();
                            })
                            ->options(Probe::all()
                                ->mapWithKeys(function ($probe) {
                                    return [$probe->id => $probe->probe_id.'-'.$probe->type];
                                })->toArray()
                            )
                            ->searchable()
                            ->multiple()
                            ->preload()
//                            ->columnSpan('2')
                            ->required(),
                        Forms\Components\TextInput::make('note')

                    ])
//                    ->
//                    ->columns('2')
            ]);

//            ->inlineLabel();


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
