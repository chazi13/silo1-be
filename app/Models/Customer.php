<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Uuids, HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agent_id',
        'address',
        'city',
        'zip',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }
}
