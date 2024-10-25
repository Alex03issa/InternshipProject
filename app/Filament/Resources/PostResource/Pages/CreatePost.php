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

        
        $existingBlockIds = $this->record->contentBlocks->pluck('id')->toArray();
        $newBlockIds = array_filter(array_column($this->data['content_blocks'], 'id'));

        $deletedBlockIds = array_diff($existingBlockIds, $newBlockIds);

        if (!empty($deletedBlockIds)) {
            $this->record->contentBlocks()->whereIn('id', $deletedBlockIds)->delete();
        }

    
        
        $orderCounter = 1;
    
        
        if ($this->data['use_blocks']) {
            $this->record->update([
                'body' => null,  
            ]);
    
            
            foreach ($this->data['content_blocks'] as $blockData) {
                $this->record->contentBlocks()->create([
                    'type' => $blockData['type'],
                    'content' => strip_tags($blockData['content'],'<ul><ol><li><strong><em><p><h1><h2><h3><h4><h5><h6><br><a><u><blockquote><code><img>&nbsp;>'),
                    'order' => $orderCounter,  
                    'use_blocks' => 1,  
                ]);
                
                $orderCounter++;
            }
        } else {
            
            $this->record->update([
                'body' => strip_tags($this->data['body'], '<ul><ol><li><strong><em><p><h1><h2><h3><h4><h5><h6><br><a><u><blockquote><code><img>&nbsp;>'),
            ]);
        }
    }
    

}

  
