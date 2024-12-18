<?php

namespace App\Http\Controllers\Stock\API;

use App\Http\Controllers\APIController;
use App\Models\Stock\Post;
use App\Services\Stock\PostService;
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
            $shuffle = filter_var($request->get('shuffle'), FILTER_VALIDATE_BOOLEAN);;

            // Filters
            $search = $request->get('search');
            $filterTypes = $request->get('types', '');
            $filterTypes = $filterTypes ? explode(',', $filterTypes) : [];
            $filterTags = $request->get('tags', '');
            $filterTags = $filterTags ? explode(',', $filterTags) : [];
            $filterCollections = $request->get('collections', '');
            $filterCollections = $filterCollections ? explode(',', $filterCollections) : [];

            $posts = PostService::get(search: $search, types: $filterTypes, tags: $filterTags, collections: $filterCollections, take: $take, offset: $offset, shuffle: $shuffle);

            return $this->sendResponse($posts);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
