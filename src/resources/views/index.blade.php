@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <h4>商品一覧</h4>
            <form action="{{ route('products.index') }}" method="GET" class="mb-3">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="商品名で検索">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <button type="submit" class="btn btn-warning mt-2 w-100">検索</button>
            </form>

            <label for="sort" class="form-label">価格順で表示</label>
            <select id="sort" class="form-select mb-3" onchange="applySort(this.value)">
                <option value="" disabled selected>価格で並び替え</option> <!-- プレースホルダーとして機能 -->
                <option value="{{ route('products.index', ['sort' => 'asc', 'search' => request('search')]) }}"
                    {{ request('sort') == 'asc' ? 'selected' : '' }}>安い順</option>
                <option value="{{ route('products.index', ['sort' => 'desc', 'search' => request('search')]) }}"
                    {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順</option>
            </select>

            <script>
                function applySort(url) {
                    location.href = url;
                }
            </script>

            {{-- タグ表示 --}}
            @if (request('sort'))
                <div class="mb-3">
                    <span class="badge bg-warning text-dark">
                        {{ request('sort') == 'asc' ? '低い順に表示' : '高い順に表示' }}
                        <a href="{{ route('products.index') }}" class="text-dark ms-2" style="text-decoration: none;">
                            &times;
                        </a>
                    </span>
                </div>
            @endif

        </div>

        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <img src="{{ asset($product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">¥{{ number_format($product->price) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
