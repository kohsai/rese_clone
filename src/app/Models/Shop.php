<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'area_id',
        'genre_id',
        'description',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isFavoritedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

}
