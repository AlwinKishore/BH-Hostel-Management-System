<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'is_current', 'created_by', 'updated_by'];
    public function batches() { return $this->hasMany(Batch::class); }
    public function hostellers() { return $this->hasMany(Hosteller::class); }
}

