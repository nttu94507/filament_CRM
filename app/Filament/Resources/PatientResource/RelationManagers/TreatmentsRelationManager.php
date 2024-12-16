<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TreatmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->maxValue(42949672.95),
                FileUpload::make('image')
                    ->visibility('private')
                    ->disk('private')
                    ->directory(fn(?Treatment $record = null) => $record ? "$record->case_id" : null)
                    ->image()
                    ->formatStateUsing(fn(?Treatment $record = null) => $record
                        ? ['url' => "$record->image"] : []
                    ),
                //                    ->disk('public')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('price')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\ImageColumn::make('image'),
                //                fileUpload::make('image')
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

    protected function handleRecordCreation(array $data): array
    {
        dd($data);

        return [
            Actions\ImportAction::make()
                ->importer(UserImporter::class),
        ];
    }
}
