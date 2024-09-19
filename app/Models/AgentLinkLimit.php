<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentLinkLimit extends Model
{
    use HasFactory;
    protected $table = 'agent_linklimit';

    protected $fillable = [
        'limit_amount', 'agentID'
        // Add other fields as needed
    ];

    public function agent()
{
    return $this->belongsTo(Admin::class, 'agentID');
}
}
