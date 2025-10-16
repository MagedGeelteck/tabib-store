@php

if(BaseHelper::siteLanguageDirection() == 'rtl'){
$langcode='ar';
}else{
$langcode='en';
}

$category_id=request()->segment(count(request()->segments()));

@endphp



            
    
    <div class="section-content lazyload bg-light">
            <div class="row gx-0 gx-md-4">
                <div class="col-md-12">
                    <div class="section-slides-wrapper">
                        <div class="slide-body slick-slides-carousel active">
                                <div class="slide-item">
                                    <div class="slide-item__image">
                                    @php
                                     $slider=DB::table('simple_slider_items')->orderBy('id','DESC')->first();
                                     @endphp
                                            <picture>
                                                <source srcset="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}" media="(min-width: 1200px)" />
                                                <source srcset="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}" media="(min-width: 768px)" />
                                                <source srcset="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}" media="(max-height: 767px)" />
                                                <img loading="eager" decoding="async" width="1200" height="500" src="{{ RvMedia::getImageUrl($slider->image, 1200, false, RvMedia::getDefaultImage()) }}" alt="slider" style="border-radius:10px; max-width: 100%;min-width: 300px;height: auto;">
                                                <noscript>
                                                    <img src="{{ RvMedia::getImageUrl($slider->image, 1200, false, RvMedia::getDefaultImage()) }}" alt="slider" style="border-radius:10px; max-width: 100%;min-width: 300px;height: auto;">
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
background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                @foreach ($all_categories as $category)
                                
                                     @php 
                                     if(BaseHelper::siteLanguageDirection() != 'rtl'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$category->id)->first();
                                     $category->name=$subcat_translation->name;
                                     }
                                     @endphp
                                
                                
                                @if($category->id==$category_id || $parent== $category->id)
                                
                                        <a href="{{ route('products.category',$category->id) }}">
                                <span class="font-weight-bold text-dark categories-slider active-category" style="background-color:#7CAA53!important;">{{ $category->name }}</button>
                                </a>
                                    @endif
                                    
                                @endforeach
                                @foreach ($all_categories as $category)
                                @if($category->id!=$category_id && $parent!= $category->id)
                                
                                        <a href="{{ route('products.category',$category->id) }}">
                                <span class="font-weight-bold text-dark categories-slider">{{ $category->name }}</button>
                                </a>
                                    @endif
                                @endforeach

</div>

@if($subcats)
<div class="scroll" style="
background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                @foreach ($subcats as $category)
                                
                                     @php 
                                     if(BaseHelper::siteLanguageDirection() != 'rtl'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$category->id)->first();
                                     $category->name=$subcat_translation->name;
                                     }
                                     @endphp                                
                                
                                @if($category->id==$category_id || $parent== $category->id ||$parent_sub== $category->id)
                                
                                        <a href="{{ route('products.category',$category->id) }}">
                                <span class="font-weight-bold text-dark categories-slider active-category" style="background-color:#7CAA53!important;">{{ $category->name }}</button>
                                </a>
                                    @endif
                                    
                                @endforeach
                                @foreach ($subcats as $category)
                                @if($category->id!=$category_id && $parent!= $category->id&& $parent_sub!= $category->id)
                                
                                        <a href="{{ route('products.category',$category->id) }}">
                                <span class="font-weight-bold text-dark categories-slider">{{ $category->name }}</button>
                                </a>
                                    @endif
                                @endforeach

</div>
@endif
@if($third_subcats)
<div class="scroll" style="
background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                @foreach ($third_subcats as $category)
                                
                                     @php 
                                     if(BaseHelper::siteLanguageDirection() != 'rtl'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$category->id)->first();
                                     $category->name=$subcat_translation->name;
                                     }
                                     @endphp                                 
                                @if($category->id==$category_id)
                                
                                        <a href="{{ route('products.category',$category->id) }}">
                                <span class="font-weight-bold text-dark categories-slider active-category" style="background-color:#7CAA53!important;">{{ $category->name }}</button>
                                </a>
                                    @endif
                                    
                                @endforeach
                                @foreach ($third_subcats as $category)
                                @if($category->id!=$category_id)
                                
                                        <a href="{{ route('products.category',$category->id) }}">
                                <span class="font-weight-bold text-dark categories-slider">{{ $category->name }}</button>
                                </a>
                                    @endif
                                @endforeach

</div>
@endif




<div class="scrolling-pagination bg-light">            
 <div class="row">
 @php $start=0;@endphp     
@foreach($products as $product)
 @php $start++; 

 if($start=1)

 @endphp

<div class="col-lg-2 col-md-2 col-6 p-2">  
<a class="img-fluid-eq" href="/{{$langcode}}{{ $product->url }}">

<div class="product-thumbnail" style="background-color:#fff!important; max-height:300px;">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap hover-effect">
            <figure class="text-center">
            <img class="lazyload product-thumbnail__img"
                loading="lazy"
                decoding="async"
                width="200"
                height="200"
                src="{{ RvMedia::getImageUrl($product->image, 300, false, RvMedia::getDefaultImage()) }}"
                data-src="{{ RvMedia::getImageUrl($product->image, 600, false, RvMedia::getDefaultImage()) }}"
                data-srcset="{{ RvMedia::getImageUrl($product->image, 300, false, RvMedia::getDefaultImage()) }} 300w, {{ RvMedia::getImageUrl($product->image, 600, false, RvMedia::getDefaultImage()) }} 600w, {{ RvMedia::getImageUrl($product->image, 900, false, RvMedia::getDefaultImage()) }} 900w"
                srcset="{{ RvMedia::getImageUrl($product->image, 300, false, RvMedia::getDefaultImage()) }} 300w"
                sizes="(max-width: 600px) 100vw, 200px"
            alt="{{ $product->name }}" style="max-height:299px;"> 
            <noscript>
                <img src="{{ RvMedia::getImageUrl($product->image, 600, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" width="200" height="200">
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
</div></div></div></a></div>

@endforeach

<?php print_r($links);?>


                           </div>
                     </div> 

                 
                    
                    
                    