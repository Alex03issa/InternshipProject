<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackgroundResource\Pages;
use App\Models\Background;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class BackgroundResource extends Resource
{
    protected static ?string $model = Background::class;
    protected static ?string $navigationGroup = 'Game Content';

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('background_name')
                    ->label('Background Name')
                    ->required(),
                Forms\Components\FileUpload::make('background_image')
                    ->label('Image')
                    ->directory('uploads')
                    ->preserveFilenames()
                    ->visibility('public')
                    ->image(),
                Forms\Components\TextInput::make('cost')
                    ->label('Cost (Coins)')
                    ->numeric()
                    ->rules(['min:0'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('background_name')
                    ->label('Background Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Cost (Coins)')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Image'),
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
            'index' => Pages\ListBackgrounds::route('/'),
            'create' => Pages\CreateBackground::route('/create'),
            'edit' => Pages\EditBackground::route('/{record}/edit'),
        ];
    }
}
