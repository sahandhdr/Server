<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "agent_details";
    protected $guarded = [];
}
