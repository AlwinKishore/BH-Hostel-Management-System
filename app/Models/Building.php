<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = ['name', 'address', 'total_floors', 'total_rooms', 'capacity', 'status'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
