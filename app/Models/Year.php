<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $guarded = [];
    public function hostellers() { return $this->hasMany(Hosteller::class); }
}

