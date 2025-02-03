<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['psychologist_id', 'start_time', 'end_time', 'is_booked'];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }
}
