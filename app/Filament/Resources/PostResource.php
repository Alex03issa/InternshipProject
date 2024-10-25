<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set; 
use Str;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Grid::make(2)
                    ->schema([

                        Forms\Components\TextInput::make('title')
                            ->maxLength(2048)
                            ->lazy()
                            ->afterStateUpdated(function (Set $set, $state) { 
                                $set('slug', Str::slug($state));  
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->maxLength(2048),
                        ]),

                        
                        
                        Toggle::make('use_blocks')
                            ->label('Use Multiple Blocks')
                            ->default(false) 
                            ->helperText('Switch to add multiple content blocks')
                            ->reactive(),  

                        
                        RichEditor::make('body')
                            ->label('Content')
                            ->visible(fn ($get) => !$get('use_blocks')),  // Only visible when 'use_blocks' is off

                        
                        Repeater::make('content_blocks')
                            ->label('Content Blocks')
                            ->schema([
                                Select::make('type')
                                    ->options([
                                        'heading' => 'Heading',
                                        'paragraph' => 'Paragraph',
                                        'list' => 'List',
                                        'subtitle' => 'Subtitle',
                                        'link' => 'Link',
                                    ])
                                    ->required(),

                                RichEditor::make('content') 
                                    ->label('Content'),
                            ])
                            ->createItemButtonLabel('Add New Block')
                            ->required()
                            ->visible(fn ($get) => $get('use_blocks')),
                        

                        Forms\Components\Toggle::make('active')
                            ->required(),
                        
                        Forms\Components\DateTimePicker::make('published_at')
                            ->required()
                            ->label('Published At'),

                        Forms\Components\Hidden::make('timezone')
                            ->default('UTC') // Default to UTC if JavaScript fails
                            ->afterStateHydrated(function ($component, $state) {
                                $component->state(request()->timezone ?? 'UTC'); // Set the timezone from the request
                            }),

                        
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\FileUpload::make('uploaded_file')
                            ->label('Upload File')
                            ->preserveFilenames() 
                            ->directory('uploads') 
                            ->visibility('public')
                            ->image(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('categories', 'title')
                            ->required(),
                        Forms\Components\TextInput::make('section')
                            ->label('Section')
                            ->placeholder('Enter section (e.g., header, featured)')
                            ->required(),
                    
                    ]),
                    
                

                ]);
    }

  
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Post ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('uploaded_file')
                    ->label('Uploaded Image')
                    ->url(fn ($record) => url(Storage::url($record->uploaded_file), ))
                    ,
                

                Tables\Columns\IconColumn::make('active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('categories.title')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                    
                    Tables\Columns\TextColumn::make('section')
                    ->label('Section')
                    ->getStateUsing(function ($record) {
                        return $record->categories->pluck('pivot.section')->join(', ');
                    }),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->timezone(fn () => request()->timezone ?? 'UTC') // Use the user's current timezone
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->formatStateUsing(function ($state, $record) {
                        $postTimezone = $record->timezone ?? 'UTC'; 
                        return Carbon::parse($state)
                            ->setTimezone($postTimezone) 
                            ->setTimezone(request()->timezone ?? 'UTC'); 
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->formatStateUsing(function ($state, $record) {
                        $postTimezone = $record->timezone ?? 'UTC'; 
                        return Carbon::parse($state)
                            ->setTimezone($postTimezone) 
                            ->setTimezone(request()->timezone ?? 'UTC'); 
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
    
            ->filters([
                // Published Date Filter
                Filter::make('published_at')
                    ->form([
                        Section::make('Filter by Published Date')
                            ->schema([
                                Forms\Components\DatePicker::make('from')
                                    ->label('From'),
                                Forms\Components\DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible() 
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('published_at', '>=', Carbon::parse($data['from']));
                        }
    
                        if ($data['until']) {
                            $query->whereDate('published_at', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('Published Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "Published from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "Published from {$data['from']}";
                        } elseif ($data['until']) {
                            return "Published until {$data['until']}";
                        }
                        return null;
                    }),
    
                // Created Date Filter
                Filter::make('created_at')
                    ->form([
                        Section::make('Filter by Created Date') 
                            ->schema([
                                Forms\Components\DatePicker::make('from')
                                    ->label('From'),
                                Forms\Components\DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible()  
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('created_at', '>=', Carbon::parse($data['from']));
                        }
    
                        if ($data['until']) {
                            $query->whereDate('created_at', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('Created Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "Created from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "Created from {$data['from']}";
                        } elseif ($data['until']) {
                            return "Created until {$data['until']}";
                        }
                        return null;
                    }),
    
                // Updated Date Filter
                Filter::make('updated_at')
                    ->form([
                        Section::make('Filter by Updated Date') 
                            ->schema([
                                Forms\Components\DatePicker::make('from')
                                    ->label('From'),
                                Forms\Components\DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible()  
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('updated_at', '>=', Carbon::parse($data['from']));
                        }
    
                        if ($data['until']) {
                            $query->whereDate('updated_at', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('Updated Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "Updated from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "Updated from {$data['from']}";
                        } elseif ($data['until']) {
                            return "Updated until {$data['until']}";
                        }
                        return null;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->color('danger'),

                    Tables\Actions\BulkAction::make('mark_as_active')
                        ->label('Mark as Active')  
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['active' => true]); 
                            }
                            Notification::make()
                                ->title('Posts marked as Active!')
                                ->success()
                                ->send();
                        })
                        ->color('success')
                        ->requiresConfirmation() 
                        ->icon('heroicon-o-check-circle'),

                    Tables\Actions\BulkAction::make('mark_as_inactive')
                        ->label('Mark as Inactive')  
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['active' => false]); 
                            }
                            Notification::make()
                                ->title('Posts marked as Inactive!')
                                ->success()
                                ->send();
                        })
                        ->color('danger') 
                        ->requiresConfirmation() 
                        ->icon('heroicon-o-x-circle'),  
                    ])
                    ->label('Actions'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery()->with('categories');
    return $query;
}


}
