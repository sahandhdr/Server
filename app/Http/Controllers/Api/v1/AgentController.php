<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgentController extends ApiController
{
    public function index()
    {
        if (DB::table('agents')->count() > 0)
        {
            $agents = Agent::all();
            return $this->successResponse($agents, 200);
        }
        return $this->errorResponse('no-agent-exists', 400);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            "hostname" => 'required',
            "ip_address" => 'required',
            "os" => 'required',
            "os_version" => 'required',
            "mac_address" => 'required',
            "boot_time" => 'required',
        ));

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), 400);

        if ($this->checkExsistsAgentByMac($request->mac_address))
        {
            $agent_id = DB::table('agents')->where('mac_address', $request->mac_address)->first('id');
            return $this->successResponse($agent_id, 200);
        }

        $agent = new Agent();
        $agent->hostname = $request->hostname ;
        $agent->ip_address = $request->ip_address ;
        $agent->os = $request->os ;
        $agent->os_version = $request->os_version ;
        $agent->mac_address = $request->mac_address ;
        $agent->boot_time = $request->boot_time ;
        $agent->status = 'online' ;
        if ($agent->save())
        {
            if (DB::table('agent_logs')->insert(['description' => 'agent '.$agent->id.' is online', 'agent_id' => $agent->id, 'type' => 'online']))
            {
                return $this->successResponse($agent->id, 200);
            }
        }
        return $this->errorResponse("save-failed", 500);
    }

    public function show($agent_id)
    {
        if ($this->checkExistsAgentById($agent_id))
        {
            $agent = Agent::where('id', $agent_id)->first();
            return $this->successResponse($agent, 200);
        }
        return $this->errorResponse('agent-notFound', 404);
    }

    public function update(Request $request, $agent_id)
    {
        if ($this->checkExistsAgentById($agent_id))
        {
            $validator = Validator::make($request->all(), array(
                "hostname" => 'nullable',
                "ip_address" => 'nullable',
                "os" => 'nullable',
                "os_version" => 'nullable',
                "mac_address" => 'nullable',
            ));

            if ($validator->fails())
                return $this->errorResponse($validator->errors(), 400);

            $agent = Agent::where('id', $agent_id)->first();
            if ($request->hostname) $agent->hostname = $request->hostname;
            if ($request->ip_address) $agent->ip_address = $request->ip_address;
            if ($request->os) $agent->os = $request->os;
            if ($request->os_version) $agent->os_version = $request->os_version;
            if ($request->mac_address) $agent->mac_address = $request->mac_address;
            if ($agent->save())
                return $this->successResponse($agent->id, 200);
            return $this->errorResponse("save-failed", 500);
        }
        return $this->errorResponse('agent-notFound', 404);
    }

    public function delete($agent_id)
    {
        if ($this->checkExistsAgentById($agent_id))
        {
            if (DB::table('agents')->where('id', $agent_id)->delete())
                return $this->successResponse('', 200, 'delete-successfully');
            return $this->errorResponse('delete-failed', 500);
        }
        return $this->errorResponse('agent-notFound', 404);
    }

    private function checkExistsAgentById($id)
    {
        return DB::table('agents')->where('id', $id)->exists();
    }
    public function checkExsistsAgentByMac($mac_address)
    {
        return DB::table('agents')->where("mac_address", $mac_address)->exists();
    }
}
