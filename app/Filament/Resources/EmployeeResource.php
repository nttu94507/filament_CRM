<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationLabel = '人事管理';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name'),
                        TextInput::make('email')
                            ->label('Email'),
                        TextInput::make('phone')
                            ->label('Phone'),
                        TextInput::make('address')
                            ->label('Address')
                            ->columnSpan(2),
                        DateTimePicker::make('start_date')
                            ->label('Start Date')
                            ->columnSpan(2),
                        //                TextInput::make('salary')
                        //                ->label('Salary'),
                        //                        Select::make('status')
                        //                            ->label('Status')
                        //                        ->options([
                        //                            0 => 'Active',
                        //                            1 => 'Off',
                        //                        ]),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                //                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('start_date'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->color(fn(Employee $record) => match ($record->status) {
                        'active' => 'success',
                        default => 'info'
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at'),
                //                Tables\Columns\TextColumn::make('updated_at'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
