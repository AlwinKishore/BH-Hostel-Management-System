<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['building_id', 'room_number', 'floor', 'capacity', 'type', 'price', 'status'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function furniture()
    {
        return $this->hasMany(Furniture::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
