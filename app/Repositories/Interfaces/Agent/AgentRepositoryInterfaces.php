<?php

namespace App\Repositories\Interfaces\Agent;

use App\Repositories\Interfaces\BaseRepositoryInterfaces;

interface AgentRepositoryInterfaces extends BaseRepositoryInterfaces
{
    public function checkExistsAgentByMac($mac_address): bool;
}
