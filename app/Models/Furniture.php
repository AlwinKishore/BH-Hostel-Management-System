<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    protected $fillable = ['name', 'type', 'code', 'room_id', 'condition', 'status'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
