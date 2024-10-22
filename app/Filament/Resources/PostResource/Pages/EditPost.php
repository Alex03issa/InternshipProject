<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        
        $categoryId = $this->data['category_id'];
        $section = $this->data['section'];

        $syncData = [];
        foreach ((array) $categoryId as $id) {
            if (is_numeric($id)) {
                $syncData[$id] = ['section' => $section];
            }
        }
        $this->record->categories()->sync($syncData);

        
        $orderCounter = 1;

        
        if ($this->data['use_blocks']) {
           
            $this->record->update([
                'body' => null,  
            ]);

            
            foreach ($this->data['content_blocks'] as $blockData) {
                
                if (isset($blockData['id'])) {
                    $contentBlock = $this->record->contentBlocks()->find($blockData['id']);
                    if ($contentBlock) {
                        
                        $contentBlock->update([
                            'type' => $blockData['type'],
                            'content' => $blockData['content'],
                            'order' => $orderCounter,  
                            'use_blocks' => 1, 
                        ]);
                    }
                } else {
                    
                    $this->record->contentBlocks()->create([
                        'type' => $blockData['type'],
                        'content' => $blockData['content'],
                        'order' => $orderCounter,  
                        'use_blocks' => 1,
                    ]);
                }
                
                $orderCounter++;
            }
        } else {
           
            $this->record->update([
                'body' => $this->data['body'],  
            ]);
        }
    }


    protected function mutateFormDataBeforeFill(array $data): array
    {
       
        $this->record->load('categories', 'contentBlocks');
        
        
        if ($this->record->contentBlocks->isNotEmpty()) {
            $data['use_blocks'] = 1;  
        } else {
            $data['use_blocks'] = 0;  
        }

        
        $data['content_blocks'] = $this->record->contentBlocks->map(function ($block) {
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
