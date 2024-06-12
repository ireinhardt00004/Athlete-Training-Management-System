<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'field_name',
        'field_type',
        'options',
        'minimum_threshold',
        'maximum_threshold',
        'is_required'
    ];


    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function responses()
    {
        return $this->hasMany(ChecklistResponse::class);
    }
}
