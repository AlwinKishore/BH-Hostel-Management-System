<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hosteller extends Model
{
    protected $guarded = [];
    public function batch() { return $this->belongsTo(Batch::class); }
    public function year() { return $this->belongsTo(Year::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function hostellerDetail() { return $this->hasOne(HostellerDetail::class); }
    public function leaves() { return $this->hasMany(Leave::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function remarks() { return $this->hasMany(Remark::class); }
}

