<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'number_of_athlete_allowed'
    ];

    public function customize()
    {
        return $this->hasOne(Customize::class, 'sport_id');
    }

    public function materials() {
    return $this->hasMany(Material::class);
    }

    public function coaches() {
        return $this->hasMany(Coach::class, 'sport_id');
    }

}
