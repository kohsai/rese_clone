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
        $keyword = $request->input('keyword');
        $areaId = $request->input('area');
        $genreId = $request->input('genre');


        $query = Shop::query();
        $areas = Area::all();
        $genres = Genre::all();

        if($keyword) {
        $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($areaId) {
        $query->where('area_id', $areaId);
        }

        if($genreId) {
            $query->where('genre_id', $genreId);
        }

        $shops = $query->get();

        // 検索結果が0件の場合の処理
        if ($shops->isEmpty()) {
            $shops = []; // 検索結果が空の場合、空の配列を代入
        }

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
