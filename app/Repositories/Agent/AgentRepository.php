<?php

namespace App\Repositories\Agent;

use App\Models\Agent\Agent;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Agent\AgentRepositoryInterfaces;

class AgentRepository extends BaseRepository implements AgentRepositoryInterfaces
{
    public function __construct(Agent $model)
    {
        parent::__construct($model);
    }

    public function checkExistsAgentByMac($mac_address): bool
    {
        return $this->model->query()->where('mac_address', $mac_address)->exists();
    }
}
