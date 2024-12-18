<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    // 店舗一覧表示
public function index()
    {
        $shops = Shop::all();
        $areas = Area::all();
        $genres = Genre::all();

        return view('shops.index', compact('shops', 'areas', 'genres'));
    }

    // 店舗登録フォーム表示
    public function create()
    {
        $areas = Area::all();
        $genres = Genre::all();

        return view('shops.create', compact('areas', 'genres'));
    }

    // 店舗登録処理
    public function store(ShopRequest $request)
{
    // バリデーション済みデータを取得
        $validatedData = $request->validated();


        // データベースに保存
        Shop::create($validatedData);

        // 登録完了メッセージを表示、店舗一覧画面へリダイレクト
        return redirect()->route('shops.index');
    }

    // 検索フォームの処理
    public function search(Request $request)
    {
        $query = $request->input('query');
        $area = $request->input('area');
        $genre = $request->input('genre');

        // エリアとジャンルのデータを取得
        $areas = Area::all();
        $genres = Genre::all();

        // 店舗情報を検索
        $shops = Shop::query();

        if($query) {
        $shops->where('name', 'like', '%' . $query . '%');
        }

        if ($area) {
        $shops->where('area', 'like', '%' . $area . '%');
        }

        if($genre) {
            $shops->where('genre', 'like', '%' . $genre . '%');
        }

        $shops = $shops->get();

        return view('shops.index', compact('shops'));
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
