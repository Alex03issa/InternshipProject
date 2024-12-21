<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsResource\Pages;
use App\Models\Ad;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Columns\BadgeColumn;

class AdsResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([

                    Grid::make(2)
                    ->schema([
                        TextInput::make('ad_name')
                            ->required()
                            ->label('Ad Name')
                            ->maxLength(255),
                        
                        TextInput::make('ad_owner')
                            ->label('Ad Owner')
                            ->maxLength(255),
                    ]),
                    

                    TextInput::make('ad_url')
                        ->url()
                        ->label('Ad URL'),

                    FileUpload::make('ad_image')
                        ->directory('ads')
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/webp'])
                        ->maxSize(2048) 
                        ->preserveFilenames()
                        ->visibility('private')
                        ->imageEditor()
                        ->image(),
                 
                    

                    Textarea::make('description')
                        ->label('Description')
                        ->maxLength(500),

                    Select::make('ad_platform')
                        ->options([
                            'game' => 'Game',
                            'website' => 'Website',
                        ])
                        ->required()
                        ->label('Ad Platform'),

                    Select::make('ad_type')
                        ->options([
                            'custom' => 'Custom Ad',
                            'google' => 'Google Ad',
                        ])
                        ->required()
                        ->label('Ad Type')
                        ->reactive(),
        
                    Grid::make(2)
                        ->schema([
                           Toggle::make('use_cpc')
                                ->label('Enable Cost Per Click (CPC) Billing')
                                ->reactive()
                                ->inline()
                                ->visible(fn (callable $get) => $get('ad_type') === 'custom'), 

                                
                            Toggle::make('use_cpm')
                                ->label('Enable Cost Per Thousand Impressions (CPM) Billing')
                                ->reactive()
                                ->inline()
                                ->visible(fn (callable $get) => $get('ad_type') === 'custom'), // Show only for custom ads

                        ]),
                    
        
                    Grid::make(2)
                        ->schema([
                            TextInput::make('cpc_rate')
                                ->label('CPC Rate')
                                ->numeric()
                                ->minValue(0)
                                ->hidden(fn (callable $get) => !$get('use_cpc'))
                                ->required(fn (callable $get) => $get('use_cpc')),
                
                
                            TextInput::make('cpm_rate')
                                ->label('CPM Rate')
                                ->numeric()
                                ->minValue(0)
                                ->hidden(fn (callable $get) => !$get('use_cpm'))
                                ->required(fn (callable $get) => $get('use_cpm')),
                        ]),
                    

                    Textarea::make('google_ad_code')
                        ->label('Google Ad Code')
                        ->maxLength(1500)
                        ->visible(fn ($get) => $get('ad_type') === 'google'),

                    Grid::make(2)
                        ->schema([
                            DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
    
                            DatePicker::make('end_date')
                                ->label('End Date')
                                ->required(),
                        ]),
                   
                    Toggle::make('active')
                        ->label('Active')
                        ->default(true),

                    Toggle::make('paid_status')
                        ->label('Is it Paid?')
                        ->default(false),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('ad_name')
                    ->sortable()
                    ->searchable()
                    ->label('Ad Name')
                    ->limit(50),

                TextColumn::make('ad_platform')
                    ->label('Platform')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('ad_type')
                    ->label('Type')
                    ->sortable()
                    ->searchable(),

                BooleanColumn::make('active')
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('ad_owner')
                    ->label('Owner')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('total_views')
                    ->label('Views')
                    ->getStateUsing(fn ($record) => $record->total_views)
                    ->icon('heroicon-o-eye')
                    ->Color('views-blue'), 

                BadgeColumn::make('total_clicks')
                    ->label('Clicks')
                    ->getStateUsing(fn ($record) => $record->total_clicks)
                    ->icon('heroicon-o-cursor-arrow-rays')
                    ->Color('clicks-orange'),

                BadgeColumn::make('bill')
                    ->label('Bill')
                    ->getStateUsing(fn ($record) => number_format($record->bill, 5))
                    ->icon('heroicon-o-currency-dollar')
                    ->Color('revenue-green'),


                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->sortable()
                    ->date('Y-m-d'),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->sortable()
                    ->date('Y-m-d'),

                BooleanColumn::make('paid_status')
                    ->label('Paid'),
            ])
            ->filters([
                // Start Date Filter
                Filter::make('start_date')
                    ->form([
                        Section::make('Filter by Start Date')
                            ->schema([
                                DatePicker::make('from')
                                    ->label('From'),
                                DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible() 
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('start_date', '>=', Carbon::parse($data['from']));
                        }
            
                        if ($data['until']) {
                            $query->whereDate('start_date', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('Start Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "Start Date from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "Start Date from {$data['from']}";
                        } elseif ($data['until']) {
                            return "Start Date until {$data['until']}";
                        }
                        return null;
                    }),
            
                // End Date Filter
                Filter::make('end_date')
                    ->form([
                        Section::make('Filter by End Date')
                            ->schema([
                                DatePicker::make('from')
                                    ->label('From'),
                                DatePicker::make('until')
                                    ->label('Until'),
                            ])
                            ->collapsible() 
                            ->collapsed(true),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['from']) {
                            $query->whereDate('end_date', '>=', Carbon::parse($data['from']));
                        }
            
                        if ($data['until']) {
                            $query->whereDate('end_date', '<=', Carbon::parse($data['until']));
                        }
                    })
                    ->label('End Date')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['from'] && $data['until']) {
                            return "End Date from {$data['from']} to {$data['until']}";
                        } elseif ($data['from']) {
                            return "End Date from {$data['from']}";
                        } elseif ($data['until']) {
                            return "End Date until {$data['until']}";
                        }
                        return null;
                    }),
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
                Tables\Actions\Action::make('downloadClientReport')
                    ->label('Client Report')
                    ->url(fn (Ad $record) => route('ad.downloadClientReport', $record->id))
                    ->icon('heroicon-o-arrow-down-on-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->color('danger'),

                    Tables\Actions\BulkAction::make('mark_as_active')
                        ->label('Mark as Active')  
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'active' => true,
                                    'manual_override' => true, // Set manual_override to true
                                ]);
                            }
                            Notification::make()
                                ->title('Ads marked as Active!')
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
                                $record->update([
                                    'active' => false,
                                    'manual_override' => true, // Set manual_override to true
                                ]);
                            }
                            Notification::make()
                                ->title('Ads marked as Inactive!')
                                ->success()
                                ->send();
                        })
                        ->color('danger') 
                        ->requiresConfirmation() 
                        ->icon('heroicon-o-x-circle'), 
                        
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('Mark as Paid')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['paid_status' => true]);
                                $record->updateRevenue(); // Update revenue after marking as paid
                            }
                            Notification::make()
                                ->title('The Bill is Paid!')
                                ->success()
                                ->send();
                        })
                        ->color('success')
                        ->requiresConfirmation()
                        ->icon('heroicon-o-check-circle'),
                    

                    Tables\Actions\BulkAction::make('mark_as_unpaid')
                        ->label('Mark as Unpaid')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['paid_status' => false]);
                                $record->updateRevenue(); 
                            }
                            Notification::make()
                                ->title('The Bill is Unpaid!')
                                ->success()
                                ->send();
                        })
                        ->color('danger') 
                        ->requiresConfirmation() 
                        ->icon('heroicon-o-x-circle'),

                    Tables\Actions\BulkAction::make('downloadAdminReport')
                        ->label('Admin Report')
                        ->url(route('ad.downloadAdminReport'))
                        ->action(function (Collection $records) {
                            Notification::make()
                                ->title('Report has been Downloaded!')
                                ->success()
                                ->send();
                        })
                        ->icon('heroicon-o-arrow-down-on-square'),
                    ])
                    ->label('Actions'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAds::route('/create'),
            'edit' => Pages\EditAds::route('/{record}/edit'),
        ];
    }
}
