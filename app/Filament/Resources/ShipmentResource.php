<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Probe;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationLabel = '出貨管理';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('action_type')
                            ->label('出貨類型')
                            ->options([
                                0 => '出貨',
                                1 => '換貨',
                                2 => '借測',
                                3 => '退貨',
                            ])
                            ->required(),
                        Forms\Components\Select::make('customer_id')
                            ->label('客戶名稱')
                            ->relationship('customer', 'company_name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('company_name'),
                                Forms\Components\TextInput::make('company_address'),
                                Forms\Components\TextInput::make('company_phone'),
                            ])
                            ->required(),
                        Forms\Components\Select::make('probes')
                            ->label('Probes')
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
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Forms\Get $get) {
                                $total = 0;
                                foreach ($state as $probe) {
                                    $cost = Probe::find($probe)->cost;
                                    $total += $cost;
                                }
                                $set('total', $total);
                            })
                            ->searchable()
                            ->multiple()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('total')
                            ->label('總成本')
                            ->default(0)
                            ->readOnly(),
                        Forms\Components\TextInput::make('note')
                            ->label('備註'),
                    ])
                    ->columns('2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('action_type')
                    ->label('出貨方式')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '0' => '出貨',
                        '1' => '換貨',
                        '2' => '借測',
                        '3' => '退貨',

                    })
                    ->color(fn(string $state): string => match ($state) {
                        '0' => 'success',
                        '1' => 'warning',
                        '2' => 'gray',
                        '3' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('customer.company_name'),
                Tables\Columns\TextColumn::make('shipment_items_count')
                    ->label('probe 數量')
                    ->counts('shipment_items'),
                Tables\Columns\TextColumn::make('total')
                    ->label('總成本'),
                Tables\Columns\TextColumn::make('note')
                    ->label('備註'),

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
        ];
    }
}
