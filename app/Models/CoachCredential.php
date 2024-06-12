<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'seminar_name',
        'seminar_date',
        'additional_details',
    ];

    protected $casts = [
        'seminar_date' => 'date', 
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
