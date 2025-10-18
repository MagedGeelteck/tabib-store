<div class="table">
    <table>
        <tr>
            <th style="text-align: left">
                {{ trans('plugins/ecommerce::products.product_image') }}
            </th>
            <th style="text-align: left">
                {{ trans('plugins/ecommerce::products.form.product') }}
            </th>
        </tr>

        @foreach ($products as $product)
            @php
                $identifier = $product->sku ?: $product->id;
                $originalUrl = RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage());
                $filename = basename(parse_url($originalUrl, PHP_URL_PATH));
                $compressedRelative = "storage/compressed-images/products-images/{$identifier}/{$filename}";
                $compressedPath = public_path($compressedRelative);
                $thumb = RvMedia::getImageUrl($product->image, 'thumb');
                if (file_exists($compressedPath)) {
                    $thumb = asset($compressedRelative);
                }
            @endphp
            <tr>
                <td>
                    <img src="{{ $thumb }}" alt="{{ $product->name }}" width="50">
                </td>
                <td>
                    <a href="{{ route('public.product.review', $product->slug) }}">{{ $product->name }}</a>
                </td>
            </tr>
        @endforeach
    </table><br>
</div>

