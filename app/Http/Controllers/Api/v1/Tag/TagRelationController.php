<?php

namespace App\Http\Controllers\Api\v1\Tag;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use Illuminate\Http\Request;

class TagRelationController extends Controller
{
    private PivotServiceInterfaces $service;

    public function __construct(PivotServiceInterfaces $service)
    {
        $this->service = $service;
    }

    //    -------------------------- agent --------------------------
    public function attachAgentToTag($tag_id, $agent_id)
    {
        return $this->service->attach(
            'tags',
            'agents',
            'agent_tag',
            'tag_id',
            'agent_id',
            $tag_id,
            $agent_id
        );
    }

    public function detachAgentFromTag($tag_id, $agent_id)
    {
        return $this->service->detach(
            'tags',
            'agents',
            'agent_tag',
            'tag_id',
            'agent_id',
            $tag_id,
            $agent_id
        );
    }

    public function syncAgentsWithTag(Request $request, $tag_id)
    {
        return $this->service->sync(
            'tags',
            'agents',
            'agent_tag',
            'tag_id',
            'agent_id',
            $tag_id,
            $request->agent_ids // باید یک آرایه از IDها باشد
        );
    }
}
