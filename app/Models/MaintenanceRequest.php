<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'room_id', 'student_id', 'title', 'description', 
        'priority', 'status', 'scheduled_date', 'completion_date', 'cost'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
