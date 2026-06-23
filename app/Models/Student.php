<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'id_proof_number', 'id_proof_type', 
        'photo', 'room_id', 'joining_date', 'status',
        'total_bill', 'paid_amount', 'payment_status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
