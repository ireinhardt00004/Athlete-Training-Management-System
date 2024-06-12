<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    use HasFactory;
    protected $fillable = [
        'coach_id',
        'athlete_id',
        'sport_id'
    ];

    public function coaches()
    {
        return $this->hasOne(Coach::class, 'coach_id');
    }
    public function athletes() {
        return $this->belongsTo(Athlete::class,'athlete_id');
    }
    public function sports() {
    return $this->belongsTo(Sport::class,'sport_id');
    }


}



