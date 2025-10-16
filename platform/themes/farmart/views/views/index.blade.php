@section('head')
    <title>Buy Organic & Healthy Food Online in Jordan | Tabib Jo Store</title>
    <meta name="description" content="Shop healthy, organic, sugar-free, and keto products online in Jordan. Fast delivery from Tabib Jo's trusted store.">
@endsection
@php

if(BaseHelper::siteLanguageDirection() == 'rtl'){
$langcode='ar';
}else{
$langcode='en';
}

$category_id=request()->segment(count(request()->segments()));



@endphp

@push('header')
    {{-- Add SEO keywords and non-visual title augmentation for homepage (no UI impact) --}}
    <meta name="keywords" content="online pharmacy, health products, medicines, medical supplies, Amman, Jordan, tabib">
    <script>
        // Append a small keyword phrase to the page title for SEO/serp without changing layout
        try {
            if (document && document.title) {
                var kws = ' - Online Pharmacy & Health Products in Jordan';
                if (document.title.indexOf(kws) === -1) {
                    document.title = document.title + kws;
                }
            }
        } catch (e) {
            // silent
        }
    </script>
@endpush

{{-- Visually hidden H2 for improved heading structure (does not affect UI) --}}
<h2 class="visually-hidden">Online pharmacy, health products, medicines and medical supplies in Amman, Jordan</h2>



   
    
    <div class="section-content lazyload bg-light">
            <div class="row gx-0 gx-md-4">
                <div class="col-md-12">
                    <div class="section-slides-wrapper">
                        <div class="slide-body slick-slides-carousel active">
                                <div class="slide-item">
                                    <div class="slide-item__image">
                                    @php
                                     $slider=DB::table('simple_slider_items')->orderBy('id','DESC')->first();
                                     $sliderUrl = $slider ? RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) : null;
                                    @endphp
                                            {{-- Preload the slider LCP image to improve Largest Contentful Paint --}}
                                            @if(!empty($sliderUrl))
                                                <link rel="preload" as="image" href="{{ $sliderUrl }}">
                                            @endif
                                            <picture>
                                                <source srcset="{{ $sliderUrl }}" media="(min-width: 1200px)" />
                                                <source srcset="{{ $sliderUrl }}" media="(min-width: 768px)" />
                                                <source srcset="{{ $sliderUrl }}" media="(max-height: 767px)" />
                                                {{-- Use the optimized slider URL (fall back to raw path if needed) --}}
                                                <img loading="eager" fetchpriority="high" decoding="async" src="{{ $sliderUrl ?: ($slider->image ?? '') }}" alt="slider"
                                                     width="1600" height="900"
                                                     style="border-radius:10px; max-width:100%; height:100%; object-fit:cover;">
                                                <noscript>
                                                    <img src="{{ $sliderUrl ?: ($slider->image ?? '') }}" alt="slider" width="1600" height="900" style="border-radius:10px; max-width:100%; height:100%; object-fit:cover;">
                                                </noscript>
                                            </picture>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>


<div class="scroll" style="
margin: 0px auto; padding:3px; margin-bottom:10px;background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                @foreach($all_categories as $category)
                                        <a href="{{ route('products.category',$category->id) }}">
                                    <span class="font-weight-bold text-dark categories-slider">{{ $category->name }}</button>
                                    </a>
                                @endforeach

        </div>




  


<div class="scrolling-pagination bg-light">            
 <div class="row">  
     
@foreach($products as $product)

<div class="col-lg-2 col-md-2 col-6 p-2">  
<a class="img-fluid-eq" href="/{{$langcode}}{{ $product->url }}">


<div class="product-thumbnail" style="background-color:#fff!important; max-height:300px;">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap hover-effect">
            <figure class="text-center">
            <img class="lazyload product-thumbnail__img"
                loading="lazy"
                decoding="async"
                fetchpriority="low"
                width="200"
                height="200"
                src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                data-src="/storage/compressed-images/{{ $product->image }}"
                data-srcset="/storage/compressed-images/{{ $product->image }} 300w, /storage/compressed-images/{{ $product->image }} 600w"
                sizes="(max-width: 600px) 100vw, 200px"
            alt="{{ $product->name }}" style="max-height:299px;"> 
            <noscript>
                <img src="/storage/compressed-images/{{ $product->image }}" alt="{{ $product->name }}" width="200" height="200">
            </noscript>
            <figcaption>Test message</figcaption></figure>

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
</div>
<div class="product-details position-relative" style="background-color:#fff!important;">
    <div class="product-content-box p-1">

        <h6 class="product__title" style="padding:0px;height:45px; overflow:hidden;">
            <small><p 
            style="margin-bottom:0px; font-size:13px;">
        {!! BaseHelper::clean($product->name) !!}
        </p></small>
        </h6>

        
        <div class="row" style=' --bs-gutter-x:0rem;'>

<div class="col-1"></div>
<div class="col-11">  

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
</div></div></div></a></div>

@endforeach

<?php print_r($links);?>


                           </div>
                     </div> 
         
                 
                    
                    
                    