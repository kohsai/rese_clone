<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'num_of_users',
        'start_at',
    ];

    // start_atをCarbonインスタンスとしてキャスト
    protected $casts = [
        'start_at' => 'datetime', // これによりstart_atが自動的にCarbonインスタンスに変換されます
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
