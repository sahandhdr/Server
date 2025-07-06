<?php

namespace App\Repositories\AgentSnapshot;

use App\Models\Agent\AgentSnapshot;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\AgentSnapshot\AgentSnapshotRepositoryInterfaces;

class AgentSnapShotRepository extends BaseRepository implements AgentSnapshotRepositoryInterfaces
{
    public function __construct(AgentSnapshot $model)
    {
        parent::__construct($model);
    }
}
