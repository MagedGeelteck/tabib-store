@php


 if(!empty($_GET['catid'])){
 Session::put('catid', $_GET['catid']);
 $category_id=Session::get('catid');
 }else{
 $category_id=Session::get('catid');
 }
 
  if(empty($_GET['subcatid']) && empty($_GET['catid'])){
    Session::put('catid',null);
    $category_id=Session::get('catid');

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
                    'slidesToShow'   => 4,
                    'slidesToScroll' => 4,
                ],
            ],
        ],
    ];


@endphp
@if (count($sliders) > 0)
    @php
        $sliders->loadMissing('metadata');
        $slick = [
            'autoplay'       => ($shortcode->is_autoplay ?: 'yes') == 'yes',
            'infinite'       => ($shortcode->is_autoplay ?: 'yes') == 'yes',
            'autoplaySpeed'  => in_array($shortcode->autoplay_speed, theme_get_autoplay_speed_options()) ? $shortcode->autoplay_speed : 5000,
            'speed'          => 1000,
            'slidesToShow'   => 1,
            'slidesToScroll' => 1,
            'appendArrows'   => '.arrows-wrapper',
            'fade'           => true,
        ];
        
            $categories = get_featured_product_categories();

       $categories = get_featured_product_categories();
@endphp
@if ($categories->count())


    <div  class="widget-product-categories">
        <div class="container-xxxl">
            <div class="row">
                <div class="col-12">
                    <div class="row align-items-center mb-0 widget-header">
                        <h2 class="col-auto mb-1 py-0">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                    </div>
                    <div class="product-categories-body pb-1 arrows-top-right">
                        <div data-slick="{{ json_encode($slick1) }}" class="product-categories-box slick-slides-carousel">

                            @foreach ($categories as $item)
                                <small><div class="product-category-item p-1">
                                    <div class="category-item-body p-0 @if(!empty(Session::get('catid')) && Session::get('catid')==$item->id) active-category @endif">
                                        <a class="d-block py-0" href="/?catid={{ $item->id }}">

                                            <div class="category__text text-center py-1">
                                                <h6 class="category__name @if(!empty(Session::get('catid')) && Session::get('catid')==$item->id) active-category @endif"><small>{{ $item->name }}</small></h6>
                                            </div>
                                        </a>
                                    </div>
                                </div></small>
                            @endforeach
                        </div>
                        <div class="arrows-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
@endif
    
    
    
    
    
    <div class="section-content section-content__slider lazyload" style="padding:0px 10px 0px 10px;!important;"
        @if ($shortcode->background) data-bg="{{ RvMedia::getImageUrl($shortcode->background) }}" @endif>
            <div class="row gx-0 gx-md-4">
                <div class="col-md-12">
                    <div class="section-slides-wrapper">
                        <div class="slide-body slick-slides-carousel" data-slick="{{ json_encode($slick) }}">
                            @foreach($sliders as $slider)
                                <div class="slide-item">
                                    <div class="slide-item__image">
                                        @if ($slider->link) <a href="{{ url($slider->link) }}"> @endif
                                            @php
                                                $tabletImage = $slider->getMetaData('tablet_image', true) ?: $slider->image;
                                                $mobileImage = $slider->getMetaData('mobile_image', true) ?: $tabletImage;
                                            @endphp
                                            <picture>
                                                <source srcset="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}" media="(min-width: 1200px)" />
                                                <source srcset="{{ RvMedia::getImageUrl($tabletImage, null, false, RvMedia::getDefaultImage()) }}" media="(min-width: 768px)" />
                                                <source srcset="{{ RvMedia::getImageUrl($mobileImage, null, false, RvMedia::getDefaultImage()) }}" media="(max-width: 767px)" />
                                                <img src="{{ image_placeholder($slider->image) }}" alt="{{ $slider->title }}" />
                                            </picture>
                                        @if ($slider->link) </a> @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="arrows-wrapper"></div>
                    </div>
                </div>
            </div>
    </div>
@endif

