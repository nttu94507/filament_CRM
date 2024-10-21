<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use App\Filament\Imports\ProductImporter;
//use App\Actions\ResetStars;
use Filament\Forms\Components\Actions\Action;
//use Filament\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Symfony\Component\Console\Input\Input;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('All Users')
                            ->schema([
                                Forms\Components\Section::make()
                                ->columns([
                                    'sm' => 3,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                ->schema([
                                    TextInput::make('title')
                                        ->columnSpan([
                                            'sm' => 2,
                                            'xl' => 3,
                                            '2xl' => 12,
                                        ]),
                                    Textarea::make('content')
                                        ->columnSpan([
                                            'sm' => 2,
                                            'xl' => 3,
                                            '2xl' => 12,
                                        ]),
                                ])
                            ]),
                        Tabs\Tab::make('Specific Users  ')
                            ->schema([
                                // ...

                                Select::make('User Group')
                                    ->options([
                                        '1' => 'All Users',
                                        '2' => 'Android Users',
                                        '3' => 'iOS',
                                        '4' => 'Logout',
                                    ]),
                                Forms\Components\Section::make()
                                    ->columns([
                                        'sm' => 3,
                                        'xl' => 6,
                                        '2xl' => 8,
                                    ])
                                    ->schema([
                                        TextInput::make('title')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 12,
                                            ]),
                                        Textarea::make('content')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 12,
                                            ]),
                                    ])
                            ]),
                        Tabs\Tab::make('CSV List Upload')
                            ->schema([
                                // ...
                                Forms\Components\Section::make()
                                    ->columns([
                                        'sm' => 3,
                                        'xl' => 6,
                                        '2xl' => 8,
                                    ])
                                    ->schema([
                                       Forms\Components\FileUpload::make('CSV File')
                                           ->columnSpan([
                                               'sm' => 2,
                                               'xl' => 3,
                                               '2xl' => 12,
                                           ])
                                            ->label('CSV File'),
                                        TextInput::make('title')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 12,
                                            ]),
                                        Textarea::make('content')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 12,
                                            ]),
                                    ])
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 2,
                        'xl' => 3,
                        '2xl' => 1,
                    ]),
//
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('target')
                    ->searchable()
                    ->label('Target'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ImportAction::make()
                    ->importer(ProductImporter::class),
                Action::make('edit')
                    ->button()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
//            ->headerActions([
//            ImportAction::make()
//                ->importer(ProductImporter::class)
//    ]);
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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
