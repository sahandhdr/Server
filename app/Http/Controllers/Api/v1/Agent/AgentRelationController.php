<?php

namespace App\Http\Controllers\Api\v1\Agent;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use Illuminate\Http\Request;

class AgentRelationController extends Controller
{
    private PivotServiceInterfaces $service;

    public function __construct(PivotServiceInterfaces $service)
    {
        $this->service = $service;
    }

    //    -------------------------- tag --------------------------
    public function attachAgentToTag($agent_id, $tag_id)
    {
        return $this->service->attach(
            'agents',
            'tags',
            'agent_tag',
            'agent_id',
            'tag_id',
            $agent_id,
            $tag_id
        );
    }

    public function detachAgentFromTag($agent_id, $tag_id)
    {
        return $this->service->detach(
            'agents',
            'tags',
            'agent_tag',
            'agent_id',
            'tag_id',
            $agent_id,
            $tag_id
        );
    }

    public function syncAgentsWithTag(Request $request, $agent_id)
    {
        return $this->service->sync(
            'agents',
            'tags',
            'agent_tag',
            'agent_id',
            'tag_id',
            $agent_id,
            $request->tag_ids // باید یک آرایه از IDها باشد
        );
    }
}
