<?php

namespace App\Http\Controllers\Api\v1\Agent;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\SearchRequest;
use App\Http\Requests\Agent\StoreRequest;
use App\Http\Requests\Agent\UpdateRequest;
use App\Http\Resources\Api\v1\Agent\AgentResource;
use App\Services\Interfaces\Agent\AgentServiceInterfaces;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgentController extends ApiController
{
    private AgentServiceInterfaces $service;

    public function __construct(AgentServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('agents')->count() > 0)
        {
            $relations = [];
            $agents = $this->service->index($relations);
            if ($agents)
                return $this->successResponse(AgentResource::collection($agents), 200);
            return $this->errorResponse('index-failed', 500);
        }
        return $this->errorResponse('no-agents', 400);
    }

    public function store(StoreRequest $request)
    {
        if ($this->checkExsistsAgentByMac($request->mac_address))
        {
            $agent = DB::table('agents')->where('mac_address', $request->mac_address)->first();
            return $this->successResponse(['id' => $agent->id], 200);
        }
        $attributes = $request->validated();
        $attributes['status'] = 'online';
        $attributes['boot_time'] = Carbon::now();
        $token = Str::random(40);
        $attributes['token'] = $token;
        $agent = $this->service->store($attributes);
        if ($agent)
        {
            if (DB::table('agent_logs')->insert(['description' => 'agent '.$agent->id.' is online', 'agent_id' => $agent->id, 'type' => 'online']))
                return $this->successResponse(['id' => $agent->id, 'token' => $token], 200);
        }
        return $this->errorResponse('store-failed', 500);
    }

    public function show(int $id)
    {
        if (!$this->checkExistsAgentById($id))
            return $this->errorResponse('agent-notFound', 404);

        $relations = ['department',
                        'alerts',
                        'commands',
                        'tags',
                        'snapshots',
                        'screenshots',
                        'logs'];
        $agent = $this->service->show($id, $relations);
        if ($agent)
            return $this->successResponse(new AgentResource($agent), 200);
        return $this->errorResponse('agent-notFound', 404);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if (!$this->checkExistsAgentById($id))
            return $this->errorResponse('agent-notFound', 404);

        $agent = $this->service->update($request->validated(), $id);
        if ($agent)
            return $this->successResponse('', 200, 'update-successful');
        return $this->errorResponse('update-failed', 500);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsAgentById($id))
            return $this->errorResponse('agent-notFound', 404);

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

    private function checkExistsAgentById(int $id): bool
    {
        return $this->service->checkExistsAgentById($id);
    }

    private function checkExsistsAgentByMac(string $mac_address): bool
    {
        return $this->service->checkExistsAgentByMac($mac_address);
    }
}
