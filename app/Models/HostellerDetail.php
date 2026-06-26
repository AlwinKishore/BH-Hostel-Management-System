<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HostellerDetail extends Model
{
    protected $fillable = ['hosteller_id', 'dob', 'address', 'town', 'city', 'district', 'pincode', 'created_by', 'updated_by'];
    public function hosteller() { return $this->belongsTo(Hosteller::class); }
}

