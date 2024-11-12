<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrophyResource\Pages;
use App\Models\Trophy;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class TrophyResource extends Resource
{
    protected static ?string $model = Trophy::class;
    protected static ?string $navigationGroup = 'Game Content';

    protected static ?string $navigationIcon = 'heroicon-o-document';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('trophy_name')
                    ->label('Trophy Name')
                    ->required(),
                Forms\Components\Textarea::make('trophy_description')
                    ->label('Description')
                    ->rows(3),
                Forms\Components\FileUpload::make('icon')
                    ->label('Icon')
                    ->image(),
                Forms\Components\TextInput::make('unlock_points')
                    ->label('Unlock Points')
                    ->numeric()
                    ->rules(['min:0'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trophy_name')
                    ->label('Trophy Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('trophy_description')
                    ->label('Description')
                    ->limit(50),
                Tables\Columns\ImageColumn::make('icon')
                    ->label('Icon'),
                Tables\Columns\TextColumn::make('unlock_points')
                    ->label('Unlock Points')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('')
                    ->size('xl'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrophies::route('/'),
            'create' => Pages\CreateTrophy::route('/create'),
            'edit' => Pages\EditTrophy::route('/{record}/edit'),
        ];
    }
}
