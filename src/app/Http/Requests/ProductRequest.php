<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {
    /**
    * 認可の設定
    */

    public function authorize() {
        return true;
    }

    /**
    * バリデーションルールを設定
    */

    public function rules() {
        return [
            'name' => 'required',
            'price' => 'required|numeric|max:10000',
            'seasons' => 'required|array|min:1',
            'description' => 'required|max:120',
            'img' => 'nullable|mimes:png,jpeg',
        ];
    }

    /**
    * カスタムエラーメッセージを設定
    */

    public function messages() {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'img.required' => '商品画像を登録してください',
            'img.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }

    public function withValidator( $validator ) {
        $validator->after( function ( $validator ) {
            // コントローラーから受け取った Product モデルを使う
            $product = $this->route('product'); // ルートバインディングされた Product モデルを取得

            if ($product && !$product->img && !$this->hasFile('img')) {
                $validator->errors()->add('img', '商品画像を登録してください');
            }
        });
    }
}
