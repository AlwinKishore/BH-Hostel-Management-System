<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'student_id', 'category', 'title', 'description', 
        'status', 'resolution_notes', 'resolved_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
