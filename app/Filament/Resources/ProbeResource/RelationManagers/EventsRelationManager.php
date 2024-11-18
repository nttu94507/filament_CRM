<?php

namespace App\Filament\Resources\ProbeResource\RelationManagers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EventsRelationManager extends RelationManager
{
    protected static string $relationship = 'Events';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('description'),
//                TextInput::make('price'),

//                Tables\Columns\TextColumn::make('description')
//                TextInput::make('price')
//                    ->money('PHP')
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime(),
            ]);
//            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
//            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
