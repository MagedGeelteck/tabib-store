
 <div class="widget-products-with-category py-5 bg-light">
    <div class="container-xxxl">
        <div class="row">
            <div class="col-12">
                <div hidden class="row align-items-center mb-2 widget-header">
                    <h2 class="col-auto mb-0 py-2">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                </div>
                
 @php
 
 if(!empty($_GET['catid'])){
 Session::put('catid', $_GET['catid']);
 $category_id=Session::get('catid');
 }else{
 $category_id=Session::get('catid');
 }
 
 
 if(!empty($_GET['subcatid'])){
 Session::put('subcatid', $_GET['subcatid']);
 $sub_category_id=Session::get('subcatid');
 }else{
 $sub_category_id=Session::get('subcatid');
 }
 
 
 
    $slick1 = [
        'rtl'            => BaseHelper::siteLanguageDirection() == 'rtl',
        'appendArrows'   => '.arrows-wrapper',
        'arrows'         => true,
        'dots'           => false,
        'autoplay'       => $shortcode->is_autoplay == 'yes',
        'infinite'       => $shortcode->infinite == 'yes' || $shortcode->is_infinite == 'yes',
        'autoplaySpeed'  => in_array($shortcode->autoplay_speed, theme_get_autoplay_speed_options()) ? $shortcode->autoplay_speed : 3000,
        'speed'          => 800,
        'slidesToShow'   => 8,
        'slidesToScroll' => 1,
        'responsive'     => [
            [
                'breakpoint' => 1700,
                'settings'   => [
                    'slidesToShow' => 10,
                ],
            ],
            [
                'breakpoint' => 1500,
                'settings'   => [
                    'slidesToShow' => 10,
                ],
            ],
            [
                'breakpoint' => 1199,
                'settings'   => [
                    'slidesToShow' => 10,
                ],
            ],
            [
                'breakpoint' => 1024,
                'settings'   => [
                    'slidesToShow' => 5,
                ],
            ],
            [
                'breakpoint' => 767,
                'settings'   => [
                    'arrows'         => false,
                    'dots'           => false,
                    'slidesToShow'   =>4,
                    'slidesToScroll' => 4,
                ],
            ],
        ],
    ];


@endphp               
                
@php

use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;

     function getWishlistIds(array $productIds = []): array
    {
        if (! EcommerceHelper::isWishlistEnabled()) {
            return [];
        }

        if (auth('customer')->check()) {
            return auth('customer')->user()->wishlist()->whereIn('product_id', $productIds)->pluck('product_id')->all();
        }

        return collect(Cart::instance('wishlist')->content())
            ->sortBy([['updated_at', 'desc']])
            ->whereIn('id', $productIds)
            ->pluck('id')
            ->all();
    }
    
   
    $params =[
            'condition' => [
                'ec_products.status' =>'published',
                function ($query) {
                    return $query->notOutOfStock();
                },
            ],
            'order_by' => [
                'ec_products.name' => 'ASC',
            ],
            'paginate' => [
                'per_page' => 16,
                'current_paged' =>1,
            ],
            'with' => ['slugable'],
            'withCount' => [],
            'withAvg' => [],
        ];
        
        $all_products=[];
        $subcats="";
        
        $products= app(ProductInterface::class)->getProducts($params);      
        $wishlistIds =getWishlistIds($products->pluck('id')->all());

        if(!empty($category_id) && empty($_GET['subcatid']) ){
        foreach($products as $product){
        $product_categories=DB::table('ec_product_category_product')->where('product_id',$product->id)->get();
        foreach($product_categories as $product_category){
        if($product_category->category_id==$category_id){
        array_push($all_products,$product);
        }}}
        $products=$all_products;
        $subcats=DB::table('ec_product_categories')->where('parent_id',$category_id)->get();
        }
        

         if(!empty($sub_category_id)){
        foreach($products as $product){
        $product_categories=DB::table('ec_product_category_product')->where('product_id',$product->id)->get();
        foreach($product_categories as $product_category){
        if($product_category->category_id==$sub_category_id){
        if(!in_array($product,$all_products))
        array_push($all_products,$product);
        }}}
        $products=$all_products;
        $subcats=DB::table('ec_product_categories')->where('parent_id',$category_id)->get();

        }
        $categories=false;
        if(empty($_GET['subcatid']) && empty($_GET['catid'])){
        $products= app(ProductInterface::class)->getProducts($params);
        $categories = get_featured_product_categories();
        }

@endphp

@if($categories)

       <div  class="widget-product-categories">
        <div class="container-xxxl">
            <div class="row">
                <div class="col-12">
                    
                    <div class="product-categories-body pb-1 arrows-top-right">
                        <div data-slick="{{ json_encode($slick1) }}" class="product-categories-box slick-slides-carousel">

                                   @foreach($categories as $subcat)
                                     @php 
                                     if(app()->getlocale()=='en'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$subcat->id)->first();
                                     $subcat->name=$subcat_translation->name;
                                     }
                                     @endphp
          
                                  <div class="product-category-item p-1">
                                    <div class="category-item-body p-0 @if(!empty($_GET['subcatid']) && $_GET['subcatid']==$subcat->id) active-subcategory @endif" style="background-color:#fff;">
                                        <a class="d-block py-0" href="/?catid={{ $subcat->id }}">
                                          <div class="category__thumb img-fluid-eq mb-0">
                                                <div class="img-fluid-eq__dummy"></div>
                                                <div class="img-fluid-eq__wrap">
                                                    <img
                                                        class="lazyload mx-auto w-100"
                                                        data-src="{{ RvMedia::getImageUrl($subcat->image, 'small', false, RvMedia::getDefaultImage()) }}"
                                                        alt="{{ $subcat->name }}" />
                                                </div>
                                            </div>

                                        </a>
                                    </div>
                                </div>
                                
                               @endforeach 
                                
                        </div>
                        <div class="arrows-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if($subcats)
    <div class="widget-product-categories">
        <div class="container-xxxl">
            <div class="row">
                <div class="col-12">
                    
                    <div class="product-categories-body pb-1 arrows-top-right">
                        <div data-slick="{{ json_encode($slick1) }}" class="product-categories-box slick-slides-carousel">

                                   @foreach($subcats as $subcat)
                                     @php 
                                     if(app()->getlocale()=='en'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$subcat->id)->first();
                                     $subcat->name=$subcat_translation->name;
                                     }
                                     @endphp
          
                                  <div class="product-category-item p-1">
                                    <div class="category-item-body p-0 @if(!empty($_GET['subcatid']) && $_GET['subcatid']==$subcat->id) active-subcategory @endif" style="background-color:#fff;">
                                        <a class="d-block py-0" href="/?subcatid={{ $subcat->id }}">
                                          <div class="category__thumb img-fluid-eq mb-3">
                                                <div class="img-fluid-eq__dummy"></div>
                                                <div class="img-fluid-eq__wrap">
                                                    <img
                                                        class="lazyload mx-auto"
                                                        data-src="{{ RvMedia::getImageUrl($subcat->image, 'small', false, RvMedia::getDefaultImage()) }}"
                                                        alt="{{ $subcat->name }}" />
                                                </div>
                                            </div>
                                            <div hidden class="category__text text-center py-1">
                                                <h6 class="category__name @if(!empty($_GET['subcatid']) && $_GET['subcatid']==$subcat->id) active-subcategory @endif"><small>{{ $subcat->name }}</small></h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                               @endforeach 
                                
                        </div>
                        <div class="arrows-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif   


            
 <div class="row">
  {{Config::get('view.paths');}}
   
@foreach($products as $product)
@foreach($product->images as $key => $product_image)
@if($key==0)
@php $primary_image=$product_image;@endphp
@endif
@endforeach
<div class="col-lg-3 col-md-3 col-6 p-2">  


<div class="product-thumbnail" style="background-color:#fff!important; max-height:300px;">
    <a class="product-loop__link img-fluid-eq" href="{{ $product->url }}" tabindex="0">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap">
            <figure class="text-center">
            <img class="lazyload product-thumbnail__img"
                src="{{ image_placeholder($primary_image) }}"
                data-src="{{ RvMedia::getImageUrl($primary_image)}}"
            alt="{{ $product->name }}" style="max-height:299px;"> <figcaption>Test message</figcaption></figure>

        </div>
 <span class="ribbons">
            @if ($product->isOutOfStock())
                <span class="ribbon out-stock bg-warning">{{ __('Out Of Stock') }}</span>
            @else
                @if ($product->productLabels->count())
                    @foreach ($product->productLabels as $label)
                        <span class="ribbon" @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                    @endforeach
                @else
                    @if ($product->front_sale_price !== $product->price)
                        <div class="featured ribbon" dir="ltr">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</div>
                    @endif
                @endif
            @endif
        </span>
    </a>
    <!--<span>{!! Theme::partial('ecommerce.product-loop-buttons', compact('product') + (!empty($wishlistIds) ? compact('wishlistIds') : [])) !!}</span>-->
</div>
<div class="product-details position-relative" style="background-color:#fff!important;">
    <div class="product-content-box p-3">
        @if (is_plugin_active('marketplace') && $product->store->id)
            <div class="sold-by-meta">
                <a href="{{ $product->store->url }}" tabindex="0">{{ $product->store->name }}</a>
            </div>
        @endif
        <h6 class="product__title" style="min-height:45px;">
            <a href="{{ $product->url }}" tabindex="0"><small>{!! BaseHelper::clean($product->name) !!}</small></a>
        </h6>
        
        
        
        <div class="row">

<div class="col-lg-3 col-md-3  col-12 pt-2">  


<span class="product-price">
    <span class="product-price-sale d-flex align-items-center @if ($product->front_sale_price === $product->price) d-none @endif">
        <del aria-hidden="true">
            <span class="price-amount">
                <bdi>
                    <span class="amount">{{ format_price($product->price_with_taxes) }}</span>
                </bdi>
            </span>
        </del>
        <ins>
            <span class="price-amount">
                <bdi>
                    <span class="amount">{{ format_price($product->front_sale_price_with_taxes) }}</span>
                </bdi>
            </span>
        </ins>
    </span>
    <span class="product-price-original @if ($product->front_sale_price !== $product->price) d-none @endif">
        <span class="price-amount">
            <bdi>
                <span class="amount">{{ format_price($product->front_sale_price_with_taxes) }}</span>
            </bdi>
        </span>
    </span>
</span>

</div>
<div class="col-lg-9 col-md-9 col-12" align="right">  

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

    {!! render_product_options($product) !!}

    <input type="hidden"
        name="id" class="hidden-product-id"
        value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}"/>

    @if (EcommerceHelper::isCartEnabled() || !empty($withButtons))
        {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product) !!}
        <div class="product-button">
            @if (EcommerceHelper::isCartEnabled())
                {!! Theme::partial('ecommerce.product-quantity', compact('product')) !!}
                <button type="submit" name="add_to_cart" value="1" style="padding:10px; background-color:transparent; font-size:23px;" class="btn btn-primary  add-to-cart-button @if ($product->isOutOfStock()) disabled @endif" @if ($product->isOutOfStock()) disabled @endif title="{{ __('Add to cart') }}">
                        <i class="icon-cart"></i>
                </button>

            @endif
            
        </div>
    @endif
</form>


</div></div>



    </div>

</div>




</div>
@endforeach

                    </div> 
               </div>
         </div>
    </div>
</div>
        
                 
                    
                    
                    