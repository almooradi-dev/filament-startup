<?php

namespace App\Http\Controllers\Stock\API;

use App\Http\Controllers\APIController;
use App\Models\Stock\Post;
use App\Services\Stock\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostAPIController extends APIController
{
    /**
     * Fetch posts
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $take = $request->get('take', 20);
            $page = $request->get('page', 1);
            $offset = $take * ($page - 1);
            $shuffle = filter_var($request->get('shuffle'), FILTER_VALIDATE_BOOLEAN);;

            // Filters
            $search = $request->get('search');
            $filterTypes = $request->get('types', '');
            $filterTypes = $filterTypes ? explode(',', $filterTypes) : [];
            $filterTags = $request->get('tags', '');
            $filterTags = $filterTags ? explode(',', $filterTags) : [];
            $filterCollections = $request->get('collections', '');
            $filterCollections = $filterCollections ? explode(',', $filterCollections) : [];

            $posts = PostService::get(
                search: $search,
                types: $filterTypes,
                tags: $filterTags,
                collections: $filterCollections,
                take: $take,
                offset: $offset,
                shuffle: $shuffle,
                mediaConversions: [
                    'thumb'
                ]
            );

            return $this->sendResponse($posts);
        } catch (HttpException $e) {
            return $this->sendError($e->getMessage(), code: $e->getStatusCode());
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Get single post data by slug
     *
     * @param Request $request
     * @param string $slug
     * @return JsonResponse
     */
    public function show(Request $request, string $slug): JsonResponse
    {
        try {
            $post = PostService::getBaseQuery()
                ->where('slug', $slug)
                ->first();

            abort_if(!$post, 404, 'Post not found'); // TODO: Translation

            return $this->sendResponse(PostService::getStructuredPostData($post));
        } catch (HttpException $e) {
            return $this->sendError($e->getMessage(), code: $e->getStatusCode());
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
