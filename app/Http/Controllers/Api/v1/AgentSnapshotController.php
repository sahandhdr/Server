<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Agent\AgentSnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgentSnapshotController extends ApiController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            "agent_id" => 'required',
            "cpu" => 'required',
            "ram" => 'required',
            "disk" => 'required',
            "network" => 'required',
        ));

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), 400);

        if ($this->checkExsistsAgentById($request->agent_id))
        {
            $snapshot = new AgentSnapshot();
            $snapshot->agent_id = $request->agent_id;
            $snapshot->cpu = $request->cpu;
            $snapshot->ram = $request->ram;
            $snapshot->disk = $request->disk;
            $snapshot->network = $request->network;
            if ($snapshot->save())
            {
                if (json_decode($snapshot->cpu)->cpu_percent>=90)
                    DB::table('agent_alerts')->insert(['type' => 'cpu',
                        'message' => 'cpu-overload',
                        'data' => json_encode($snapshot->cpu),
                        'agent_id' => $snapshot->agent_id]);



//                    $this->criticalCPU($snapshot->cpu, $snapshot->agent_id);
//                $this->criticalRam($snapshot->ram,$snapshot->agent_id);
//                $this->criticalDisk($snapshot->disk,$snapshot->agent_id);
//                $this->criticalNetwork($snapshot->network,$snapshot->agent_id);
                return $this->successResponse($snapshot, 200);
            }
            return $this->errorResponse("save-failed", 400);
        }
        return $this->errorResponse('agent-notFound', 404);
    }

    public function getDevice()
    {

    }
    public function cpu($agent_id)
    {
        return json_decode(AgentSnapshot::where('agent_id',$agent_id)->orderBy('created_at', 'desc')->take(10)->get(['cpu', 'id']));
    }

    public function ram($agent_id)
    {
        return json_decode(AgentSnapshot::where('agent_id',$agent_id)->orderBy('created_at', 'desc')->take(10)->get(['cpu', 'id']));
    }

    public function disk($agent_id)
    {
        return json_decode(AgentSnapshot::where('agent_id',$agent_id)->first(['disk'])->disk);
    }

    public function network($agent_id)
    {
        return json_decode(AgentSnapshot::where('agent_id',$agent_id)->first(['network'])->network);
    }

    public function insert($agent_id)
    {
        $cpu = $this->cpu($agent_id);
        return DB::table('agent_alerts')->insert(['type' => 'cpu',
            'message' => 'cpu-overload', 'data' => json_encode($cpu), 'agent_id' => $agent_id]);
    }

    private function criticalCPU($cpu, $agent_id)
    {
            return (DB::table('agent_alerts')->insert(['type' => 'cpu',
                                                         'message' => 'cpu-overload',
                                                         'data' => json_encode($cpu),
                                                         'agent_id' => $agent_id])) ? ['message' => 'cpu-overload'] : ['message' => 'alert-save-error'];
    }

    private function criticalRAM($ram, $agent_id)
    {
        $cpu = $this->ram($agent_id);
        if ($cpu->ram_percent>=90)
            return (DB::table('agent_alerts')->insert(['type' => 'cpu',
                'message' => 'cpu-overload',
                'data' => json_encode($cpu),
                'agent_id' => $agent_id])) ? ['message' => 'cpu-overload'] : ['message' => 'alert-save-error'];

        return ['message' => 'cpu-normally'];
    }

    private function criticalDisk($disk, $agent_id)
    {
        if ($disk['percent']>=60)
            if (DB::table('alerts')->insert(['type' => 'cpu', 'message' => 'cpu-overload', 'data' => $disk, 'agent_id' => $agent_id]))
                return ['message' => 'cpu-overload'];
        return ['message' => 'alertLog-save-error'];
    }

    private function criticalNetwork($net, $agent_id)
    {
        if ($net['percent']>=60)
            if (DB::table('alerts')->insert(['type' => 'cpu', 'message' => 'cpu-overload', 'data' => $net, 'agent_id' => $agent_id]))
                return ['message' => 'cpu-overload'];
        return ['message' => 'alertLog-save-error'];
    }
    public function checkExsistsAgentById($id)
    {
        return DB::table('agents')->where('id', $id)->first();
    }
}
