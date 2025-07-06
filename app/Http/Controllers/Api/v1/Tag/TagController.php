<?php

namespace App\Http\Controllers\Api\v1\Tag;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\SearchRequest;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Http\Resources\Api\v1\Tag\TagResource;
use App\Services\Interfaces\Tag\TagServiceInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends ApiController
{
    private TagServiceInterfaces $service;

    public function __construct(TagServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('tags')->count() > 0)
        {
            $tags = $this->service->index();
            return $this->successResponse(TagResource::collection($tags), 200);
        }
        return $this->errorResponse('no-tag', 404);
    }

    public function store(StoreRequest $request)
    {
        $tag = $this->service->store($request->validated());
        if ($tag)
            return $this->successResponse(new TagResource($tag), 201);
        return $this->errorResponse('store-failed', 404);
    }

    public function show(int $id)
    {
        if (!$this->checkExistsTagById($id))
            return $this->errorResponse('tag-notFound', 404);

        $tag = $this->service->show($id);
        if ($tag)
            return $this->successResponse(new TagResource($tag), 200);
        return $this->errorResponse('show-failed', 404);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if (!$this->checkExistsTagById($id))
            return $this->errorResponse('tag-notFound', 404);

        if ($this->service->update($request->validated(), $id))
            return $this->successResponse('update-successful', 200);
        return $this->errorResponse('update-failed', 500);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsTagById($id))
            return $this->errorResponse('tag-notFound', 404);

        if ($this->service->delete($id))
            return $this->successResponse('', 200, 'delete-successful');
        return $this->errorResponse('delete-failed', 500);
    }

    public function search(SearchRequest $request)
    {
        $columns = $request->input('columns', ['*']);
        $relations = $request->input('relations', []);
        $filters = $request->only(['search', ...array_keys($request->except(['columns', 'relations', 'page', 'limit']))]);

        $results = $this->service->search($columns, $relations, $filters);

        return $this->successResponse($results, 200);
    }

    private function checkExistsTagById(int $id): bool
    {
        return $this->service->checkExistsTagById($id);
    }
}
