<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'studio_id', 'rating', 'comment', 'provider_reply', 'replied_at'];


    protected $casts = [
        'replied_at' => 'datetime',
    ];
    /**
     * ความสัมพันธ์: รีวิวนี้เป็นของสตูดิโอไหน
     */
    public function studio()
    {
        // ✅ เพิ่มบรรทัดนี้เพื่อให้เรียก $review->studio ได้
        return $this->belongsTo(Studio::class);
    }

    /**
     * ความสัมพันธ์: ใครเป็นคนรีวิว
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}