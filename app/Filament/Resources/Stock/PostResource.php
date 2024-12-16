<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\PostResource\Pages;
use App\Filament\Resources\Stock\PostResource\RelationManagers;
use App\Models\Stock\Post;
use App\Models\Stock\PostStatus;
use App\Tables\Columns\ColorColumn;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    use Translatable;

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('stock.stock');
    }

    public static function getModelLabel(): string
    {
        return __('stock.post');
    }

    public static function getPluralModelLabel(): string
    {
        return __('stock.posts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->maxLength(250)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),
                TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->maxLength(250)
                    ->required()
                    ->readOnly(),
                Textarea::make('description'),
                TextInput::make('location')
                    ->maxLength(250),
                FileUpload::make('media')
                    ->panelLayout('grid')
                    ->openable()
                    ->downloadable()
                    ->multiple()
                    ->acceptedFileTypes([
                        // Images
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/webp',
                        'image/svg+xml',
                        // Videos
                        'video/mp4',
                        'video/mpeg',
                        'video/ogg',
                        'video/webm',
                    ]),
                Select::make('type_id')
                    ->relationship('type', 'name')
                    ->required(),
                Select::make('status_id')
                    ->relationship('status', 'name')
                    ->required(),
                Select::make('collections')
                    ->relationship('collections', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media'),
                TextColumn::make('title')->searchable()->sortable()->label(__('core.title')),
                TextColumn::make('type.name')
                    ->searchable()
                    ->label(__('core.type')),
                ColorColumn::make('status.color')
                    ->text(fn($record) => $record->status->name)
                    ->label(__('core.status'))
                    ->searchable(query: fn(Builder $query, string $search) => $query->whereHas('status', fn($q) => $q->where('name', 'like', '%' . $search . '%'))),
                TextColumn::make('collections.name')
                    ->searchable()
                    ->label(__('stock.collections')),
                TextColumn::make('tags.name')
                    ->searchable()
                    ->label(__('stock.tags')),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
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
