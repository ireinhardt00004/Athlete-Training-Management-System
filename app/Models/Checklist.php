<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','description',
        'coach_id',
        'material_id'
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
    public function material() {
        return $this->belongsTo(Material::class,'material_id');
    }
    public function items() {
        return $this->hasMany(ChecklistItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
