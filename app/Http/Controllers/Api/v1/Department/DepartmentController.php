<?php

namespace App\Http\Controllers\Api\v1\Department;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\SearchRequest;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Http\Resources\Api\v1\Department\DepartmentResource;
use App\Repositories\Interfaces\Department\DepartmentRepositoryInterfaces;
use App\Services\Interfaces\Department\DepartmentServiceInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends ApiController
{
    private DepartmentServiceInterfaces $service;

    public function __construct(DepartmentServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('departments')->count() > 0)
        {
            $depts = $this->service->index();
            if ($depts)
                return $this->successResponse(DepartmentResource::collection($depts), 200);
            return $this->errorResponse('index-failed', 500);
        }
        return $this->errorResponse('no-department', 400);
    }

    public function store(StoreRequest $request)
    {
        $department = $this->service->store($request->validated());
        if ($department)
            return $this->successResponse(new DepartmentResource($department), 201);
        return $this->errorResponse('store-failed', 500);
    }

    public function show(int $id)
    {
        if (!$this->checkExistsDepartmentById($id))
            return $this->errorResponse('dept-notFound', 404);

        $department = $this->service->show($id);
        if ($department)
            return $this->successResponse(new DepartmentResource($department), 200);
        return $this->errorResponse('not-found', 404);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if (!$this->checkExistsDepartmentById($id))
            return $this->errorResponse('dept-notFound', 404);

        if ($this->service->update($request->validated(), $id))
            return $this->successResponse('', 200, 'update-successful');
        return $this->errorResponse('update-failed', 500);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsDepartmentById($id))
            return $this->errorResponse('dept-notFound', 404);

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

    private function checkExistsDepartmentById(int $id): bool
    {
        return $this->service->checkExistsDepartmentById($id);
    }
}
