<?php

namespace App\Models\Agent;

use App\Models\Department\Department;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;
    protected $table = "agents";
    protected $guarded = [];
    protected $fillable = [
        'hostname',
        'ip_address',
        'os',
        'os_version',
        'mac_address',
        'boot_time',
        'status',
        'token'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(AgentAlert::class, 'agent_id');
    }

    public function commands(): HasMany
    {
        return $this->hasMany(AgentCommand::class, 'agent_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(AgentTag::class, 'agent_tag', 'agent_id', 'tag_id');
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(AgentSnapshot::class, 'agent_id');
    }

    public function screenshots(): HasMany
    {
        return $this->hasMany(AgentScreenshot::class, 'agent_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AgentLog::class, 'agent_id');
    }
}
