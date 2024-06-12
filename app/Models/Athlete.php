<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;
    protected $fillable =([
          'user_id',  'birthdate', 'height', 'weight', 'sport','coach_id'
            
    ]);

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function coach(){
        return $this->belongsTo(Coach::class,'coach_id');
    }
}