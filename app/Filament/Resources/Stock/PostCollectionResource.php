<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\PostCollectionResource\Pages;
use App\Models\Stock\PostCollection;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostCollectionResource extends Resource
{
    use Translatable;

    protected static ?string $model = PostCollection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('stock.stock');
    }

    public static function getModelLabel(): string
    {
        return __('stock.collection');
    }

    public static function getPluralModelLabel(): string
    {
        return __('stock.collections');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('key', str_replace('-', '_', Str::slug($state))))
                    ->required(),
                TextInput::make('key')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->readOnly(),
                FileUpload::make('image')
                    ->image()
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('core.is_active'))
                    ->inline(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name')->searchable()->sortable()->label(__('core.name')),
                TextColumn::make('key')->searchable()->sortable()->label(__('core.key')),
                ToggleColumn::make('is_active')->label(__('core.is_active'))
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListPostCollections::route('/'),
            'create' => Pages\CreatePostCollection::route('/create'),
            'edit' => Pages\EditPostCollection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
