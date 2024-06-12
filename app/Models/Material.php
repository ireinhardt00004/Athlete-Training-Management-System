<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['material_number','user_id','title','content','sport_id','event_id'];

    public function files()
    {
        return $this->hasMany(MaterialFile::class);
    }
    public function users() {
        return $this->hasMany(User::class);
    }
   public function sport() {
    return $this->belongsTo(Sport::class);
    }
    public function checklists() {
        return $this->hasMany(Checklist::class);
    }
     public function event() {
        return $this->hasMany(Checklist::class);
    }



}
