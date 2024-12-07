<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkinResource\Pages;
use App\Models\Skin;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class SkinResource extends Resource
{
    protected static ?string $model = Skin::class;
    protected static ?string $navigationGroup = 'Game Content';

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('skin_name')
                    ->label('Skin Name')
                    ->required(),
                Forms\Components\FileUpload::make('skin_image')
                    ->label('Image')
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
                Tables\Columns\TextColumn::make('skin_name')
                    ->label('Skin Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Cost (Coins)')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('skin_image')
                    ->directory('uploads')
                    ->preserveFilenames()
                    ->visibility('private')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']) 
                    ->maxSize(2048)
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
            'index' => Pages\ListSkins::route('/'),
            'create' => Pages\CreateSkin::route('/create'),
            'edit' => Pages\EditSkin::route('/{record}/edit'),
        ];
    }
}
