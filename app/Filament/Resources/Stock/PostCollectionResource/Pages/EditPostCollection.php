<?php

namespace App\Filament\Resources\Stock\PostCollectionResource\Pages;

use App\Filament\Resources\Stock\PostCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostCollection extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PostCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
