<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;
    protected $fillable =([
            'coach_number', 'user_id', 'sport_id'
            
    ]);

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function sport() {
        return $this->belongsTo(Sport::class,'sport_id');
    }
    public function events() {
        return $this->hasMany(Event::class);
    }
    public function credentials()
    {
        return $this->hasMany(CoachCredential::class);
    }
}
