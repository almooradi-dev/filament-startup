<?php

namespace App\Filament\Resources\Stock\PostTypeResource\Pages;

use App\Filament\Resources\Stock\PostTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostType extends EditRecord
{
    protected static string $resource = PostTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
