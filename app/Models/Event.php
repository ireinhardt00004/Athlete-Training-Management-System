<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
class Event extends Model
{
    use Notifiable;

    use HasFactory;
    protected $fillable = ['user_id','title','description', 'priority', 'start_date', 'end_date','coach_id','sport_id'];

    
    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class, 'user_id');
    }
    public function coach() {
        return $this->belongsTo(Coach::class);
    }

    public function sport() {
        return $this->belongsTo(Sport::class);
    }
    public function material() {
        return $this->belongsTo(Material::class);
    }
}


