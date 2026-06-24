<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HostellerDetail extends Model
{
    protected $guarded = [];
    public function hosteller() { return $this->belongsTo(Hosteller::class); }
}

