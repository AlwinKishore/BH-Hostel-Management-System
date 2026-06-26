<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = ['hosteller_id', 'remarks', 'created_by', 'updated_by'];
    public function hosteller() { return $this->belongsTo(Hosteller::class); }
}

