<?php

namespace App\Http\Controllers\Api\v1\Role;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Requests\Role\SearchRequest;
use App\Http\Resources\Api\v1\Role\RoleResource;
use App\Services\Interfaces\Role\RoleServiceInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends ApiController
{
    private RoleServiceInterfaces $service;

    public function __construct(RoleServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('roles')->count() > 0)
        {
            $roles = $this->service->index();
            return $this->successResponse(RoleResource::collection($roles), 200);
        }
        return $this->errorResponse('no-roles', 404);
    }

    public function store(StoreRequest $request)
    {
        $role = $this->service->store($request->validated());
        if ($role)
            return $this->successResponse(new RoleResource($role), 201);
        return $this->errorResponse('save-failed', 500);
    }

    public function show(int $id)
    {
        if ($this->checkExistsRoleById($id))
        {
            $role = $this->service->show($id);
            if ($role)
                return $this->successResponse(new RoleResource($role), 200);
            return $this->errorResponse('failed', 404);
        }
        return $this->errorResponse('role-notFound', 404);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if (!$this->checkExistsRoleById($id))
            return $this->errorResponse('role-notFound', 404);

        $role = $this->service->update($request->validated(), $id);
        if ($role)
            return $this->successResponse('', 201, 'update-successful');
        return $this->errorResponse('save-failed', 500);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsRoleById($id))
            return $this->errorResponse('role-notFound', 404);

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
    private function checkExistsRoleById(int $id)
    {
        return $this->service->checkExistsRoleById($id);
    }
}
