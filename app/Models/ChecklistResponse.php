<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistResponse extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_item_id', 'athlete_id', 'completed'];

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class);
    }

    public function athlete()
    {
        return $this->belongsTo(User::class, 'athlete_id');
    }
}
