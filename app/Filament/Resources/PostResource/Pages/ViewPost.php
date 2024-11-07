<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('create')
                ->label('New Post')
                ->url(static::getResource()::getUrl('create'))
                ->icon('heroicon-o-plus'),
            Actions\Action::make('view_posts')
                ->label('View Posts')
                ->url(PostResource::getUrl('index'))
                ->icon('heroicon-o-document-duplicate'),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
       
        $this->record->load('categories', 'contentBlocks');
        
        
        if ($this->record->contentBlocks->isNotEmpty()) {
            $data['use_blocks'] = 1;  
        } else {
            $data['use_blocks'] = 0;  
        }

        
        $data['content_blocks'] = $this->record->contentBlocks
        ->sortBy('order')
        ->map(function ($block) {
            return [
                'id' => $block->id,
                'type' => $block->type,
                'content' => $block->content,
                'order' => $block->order,  
            ];
        })->toArray();

        
        if ($this->record->categories->isNotEmpty()) {
            $data['section'] = $this->record->categories->first()->pivot->section;
        }

        return $data;
    }



    
}
