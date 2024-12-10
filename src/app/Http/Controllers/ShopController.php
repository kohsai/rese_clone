<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    // 店舗一覧表示
public function index()
    {
        // Shop モデルの all() メソッドを使って、すべての店舗情報を取得し、shops 変数に格納しています。その後、shops.index ビューに shops 変数を渡しています。
        $shops = Shop::all();
        return view('shops.index', compact('shops'));
    }

    // 店舗登録フォーム表示
    public function create()
    {
        return view('shops.create');
    }

    // 店舗登録処理
    public function store(ShopRequest $request)
{
    // バリデーション済みデータを取得
        $validatedData = $request->validated();


        // データベースに保存
        Shop::create($validatedData);

        // 登録完了メッセージを表示、店舗一覧画面へリダイレクト
        return redirect()->route('shops.index')->with('success', '店舗が登録されました。');
    }



    // 店舗詳細表示
    public function show(Shop $shop)
    {
        return view('shops.show', compact('shop'));
    }

    // 店舗編集フォーム表示
    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }

}
