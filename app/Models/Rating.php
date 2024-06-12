<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['checklist_id', 'user_id', 'rating', 'is_completed'];

    // Define relationship with Checklist model
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method to store a rating
    public static function storeRating($checklistId, $userId, $rating, $isCompleted)
    {
        return Rating::updateOrCreate(
            ['checklist_id' => $checklistId, 'user_id' => $userId],
            ['rating' => $rating, 'is_completed' => $isCompleted]
        );
    }

    // Other methods as needed
}
