<?php

namespace App\Http\Controllers\Api\v1\AgentSnapshot;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\AgentSnapshot\SearchRequest;
use App\Http\Requests\AgentSnapshot\StoreRequest;
use App\Http\Requests\AgentSnapshot\UpdateRequest;
use App\Http\Resources\Api\v1\AgentSnapshot\AgentSnapshotResource;
use App\Services\Interfaces\AgentSnapshot\AgentSnapshotServiceInterfaces;
use Illuminate\Support\Facades\DB;

class AgentSnapshotController extends ApiController
{
    private AgentSnapshotServiceInterfaces $service;

    public function __construct(AgentSnapshotServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('agent_snapshots')->count() > 0)
        {
            $relations = [];
            $snapshots = $this->service->index($relations);
            if ($snapshots)
                return $this->successResponse(AgentSnapshotResource::collection($snapshots), 200);
            return $this->errorResponse('index-failed', 500);
        }
        return $this->errorResponse('no-snapshots', 400);
    }

    public function store(StoreRequest $request)
    {
        $snapshot = $this->service->store($request->validated());
        if ($snapshot)
            return $this->successResponse(new AgentSnapshotResource($snapshot), 201);
        return $this->errorResponse('store-failed', 500);
    }

    public function show(int $id)
    {
        if (!$this->checkExistsAgentSnapshotById($id))
            return $this->errorResponse('snapshot-notFound', 404);

        $relations = [];
        $snapshot = $this->service->show($id, $relations);
        if ($snapshot)
            return $this->successResponse(new AgentSnapshotResource($snapshot), 200);
        return $this->errorResponse('show-failed', 500);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if (!$this->checkExistsAgentSnapshotById($id))
            return $this->errorResponse('snapshot-notFound', 404);

        $snapshot = $this->service->update($request->validated(), $id);
        if ($snapshot)
            return $this->successResponse('', 201, 'update-successful');
        return $this->errorResponse('update-failed', 500);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsAgentSnapshotById($id))
            return $this->errorResponse('snapshot-notFound', 404);

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

    private function checkExistsAgentSnapshotById(int $id)
    {
        return $this->service->checkExistsAgentSnapshotById($id);
    }
}
