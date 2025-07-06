<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentAILabel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "ai_labels";
    protected $guarded = [];

}
