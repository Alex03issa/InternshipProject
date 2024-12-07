<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image_url')
                    ->label('Image')
                    ->preserveFilenames() 
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('uploads') 
                    ->visibility('private')
                    ->columnSpanFull() 
                    ->image()
                    ->required()
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']) // Restrict types
                    ->maxSize(2048) // Limit file size to 2MB
                    ->alignment('center'),
                TextInput::make('name')
                    ->required()
                    ->label('Name')
                    ->maxLength(255)
                    ->columnSpan(6),
                TextInput::make('position')
                    ->required()
                    ->label('Position')
                    ->maxLength(255)
                    ->columnSpan(6),
                Textarea::make('quote')
                    ->label('Quote')
                    ->maxLength(500)
                    ->columnSpan(12),
            ])
            ->columns(12); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->rounded(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position')
                    ->label('Position')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quote')
                    ->label('Quote')
                    ->limit(50),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
