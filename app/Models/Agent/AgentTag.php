<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentTag extends Model
{
    use HasFactory;
    protected $table = "tags";
    protected $guarded = [];

    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(Agent::class, 'agent_tag', 'tag_id', 'agent_id');
    }
}
