@php
$product->image=$product->images[0] ?? RvMedia::getDefaultImage();
@endphp



<div class="product-thumbnail">
    <a class="product-loop__link img-fluid-eq" href="{{ $product->url }}" tabindex="0">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap hover-effect">
            <figure class="text-center">
                @php
                    // Prefer a compressed thumbnail file in public/storage/compressed-images/products-images/{identifier}/{filename}
                    $identifier = $product->sku ?: $product->id;
                    $originalUrl = RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage());
                    $filename = basename(parse_url($originalUrl, PHP_URL_PATH));
                    $compressedRelative = "storage/compressed-images/products-images/{$identifier}/{$filename}";
                    $compressedPath = public_path($compressedRelative);
                    $thumbUrl = RvMedia::getImageUrl($product->image, 'product-thumbnail', false, RvMedia::getDefaultImage());
                    // prefer compressed file if present
                    if (file_exists($compressedPath)) {
                        $thumbUrl = asset($compressedRelative);
                        // try to get dimensions to reduce CLS
                        try {
                            $size = @getimagesize($compressedPath);
                            if (!empty($size)) {
                                $thumbWidth = $size[0];
                                $thumbHeight = $size[1];
                            }
                        } catch (\Exception $e) {
                            // ignore
                        }
                    } else {
                        // Fallback to 'thumb' if the named variant is not available
                        if (! $thumbUrl) {
                            $thumbUrl = RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage());
                        }
                    }
                @endphp
                <img class="lazyload product-thumbnail__img"
                    src="{{ image_placeholder($thumbUrl) }}"
                    data-src="{{ $thumbUrl }}"
                    alt="{{ $product->name }}"
                    style="max-height:299px; width:100%; object-fit:contain"
                    decoding="async"
                    @if(!empty($thumbWidth) && !empty($thumbHeight)) width="{{ $thumbWidth }}" height="{{ $thumbHeight }}" @endif>
                <figcaption class="sr-only">{{ e($product->name) }}</figcaption>
            </figure>

        </div>
 <span class="ribbons">
            @if ($product->stock_status!="in_stock" ||($product->with_storehouse_management==1 && $product->quantity==0))
                <span class="ribbon out-stock bg-warning">{{ __('Out Of Stock') }}</span>
            @else

                    @if ($product->sale_price > $product->price)
                        <div class="featured ribbon" dir="ltr">{{ get_sale_percentage($product->price, $product->sale_price) }}</div>
                    @endif
                    @if (true)
                        <div class="ribbon m-1 bg-transparent" dir="ltr">
                            
                            
<form class="cart-form" action="{{ route('public.cart.add-to-cart') }}" method="POST">
    @csrf
    @if (!empty($withVariations) && $product->variations()->count() > 0)
        <div class="pr_switch_wrap">
            {!! render_product_swatches($product, [
                'selected' => $selectedAttrs,
                'view'     => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
            ]) !!}
        </div>
    @endif


    <input type="hidden"
        name="id" class="hidden-product-id"
        value="{{$product->id}}"/>

    @if (EcommerceHelper::isCartEnabled() || !empty($withButtons))
        {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product) !!}
        <div class="product-button">
            @if (EcommerceHelper::isCartEnabled())

                <button type="submit" name="add_to_cart" value="1" style="padding:5px; background-color:transparent; font-size:23px;" class="btn btn-primary  add-to-cart-button @if ($product->stock_status!="in_stock") disabled @endif" @if ($product->stock_status!="in_stock") disabled @endif title="{{ __('Add to cart') }}">
                        <i class="icon-cart"></i>
                </button>

            @endif
            
        </div>
    @endif
</form>

                            </div>
                    @endif
            @endif
        </span>
    </a>
</div>
<div class="product-details position-relative" style="background-color:#fff!important;">
    <div class="product-content-box p-1">

        <h6 class="product__title">
            <a href="{{ $product->url }}" tabindex="0"><small><p 
            style="overflow: hidden;max-width: 45ch;white-space: nowrap; text-overflow: ellipsis; font-size:13px;">
        {!! BaseHelper::clean($product->name) !!}
        </p></small></a>
        </h6>
        
        
        
        <div class="row">

<div class="col-1 pt-1"></div>
<div class="col-11 pt-1">  

<span class="product-price">
    <span class="product-price-sale d-flex align-items-center @if ($product->price <= $product->sale_price || $product->sale_price==null) d-none @endif">
        <del aria-hidden="true">
            <span class="price-amount">
                <bdi>
                    <span class="amount" style="font-size:18px;">{{ format_price($product->price) }}</span>
                </bdi>
            </span>
        </del>
        <ins>
            <span class="price-amount">
                <bdi>
                    <span class="amount" style="font-size:18px;">{{ format_price($product->sale_price) }}</span>
                </bdi>
            </span>
        </ins>
    </span>
    <span class="product-price-original @if ($product->price > $product->sale_price && $product->sale_price!=null) d-none @endif">
        <span class="price-amount">
            <bdi>
                <span class="amount" style="font-size:18px;">{{ format_price($product->price) }}</span>
            </bdi>
        </span>
    </span>
</span>

</div>
</div></div></div>
