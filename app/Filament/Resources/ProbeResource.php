<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProbeResource\Pages;
use App\Filament\Resources\ProbeResource\RelationManagers;
use App\Models\Manufacturer;
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

    protected static ?string $navigationLabel = '庫存管理';

    protected static ?string $modelLabel = 'probes';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Section::make('add Probe')
                ->schema([
                    TextInput::make('probe_id')
                        ->label('Probe ID')
                        ->required()
                        ->maxLength(255),
                    Select::make('type')
                        ->label('型號')
                        ->options([
                            'P110' => 'P110',
                            'P110+' => 'P110+',
                            'P120' => 'P120',
                            'P140' => 'P140',
                            'P220' => 'P220',
                            'P360' => 'P360',
                            'P560' => 'P560',
                        ])->required(),
                    TextInput::make('cost')
                    ->label('成本'),
                    Forms\Components\DatePicker::make('date_of_shipment')
                        ->label('進貨日')
                        ->required()
//                        ->maxDate(now())
                        ->default(now()),
                    Forms\Components\DatePicker::make('date_of_manufacturing')
                        ->label('製造日')
                        ->required()
//                        ->maxDate(now())
                        ->default(now()),
//                    Select::make('manufacturer')
//                        ->label('廠商')
//                        ->options([
//                            'eui' => 'EUI',
//                            'google' => 'Google',
//                        ])
//                        ->required(),
                    Forms\Components\Select::make('manufacturer_id')
                        ->label('製造商')
                        ->relationship('Manufacturer', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->label('廠商名稱')
                                ->required()
                                ->inlineLabel()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('phone')
                                ->label('手機')
                                ->tel()
                                ->required()
                                ->inlineLabel()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('address')
                                ->label('廠商地址')
//                                ->tel()
                                ->inlineLabel()
                                ->required(),
                            Forms\Components\TextInput::make('tax_number')
                                ->label('統一編號')
                                ->tel()
                                ->inlineLabel()
                                ->required(),
                        ])
                        ->required(),
                ])
                ->columns(2)
                ->inlineLabel()
            ]);
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
                Tables\Columns\TextColumn::make('manufacturer_id')
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('新增')
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('編輯'),
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
