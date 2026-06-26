<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['year_name', 'is_active', 'created_by', 'updated_by'];
    public function hostellers() { return $this->hasMany(Hosteller::class); }
}

