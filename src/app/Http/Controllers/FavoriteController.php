<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Shop $shop)
    {
        if ($shop->isFavoritedByUser(auth()->id())) {
            // お気に入り解除
            $shop->likes()->where('user_id', auth()->id())->delete();
        } else {
            // お気に入り登録
            $shop->likes()->create(['user_id' => auth()->id()]);
        }

        return redirect()->back();
    }
}
