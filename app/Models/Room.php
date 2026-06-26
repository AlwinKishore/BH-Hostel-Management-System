<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_no', 'room_category', 'floor', 'accommodation', 'is_full', 'is_available', 'created_by', 'updated_by'];
    public function hostellers() { return $this->hasMany(Hosteller::class); }
    public function category() { return $this->belongsTo(Category::class, 'room_category'); }
}

