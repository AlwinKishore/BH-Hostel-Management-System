<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['academic_year_id', 'batch_name', 'is_active', 'created_by', 'updated_by'];
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
    public function hostellers() { return $this->hasMany(Hosteller::class); }
}

