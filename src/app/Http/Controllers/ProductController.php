<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');

        // 検索条件と並び替え条件を適用
        $products = Product::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('price', $sort)
            ->paginate(6);

        return view('index', compact('products'));
    }

    // 商品詳細画面を表示する
    public function show(Product $product)
    {
        // 季節情報を取得（Eloquentコレクションとして取得）
        $seasons = Season::all();
        return view('show', compact('product', 'seasons'));
    }

    // 商品情報を更新する
    public function update(ProductRequest $request, Product $product)
    {

        // 画像ファイルインスタンス取得
        $img = $request->file('img');
        // 現在の画像へのパスをセット
        $path = $product->img;
        $path = str_replace('storage/', '',$path);
        
        if (isset($img)) {
            // 現在の画像ファイルの削除
            \Storage::disk('public')->delete($path);
            // 選択された画像ファイルを保存してパスをセット(これはstorageフォルダ内への保存)
            $path = $img->store('products', 'public');
            //storage内に保存した画像データをセット
            $path = "storage/".$path;
            $product->img = $path;
        }

         // seasonsの配列を取得（選択された季節が配列で渡される）
        $selectedSeasons = $request->input('seasons', []);
        // 商品と季節の関連付けを更新
        $product->seasons()->sync($selectedSeasons);

        // フォームから送信された他のデータをセット
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        // データベースに保存
        $product->save();

        // 商品詳細ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('products.show', $product)->with('success', '商品情報が更新されました。');

    }

    // 商品を削除する
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品が削除されました。');
    }

    public function create()
    {
        $seasons = Season::all(); // 季節のデータを取得
        return view('register', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();

        // 画像ファイルインスタンス取得
        $img = $request->file('img');

        // 画像がアップロードされたかどうか確認
        if (isset($img)) {
            // 画像を保存してパスを取得
            $path = $img->store('products', 'public');
            $product->img = 'storage/' . $path;
        } else {
            // デフォルト画像のパスを設定
            $product->img = 'storage/default/default.png';
        }

        // フォームからの入力をモデルにセット
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        // データを保存
        $product->save();

        // 季節との関連付けを保存
        $product->seasons()->sync($request->seasons);

        // 成功メッセージとともにリダイレクト
        return redirect()->route('products.index')->with('success', '商品が登録されました。');
    }




}
