<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customize extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo_path',
        'sport_id'

    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
    public function sport() {
        return $this->belongsTo(Sport::class,'sport_id');
    }
}
