<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = ['name', 'room_type', 'amount', 'frequency', 'building_id', 'description'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
