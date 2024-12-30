<?php
// このコードは、店舗管理機能に関する処理を担当する ShopController というコントローラーです。主に店舗の表示、登録、編集、検索機能を扱っています。
namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 店舗一覧表示
public function index()
    {
        // 未ログインユーザーにメッセージを表示
        if (!Auth::check()) {
            session()->flash('message', 'タイトル横のアイコンを押下し、ログインしてください');
        }

// Shop::all() で全ての店舗情報を取得し、エリア情報 (Area::all()) とジャンル情報 (Genre::all()) も同時に取得します。
        $shops = Shop::all();
        $areas = Area::all();
        $genres = Genre::all();

// それらのデータをビュー shops.index に渡して、店舗一覧を表示します。
        return view('shops.index', compact('shops', 'areas', 'genres'));
    }


    // 店舗登録フォーム表示
    // 新しい店舗を登録するためのフォームを表示するメソッドです。
    public function create()
    {
// 店舗登録フォームに必要な情報（エリアとジャンル）を取得し、ビュー shops.create に渡してフォームを表示します。
        $areas = Area::all();
        $genres = Genre::all();

        return view('shops.create', compact('areas', 'genres'));
    }

    // 店舗登録処理
    public function store(ShopRequest $request)
{
// ShopRequest（カスタムリクエストクラス）によってバリデーションされたデータを元に、新しい店舗をデータベースに保存します。

        // バリデーション済みデータを取得
        $validatedData = $request->validated();


// Shop::create($validatedData) で店舗情報をデータベースに保存し、その後店舗一覧画面へリダイレクトします。
        // データベースに保存
        Shop::create($validatedData);

        // 登録完了メッセージを表示、店舗一覧画面へリダイレクト
        return redirect()->route('shops.index');
    }


    // 店舗の検索機能
    public function search(Request $request)
    {
// ユーザーが入力した検索条件（キーワード、エリア、ジャンル）を基に、店舗を検索します。
        $keyword = $request->input('keyword');
        $areaId = $request->input('area');
        $genreId = $request->input('genre');


        $query = Shop::query();  // クエリビルダを初期化
        $areas = Area::all();
        $genres = Genre::all();

        // 検索条件があれば、Shop モデルを使って条件を追加します（like 検索、area_id や genre_id の条件追加）。
        if($keyword) {
        $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($areaId) {
        $query->where('area_id', $areaId);
        }

        if($genreId) {
            $query->where('genre_id', $genreId);
        }

        $shops = $query->get();  // 検索結果を取得

        // 検索結果が0件の場合の処理
        if ($shops->isEmpty()) {
            $shops = []; // 検索結果が空の場合、空の配列を代入
        }
// 結果をビューに渡して表示。もし検索結果が空の場合は、空の配列を渡します。
        return view('shops.index', compact('shops', 'areas', 'genres'));
    }


    // 店舗詳細表示
    public function show(Shop $shop)
    {
// 特定の店舗の詳細情報を表示するメソッドです。
// Shop モデルで渡された店舗情報をビュー shops.show に渡し、その店舗の詳細を表示します。
        return view('shops.show', compact('shop'));
    }


    // 店舗編集フォーム表示
    public function edit(Shop $shop)
// 既存の店舗情報を編集するためのフォームを表示するメソッドです。
// Shop モデルを使って店舗情報を取得し、それをビュー shops.edit に渡してフォームを表示します。
    {
        return view('shops.edit', compact('shop'));
    }

}

// まとめ
// このコントローラーは、店舗情報に関連する以下の機能を提供します：

// 店舗一覧の表示 (index)
// 店舗の登録フォームの表示 (create)
// 店舗の登録処理 (store)
// 店舗の検索機能 (search)
// 店舗の詳細表示 (show)
// 店舗の編集フォームの表示 (edit)
// それぞれのメソッドが異なるアクションを担当しており、ビューに必要なデータを渡して、ユーザーが店舗情報を確認・追加・編集・検索できるようにしています。