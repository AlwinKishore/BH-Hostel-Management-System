<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['attendance_date', 'hosteller_id', 'is_present', 'submitted_by', 'created_by', 'updated_by'];
    public function hosteller() { return $this->belongsTo(Hosteller::class); }
    public function submittedBy() { return $this->belongsTo(User::class, 'submitted_by'); }
}

