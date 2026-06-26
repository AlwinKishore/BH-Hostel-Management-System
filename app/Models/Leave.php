<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['hosteller_id', 'start_date', 'end_date', 'category_id', 'reason', 'assigned_to', 'is_approved', 'response_on', 'rejected_reason', 'created_by', 'updated_by'];
    public function hosteller() { return $this->belongsTo(Hosteller::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function assignedTo() { return $this->belongsTo(User::class, 'assigned_to'); }
}

