<section class="list-products products-archive">
    <ul>
    @if ($products->count() > 0)
        @foreach ($products as $product)
            @php
                $identifier = $product->sku ?: $product->id;
                $originalUrl = RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage());
                $filename = basename(parse_url($originalUrl, PHP_URL_PATH));
                $compressedRelative = "storage/compressed-images/products-images/{$identifier}/{$filename}";
                $compressedPath = public_path($compressedRelative);
                $thumbUrl = RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage());
                $thumbWidth = $thumbHeight = null;
                if (file_exists($compressedPath)) {
                    $thumbUrl = asset($compressedRelative);
                    try {
                        $size = @getimagesize($compressedPath);
                        if (!empty($size)) {
                            $thumbWidth = $size[0];
                            $thumbHeight = $size[1];
                        }
                    } catch (\Exception $e) {}
                }
            @endphp
            <li>
                <div class="product-item product-loop">
                    <img class="lazyload product-item-thumb" src="{{ image_placeholder($thumbUrl) }}" data-src="{{ $thumbUrl }}" @if(!empty($thumbWidth) && !empty($thumbHeight)) width="{{ $thumbWidth }}" height="{{ $thumbHeight }}" @endif alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <span class="price">
                        {!! the_product_price($product) !!}
                    </span>
                    <div class="product-action">
                        <a data-quantity = '1' data-product = '{{ $product->id }}' href="javascript: void(0);" class="btn btn-info">{{ __('Add to cart') }}</a>
                    </div>
                </div>
            </li>
        @endforeach
    @endif
    </ul>
</section>
