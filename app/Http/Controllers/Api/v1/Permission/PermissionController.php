<?php

namespace App\Http\Controllers\Api\v1\Permission;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Http\Requests\Role\SearchRequest;
use App\Http\Resources\Api\v1\Permission\PermissionResource;
use App\Services\Interfaces\Permission\PermissionServiceInterfaces;
use Illuminate\Support\Facades\DB;

class PermissionController extends ApiController
{
    private PermissionServiceInterfaces $service;

    public function __construct(PermissionServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('permissions')->count() > 0)
        {
            $permissions = $this->service->index();
            if ($permissions)
                return $this->successResponse(PermissionResource::collection($permissions), 200);
            return $this->errorResponse('index-failed', 500);
        }
        return $this->errorResponse('no-permission', 403);
    }

    public function store(StoreRequest $request)
    {
        $permission = $this->service->store($request->validated());
        if ($permission)
            return $this->successResponse(new PermissionResource($permission), 200, 'created');
        return $this->errorResponse('create-failed', 500);
    }

    public function show(int $id)
    {
        if (!$this->checkExistsPermissionById($id))
            return $this->errorResponse('permission-notFound', 404);

        $permission = $this->service->show($id);
        if ($permission)
            return $this->successResponse(new PermissionResource($permission), 200);
        return $this->errorResponse('show-failed', 404);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if (!$this->checkExistsPermissionById($id))
            return $this->errorResponse('permission-notFound', 404);

        if ($this->service->update($request->validated(), $id))
            return $this->successResponse('', 200, 'update-successful');
        return $this->errorResponse('update-failed', 500);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsPermissionById($id))
            return $this->errorResponse('permission-notFound', 404);

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

    public function checkExistsPermissionById(int $id)
    {
        return $this->service->checkExistsPermissionById($id);
    }
}
