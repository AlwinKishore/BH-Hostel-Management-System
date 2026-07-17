<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['batch_id', 'year_name', 'is_active', 'created_by', 'updated_by'];
    public function batch() { return $this->belongsTo(Batch::class); }
    public function hostellers() { return $this->hasMany(Hosteller::class); }
}

