<?php

namespace App\Repositories\Tag;

use App\Models\Agent\AgentTag;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Tag\TagRepositoryInterfaces;

class TagRepository extends BaseRepository implements TagRepositoryInterfaces
{
    public function __construct(AgentTag $model)
    {
        parent::__construct($model);
    }
}
