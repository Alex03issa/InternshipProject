<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrophyResource\Pages;
use App\Models\Trophy;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

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
                    ->image()
                    ->directory('trophy_icons')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp','image/x-icon'])
                    ->maxSize(2048)
                    ->visibility('private'),

                Forms\Components\TextInput::make('unlock_points')
                    ->label('Unlock Points')
                    ->numeric()
                    ->rules(['required', 'min:0'])
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
                    ->limit(50)
                    ->tooltip(fn ($state) => $state),

                Tables\Columns\ImageColumn::make('icon')
                    ->label('Icon')
                    ->url(fn ($record) => $record->icon ? url(Storage::url($record->icon)) : null)
                    ->placeholder('No Icon'),

                Tables\Columns\TextColumn::make('unlock_points')
                    ->label('Unlock Points')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state)),
            ])
            ->filters([
                Tables\Filters\Filter::make('unlock_points')
                    ->form([
                        Forms\Components\TextInput::make('min')
                            ->label('Minimum Points'),
                        Forms\Components\TextInput::make('max')
                            ->label('Maximum Points'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['min'])) {
                            $query->where('unlock_points', '>=', $data['min']);
                        }
                        if (isset($data['max'])) {
                            $query->where('unlock_points', '<=', $data['max']);
                        }
                    })
                    ->label('Unlock Points Range'),
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
                Tables\Actions\BulkAction::make('mark_as_featured')
                    ->label('Mark as Featured')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->update(['featured' => true]);
                        }
                        Notification::make()
                            ->title('Trophies marked as Featured!')
                            ->success()
                            ->send();
                    })
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
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
