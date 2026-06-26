<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name', 'is_active', 'created_by', 'updated_by'];
    public function leaves() { return $this->hasMany(Leave::class); }
}

