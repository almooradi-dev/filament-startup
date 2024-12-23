<?php

namespace App\Services\Stock;

use App\Models\Stock\Post;
use Illuminate\Database\Eloquent\Builder;

class PostService
{
    public static function getStructuredPostData(Post $post): array
    {
        // Media (we are accepting now one file per post)
        $media = [];
        $postMedia = $post->getFirstMedia('posts');
        if ($postMedia) {
            // TODO: Generate conversion if not exists
            $media = [
                'original' => $postMedia->original_url,
                'lg' => $postMedia->hasGeneratedConversion('lg') ? $postMedia->getUrl('lg') : null,
                'md' => $postMedia->hasGeneratedConversion('md') ? $postMedia->getUrl('md') : null,
                'sm' => $postMedia->hasGeneratedConversion('sm') ? $postMedia->getUrl('sm') : null,
                'thumb' => $postMedia->hasGeneratedConversion('thumb') ? $postMedia->getUrl('thumb') : null,
            ];
        }

        // Collections
        $postCollections = [];
        foreach ($post->collections as $collection) {
            if (!$collection->is_active) {
                continue;
            }

            $postCollections[] = [
                'id' => $collection->id,
                'name' => $collection->name,
                'key' => $collection->key,
            ];
        }

        // Tags
        $postTags = [];
        foreach ($post->tags as $tag) {
            if (!$tag->is_active) {
                continue;
            }

            $postTags[] = [
                'id' => $tag->id,
                'name' => $tag->name,
                'key' => $tag->key,
            ];
        }

        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'location' => $post->location,
            'description' => $post->description,
            'author' => $post->author ? [
                'id' => $post->author->id,
                'name' => $post->author->full_name,
                'avatar' => $post->author->avatar_url,
            ] : null,
            'type' => $post->type?->key,
            'media' => $media,
            'collections' => $postCollections,
            'tags' => $postTags,
        ];
    }

    public static function getBaseQuery($with = ['type', 'status', 'collections', 'tags', 'author'], $statuses = ['published']): Builder
    {
        return Post::query()
            ->with($with)
            ->whereHas('type', fn($query) => $query->whereActive())
            ->whereHas('status', fn($query) => $query->whereIn('key', $statuses));
    }

    public static function get($search = '', $types = null, $tags = null, $collections = null, $authorUsername = null, $take = 20, $offset = 0, $shuffle = false)
    {
        $posts = static::getBaseQuery()
            // Search
            ->when(!empty($search), function ($query) use ($search) {
                $search = trim(preg_replace('/\s+/', ' ', $search));
                $keywords = array_filter(explode(' ', $search));
                $query->where(function ($subQuery) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $subQuery->orWhere('title', 'like', '%' . $keyword . '%')
                            ->orWhere('description', 'like', '%' . $keyword . '%');
                    }
                });
            })
            // Type
            ->when(is_array($types) && count($types) > 0, fn($query) => $query->whereHas('type', fn($q) => $q->whereIn('key', $types)))
            // Tags
            ->when(is_array($tags) && count($tags) > 0, fn($query) => $query->whereHas('tags', fn($q) => $q->whereIn('key', $tags)))
            // Collections
            ->when(is_array($collections) && count($collections) > 0, fn($query) => $query->whereHas('collections', fn($q) => $q->whereIn('key', $collections)))
            // Author TODO
            // Challenge TODO
            ->orderBy('created_at', 'desc')
            ->take($take)
            ->offset($offset)
            ->get();

        if ($shuffle) {
            $posts->shuffle();
        }

        // TODO: Create a resource
        $data = [];
        foreach ($posts as $post) {
            $data[] = static::getStructuredPostData($post);
        }

        return $data;
    }
}
