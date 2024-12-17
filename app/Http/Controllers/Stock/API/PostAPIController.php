<?php

namespace App\Http\Controllers\Stock\API;

use App\Http\Controllers\APIController;
use App\Models\Stock\Post;
use Exception;
use Illuminate\Http\Request;

class PostAPIController extends APIController
{
    public function index(Request $request)
    {
        try {
            $take = $request->get('take', 20);
            $page = $request->get('page', 1);
            $offset = $take * ($page - 1);

            // Filters
            $search = $request->get('search');
            $tags = $request->get('tags');
            $collections = $request->get('collections');

            $posts = Post::query()
                ->with(['type', 'status', 'collections', 'tags'])
                ->whereHas('type', fn($query) => $query->whereActive())
                ->whereHas('status', fn($query) => $query->where('key', 'published'))
                ->orderBy('created_at', 'desc')
                ->take($take)
                ->offset($offset)
                ->get();

            // TODO: Create a resource
            $data = [];
            foreach ($posts as $post) {
                // Media (we are accepting now one file per post)
                $media = [];
                if (count($post->media) > 0) {
                    // TODO: Set different sizes
                    $mediaPath = $post->media[0];
                    $media = [
                        'original' => asset('/storage/' . $mediaPath),
                        'lg' => asset('/storage/' . $mediaPath),
                        'md' => asset('/storage/' . $mediaPath),
                        'sm' => asset('/storage/' . $mediaPath),
                    ];
                }

                // Collections
                $collections = [];
                foreach ($post->collections as $collection) {
                    if (!$collection->is_active) {
                        continue;
                    }

                    $collections[] = [
                        'id' => $collection->id,
                        'name' => $collection->name,
                        'key' => $collection->key,
                    ];
                }

                // Tags
                $tags = [];
                foreach ($post->tags as $tag) {
                    if (!$tag->is_active) {
                        continue;
                    }

                    $tags[] = [
                        'id' => $tag->id,
                        'name' => $tag->name,
                        'key' => $tag->key,
                    ];
                }

                // Data
                $data[] = [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'location' => $post->location,
                    'description' => $post->description,
                    'media' => $media,
                    'collections' => $collections,
                    'tags' => $tags,
                ];
            }

            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
