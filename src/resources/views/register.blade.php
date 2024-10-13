@extends('layouts.app')

@section('content')
    <div class="container mt-5 w-50">
        <h2 class="mb-4">商品登録</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 商品名 --}}
            <div class="mb-4">
                <label for="name" class="form-label">商品名 <span class="text-danger">必須</span></label>
                <input type="text" name="name" class="form-control" placeholder="商品名を入力" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- 値段 --}}
            <div class="mb-4">
                <label for="price" class="form-label">値段 <span class="text-danger">必須</span></label>
                <input type="number" name="price" class="form-control" placeholder="値段を入力" value="{{ old('price') }}">
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- 商品画像 --}}
            <div class="mb-4">
                <label for="img" class="form-label">商品画像 <span class="text-danger">必須</span></label>
                <input type="file" name="img" class="form-control">
                @error('img')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- 季節 --}}
            <div class="mb-4">
                <label class="form-label">季節 <span class="text-danger">必須</span> <span
                        class="text-muted">複数選択可</span></label>
                <div>
                    @foreach ($seasons as $season)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $season->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('seasons')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- 商品説明 --}}
            <div class="mb-4">
                <label for="description" class="form-label">商品説明 <span class="text-danger">必須</span></label>
                <textarea name="description" class="form-control" rows="4" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="d-flex justify-content-center mt-3 mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">戻る</a>
                <button type="submit" class="btn btn-warning">登録</button>
            </div>
        </form>
    </div>
@endsection
