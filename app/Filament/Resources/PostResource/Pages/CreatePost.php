<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

  
    protected function afterCreate(): void
    {
        // Sync categories
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
                $this->record->contentBlocks()->create([
                    'type' => $blockData['type'],
                    'content' => $blockData['content'],
                    'order' => $orderCounter,  
                    'use_blocks' => 1,  
                ]);
                
                $orderCounter++;
            }
        } else {
            
            $this->record->update([
                'body' => $this->data['body'],  
            ]);
        }
    }
    

}

  
