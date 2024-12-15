<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;

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

    // 検索フォームの処理
    public function search(Request $request)
    {
        $query = $request->input('query');
        $areaID = $request->input('area');
        $genreID = $request->input('genre');

        // エリアとジャンルのデータを取得
        $areas = Area::all();
        $genres = Genre::all();

        // 店舗情報を検索
        $shops = Shop::query();

        if($query) {
        $shops->where('name', 'like', '%' . $query . '%');
        }

        if ($areaID !== 'all') {
        $shops->where('area_id', $areaID);
        }

        if($genreID !== 'all') {
            $shops->where('genre_id', $genreID);
        }

        $shops = $shops->get();

        return view('shops.index', compact('shops', 'areas', 'genres'));
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
