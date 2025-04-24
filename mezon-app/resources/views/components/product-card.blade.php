@props(['product'])

<div class="box  {{ $product->quantity === 0 ? 'out-of-stock' : '' }}">
    <div class="img-box">
        <img class="img-fluid" src="{{ imageUrl($product->primary_image) }}" alt="{{ $product->name }}">
    </div>
    <div class="detail-box">
        <h5>
            <a href="{{ route('products.show', ['product' => $product->slug]) }}">
                {{ $product->name }}
            </a>
        </h5>
        <p>{{ mb_substr($product->description, 0, 300) }}...</p>
        <div class="options">
            @if ($product->quantity > 0) {{-- برای محصولات موجود --}}
            <h6>
                @if ($product->is_sale)
                <div>
                    <del>{{ number_format($product->price) }}</del>
                    <span class="text-danger">
                        ({{ salePercent($product->price, $product->sale_price) }}%)
                    </span>
                </div>
                {{ number_format($product->sale_price) }} تومان
                @else
                {{ number_format($product->price) }} تومان
                @endif
            </h6>
            @endif
            <div class="d-flex">
                @if ($product->quantity < 1)
                    <a class="me-2 bg-danger" href="#"  data-bs-toggle="tooltip" title="اگه موجود شد به من خبر بده">
                        <i class="bi bi-bell  text-white fs-6" ></i>
                    </a>
                @else
                    <a class="me-2" href="#">
                        <i class="bi bi-cart-fill text-white fs-6"></i>
                    </a>
                @endif
            
                <a href="#"><i class="bi bi-heart-fill text-white fs-6"></i></a>
            </div>
            
        </div>
    </div>
</div>

