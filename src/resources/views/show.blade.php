@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('products.index') }}" class="text-decoration-none text-primary">商品一覧</a> > {{ $product->name }}

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('PATCH')
            <div class="row mt-4">
                <div class="col-md-5">
                    <img src="{{ asset($product->img) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                    <input type="file" name="img" class="form-control mt-3">
                    @error('img')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-7">
                    <div class="mb-3">
                        <label for="name" class="form-label">商品名</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="商品名を入力"
                            style="color: #6c757d;" onfocus="this.removeAttribute('style')"
                            value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">値段</label>
                        <input type="number" id="price" name="price" class="form-control" placeholder="値段を入力"
                            style="color: #6c757d;" onfocus="this.removeAttribute('style')"
                            value="{{ old('price', $product->price) }}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">季節</label>
                        <div>
                            @foreach ($seasons as $season)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="seasons[]"
                                        value="{{ $season->id }}"
                                        {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $season->name }}</label>
                                </div>
                            @endforeach
                            @error('seasons')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">商品説明</label>
                        <textarea id="description" name="description" class="form-control" placeholder="商品説明を入力" style="color: #6c757d;"
                            onfocus="this.removeAttribute('style')" rows="5">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning">変更を保存</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
        </form>
        <div class="d-flex justify-content-end align-items-center mb-3">
            <form action="{{ route('products.destroy', $product) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger p-0" style="border: none; background: transparent;">
                    <img src="{{ asset('images/trash-icon.png') }}" alt="削除" style="width: 30px; height: 30px;">
                </button>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
