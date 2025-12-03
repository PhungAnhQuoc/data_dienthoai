@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="bi bi-heart-fill text-danger"></i> Sản phẩm yêu thích
            </h1>
        </div>
    </div>

    @if ($wishlistItems->count() > 0)
        <div class="row">
            @foreach ($wishlistItems as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Product Image -->
                        <div class="position-relative overflow-hidden" style="height: 250px; background: #f5f5f5;">
                            @if ($item->product->images->first())
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-100 h-100 object-fit-cover">
                            @else
                                <img src="https://via.placeholder.com/400x300?text={{ urlencode($item->product->name) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-100 h-100 object-fit-cover">
                            @endif
                            
                            <!-- Remove from Wishlist Button -->
                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Xóa khỏi yêu thích">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                        </div>

                        <div class="card-body">
                            <!-- Product Name -->
                            <h5 class="card-title text-truncate mb-2">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none text-dark">
                                    {{ $item->product->name }}
                                </a>
                            </h5>

                            <!-- Price -->
                            <div class="mb-3">
                                <span class="h5 text-primary fw-bold">
                                    {{ number_format($item->product->price, 0, ',', '.') }} ₫
                                </span>
                                @if ($item->product->original_price && $item->product->original_price > $item->product->price)
                                    <span class="text-muted text-decoration-line-through ms-2">
                                        {{ number_format($item->product->original_price, 0, ',', '.') }} ₫
                                    </span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            <form action="{{ route('cart.add') }}" method="POST" class="d-grid">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                {{ $wishlistItems->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info text-center py-5" role="alert">
            <i class="bi bi-heart" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-3 mb-0">Chưa có sản phẩm yêu thích nào. <a href="{{ route('products.index') }}">Tiếp tục mua sắm</a></p>
        </div>
    @endif
</div>
@endsection
