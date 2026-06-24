<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $guarded = [];
    public function hosteller() { return $this->belongsTo(Hosteller::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function assignedTo() { return $this->belongsTo(User::class, 'assigned_to'); }
}

