<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['batch_name', 'start_date', 'end_date', 'is_current', 'created_by', 'updated_by'];
    public function hostellers() { return $this->hasMany(Hosteller::class); }
}

