<?php

namespace App\Http\Controllers;

use App\Models\shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
public function index()
    {
        $shops = Shop::all();
        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    { // バリデーション処理
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'area' => 'required',
            'genre' => 'required',
            'description' => 'nullable',
        ]);

        $imagePath = $request->file('image')->store('public/shops');


        // データベースに保存
        Shop::create([
            'name' => $validatedData['name'],
            'image_url' => Storage::url($imagePath),
            'area' => $validatedData['area'],
            'genre' => $validatedData['genre'],
            'description' => $validatedData['description'],
        ]);

        // 登録完了メッセージを表示
        return redirect()->route('shops.index')->with('success', '店舗が登録されました。');
    }

    public function show(Shop $shop)
    {
        return view('shops.show', compact('shop'));
    }


    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image_url' => 'required',
            'area' => 'required',
            'genre' => 'required',
            'description' => 'nullable',
        ]);

        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/shops');
            $validatedData['image_url'] = Storage::url($imagePath);
        }


        $shop->update($validatedData);

        return redirect()->route('shops.detail', $shop)->with('success', '店舗が更新されました。');
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();

        return redirect()->route('shops.index')->with('success', '店舗が削除されました。');
    }
}
