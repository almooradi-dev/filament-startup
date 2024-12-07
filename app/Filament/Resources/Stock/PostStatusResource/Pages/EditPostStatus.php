<?php

namespace App\Filament\Resources\Stock\PostStatusResource\Pages;

use App\Filament\Resources\Stock\PostStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostStatus extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PostStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
