<div class="row cart-item">
    <div class="col-3">
        <div class="checkout-product-img-wrapper">
            @php
                $prod = $product->original_product ?: $product;
                $identifier = $prod->sku ?: $prod->id;
                $originalUrl = RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage());
                $filename = basename(parse_url($originalUrl, PHP_URL_PATH));
                $compressedRelative = "storage/compressed-images/products-images/{$identifier}/{$filename}";
                $compressedPath = public_path($compressedRelative);
                $thumb = RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage());
                if (file_exists($compressedPath)) {
                    $thumb = asset($compressedRelative);
                }
            @endphp
            <img class="item-thumb img-thumbnail img-rounded lazyload" src="{{ image_placeholder($thumb) }}" data-src="{{ $thumb }}" alt="{{ $product->original_product->name }}">
            <span class="checkout-quantity">{{ $cartItem->qty }}</span>
        </div>
    </div>
    <div class="col">
        <p class="mb-0">{{ $product->original_product->name }} @if ($product->isOutOfStock()) <span class="stock-status-label">({!! $product->stock_status_html !!})</span> @endif</p>
        <p class="mb-0">
            <small>{{ $product->variation_attributes }}</small>
        </p>

        @include('plugins/ecommerce::themes.includes.cart-item-options-extras', ['options' => $cartItem->options])

        @if (! empty($cartItem->options['options']))
            {!! render_product_options_html($cartItem->options['options'], $product->original_price) !!}
        @endif
    </div>
    <div class="col-auto text-end">
        <p>{{ format_price($cartItem->price) }}</p>
    </div>
</div>
