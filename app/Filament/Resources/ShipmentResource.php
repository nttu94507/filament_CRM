<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Probe;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
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
                                1 => '出貨',
                                2 => '換貨',
                                3 => '借測',
                                4 => '退貨',
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
                            ->getSearchResultsUsing(function (string $search, callable $get) {
                                switch ($get('action_type')) {
                                    case 1:
                                    case 3:
                                        return Probe::query()
                                            ->where(function (Builder $builder) use ($search) {
                                                $searchString = "%$search%";
                                                $builder->where('probe_id', 'like', $searchString)
                                                    ->orWhere('type', 'like', $searchString);
                                            })
                                            ->where('status', '=', '0')
                                            ->orderBy('status')
                                            ->limit(50)
                                            ->get()
                                            ->mapWithKeys(fn($probe) => [$probe->id => $probe->probe_id.'-'.$probe->type.' '.self::getstatus($probe->status)])
                                            ->toArray();
                                        break;
                                    case 2:
                                    case 4:
                                        return Probe::query()
                                            ->where(function (Builder $builder) use ($search) {
                                                $searchString = "%$search%";
                                                $builder->where('probe_id', 'like', $searchString)
                                                    ->orWhere('type', 'like', $searchString);
                                            })
                                            ->where('status', '=', ['1', '3'])
                                            ->orderBy('status')
                                            ->limit(50)
                                            ->get()
                                            ->mapWithKeys(fn($probe) => [$probe->id => $probe->probe_id.'-'.$probe->type.' '.self::getstatus($probe->status)])
                                            ->toArray();

                                }

                            })
                            ->options(function (callable $get) {
                                //                                switch ($get('action_type')) {
                                //                                    case 1:
                                //                                    case 3:
                                //                                        return Probe::query()
                                //                                            ->where(function (Builder $builder) use ($search) {
                                //                                                $searchString = "%$search%";
                                //                                                $builder->where('probe_id', 'like', $searchString)
                                //                                                    ->orWhere('type', 'like', $searchString);
                                //                                            })
                                //                                            ->where('status','=','0')
                                //                                            ->orderBy('status')
                                //                                            ->limit(50)
                                //                                            ->get()
                                //                                            ->mapWithKeys(fn($probe) => [$probe->id => $probe->probe_id . '-' . $probe->type . ' ' . self::getstatus($probe->status)])
                                //                                            ->toArray();
                                //                                        break;
                                //                                    case 2:
                                //                                    case 4:
                                //                                        return Probe::query()
                                //                                            ->where(function (Builder $builder) use ($search) {
                                //                                                $searchString = "%$search%";
                                //                                                $builder->where('probe_id', 'like', $searchString)
                                //                                                    ->orWhere('type', 'like', $searchString);
                                //                                            })
                                //                                            ->where('status','=',['1','3'])
                                //                                            ->orderBy('status')
                                //                                            ->limit(50)
                                //                                            ->get()
                                //                                            ->mapWithKeys(fn($probe) => [$probe->id => $probe->probe_id . '-' . $probe->type . ' ' . self::getstatus($probe->status)])
                                //                                            ->toArray();
                                //
                                //                                }
                                switch ($get('action_type')) {
                                    case 1:
                                    case 3:
                                        return Probe::query()
                                            ->where('status', '=', '0')
                                            ->get()
                                            ->mapWithKeys(function ($probe) {
                                                return [$probe->id => $probe->probe_id.'-'.$probe->type.' '.self::getstatus($probe->status)];
                                            })->toArray();

                                    case 2:
                                    case 4:
                                        return Probe::query()
                                            ->where('status', '=', '1')
                                            ->orWhere('status', '=', '2')
//                                       ->orWhere('status', '=', '3' )
                                            ->get()
                                            ->mapWithKeys(function ($probe) {
                                                return [$probe->id => $probe->probe_id.'-'.$probe->type.' '.self::getstatus($probe->status)];
                                            })->toArray();
                                }
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
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
                    ->inlineLabel()
                    ->columns('2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('action_type')
                    ->label('類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => '出貨',
                        '2' => '換貨',
                        '3' => '借測',
                        '4' => '退貨',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '2' => 'warning',
                        '3' => 'gray',
                        '4' => 'danger',
                    })
                    ->weight(FontWeight::ExtraBold)
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('狀態')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => '進行中',
                        '2' => '已完成',
                        '3' => '已取消',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('case_id')
                    ->label('出貨單號')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipment_items_count')
                    ->label('probe 數量')
                    ->counts('shipment_items'),
                Tables\Columns\TextColumn::make('total')
                    ->label('總成本')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->label('備註')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('test')
                    ->form([
                        Forms\Components\TextInput::make('case_id')
                            ->label('出貨單號')
                            ->columnSpan(1)
                            ->inlineLabel(),
                        Forms\Components\Select::make('status')
                            ->label('狀態')
                            ->options([
                                '1' => '進行中',
                                '2' => '已完成',
                                '3' => '已取消',
                            ])
                            ->columnSpan(1)
                            ->inlineLabel(),

                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['case_id'],
                                fn(Builder $query, $data): Builder => $query->where('case_id', 'like', '%'.$data.'%'),
                            )
                            ->when(
                                $data['status'],
                                fn(Builder $query, $data): Builder => $query->where('status', '=', $data),
                            );
                    }),
            ],
                layout: Tables\Enums\FiltersLayout::AboveContent
            )
            ->recordUrl(false)
            ->actions([
                Tables\Actions\ViewAction::make('view')
                    ->button(),
                //                    ->color('warning'),
                Tables\Actions\Action::make('completed')
                    ->label('完成')
                    ->color(Color::Emerald)
                    ->action(fn(Shipment $record) => $record->update(['status' => 1]))
                    ->requiresConfirmation()
                    ->button()
                    ->disabled(fn(Shipment $record) => $record->status !== 1 ? true : false),
                Tables\Actions\Action::make('delete')
                    ->label('取消')
                    ->color('danger')
                    ->button()
//                    ->action(fn(Shipment $record) => $record->update(['status' => 2]))
                    ->requiresConfirmation()
                    ->disabled(fn(Shipment $record) => $record->status !== 1 ? true : false)
                    ->action(function (Shipment $record) {
                        $record->shipment_items()->delete();
                        $record->delete();
                    }),
            ])
            ->bulkActions([
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make(),
                //                ]),
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
            'view' => Pages\ViewShipment::route('/{record}'),
        ];
    }

    //    private  function getstatus(string $status): string
    //    {
    //
    //    }

    private static function getstatus($status)
    {
        switch ($status) {
            case '1':
                return '出貨';
            case '2':
                return '借出';
            case '3':
                return '待修';
            case '4':
                return '故障';
            default:
                return '在庫';

        }
    }
}
