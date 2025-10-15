@php

if(BaseHelper::siteLanguageDirection() != 'rtl'){
$dir='left';
}else{
$dir='right';
}
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('primary_font', 'Muli')) . ':wght@400;600;700&display=swap') !!}

        <style>
            :root {
                --primary-font: '{{ theme_option('primary_font', 'Muli') }}', sans-serif;
                --primary-color: {{ theme_option('primary_color', '#fab528') }};
                --heading-color: {{ theme_option('heading_color', '#000') }};
                --text-color: {{ theme_option('text_color', '#000') }};
                --primary-button-color: {{ theme_option('primary_button_color', '#000') }};
                --top-header-background-color: {{ theme_option('top_header_background_color', '#f7f7f7') }};
                --middle-header-background-color: {{ theme_option('middle_header_background_color', '#fff') }};
                --bottom-header-background-color: {{ theme_option('bottom_header_background_color', '#fff') }};
                --header-text-color: {{ theme_option('header_text_color', '#000') }};
                --header-text-secondary-color: {{ BaseHelper::hexToRgba(theme_option('header_text_color', '#000'), 0.5) }};
                --header-deliver-color: {{ BaseHelper::hexToRgba(theme_option('header_deliver_color', '#000'), 0.15) }};
                --footer-text-color: {{ theme_option('footer_text_color', '#555') }};
                --footer-heading-color: {{ theme_option('footer_heading_color', '#555') }};
                --footer-hover-color: {{ theme_option('footer_hover_color', '#fab528') }};
                --footer-border-color: {{ theme_option('footer_border_color', '#dee2e6') }};
            }
        </style>

        @php
            Theme::asset()->remove('language-css');
            Theme::asset()->container('footer')->remove('language-public-js');
            Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-css');
            Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-js');
            Theme::asset()->container('footer')->remove('simple-slider-css');
            Theme::asset()->container('footer')->remove('simple-slider-js');
        @endphp

        {!! Theme::header() !!}
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>  
        
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-G8PCZSFSD7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-G8PCZSFSD7');
</script>



<script>

 $(".container-xl").addClass("container-fluid");
 </script>
  
<style>
.photo-galery-with-zoom {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  justify-content: equally-spaced;
}



.photo-galery-with-zoom img {
  height: 19vh;
  width: 19vh;
  object-fit: contain;
}

.photo-galery-with-zoom img {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  width: 100vw;
  height: 100vh;
  background: white;
  object-fit: contain;
}

::-webkit-scrollbar {
  width: 0.7em;
}
 
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 12px rgba(0, 0, 0, 0.3)
}
 
::-webkit-scrollbar-thumb {
  background-color: rgb(124, 170, 83);
  color:#000 !important;
} 

::-webkit-scrollbar:horizontal {
    height: 4px;
}

.scroll{
z-index:1000;
position:relative;
}
.categories-slider{
    
font-size:16px; display: inline-block; padding: 10px 15px 10px 15px; max-width:auto;  background-color:#f8f8f8 !important;  border:0.5px solid black; border-radius:5px !important; max-width:auto; 

}

@media only screen and (min-width: 720px) {
 .categories-slider{
font-size:18px; margin:10px;display: inline-block; padding: 10px 25px 10px 25px; background-color:#f8f8f8 !important; border:0.5px solid black; border-radius:10px !important; max-width:auto;    
}}
	.whatsapp-float {
		position: absolute;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 2pt 8pt rgba(0, 0, 0, 0.2);
		text-decoration: none !important;
		border-radius: 50%;
		overflow: hidden;
		background: #25D366;
		position: fixed;
		z-index: 11;
		right: 20px;
		bottom: 80px;
		width: 60px;
		height: 60px;
	}

	.whatsapp-float i {
		color: #fff;
		font-size: 28pt;
	}

	@media (max-width: 576px) {
		.whatsapp-float {
			right: 15px;
		}
	}
</style>
<a class="whatsapp-float" href="https://wa.me/+962790688071" target="_blank">
	<i class="fa fa-whatsapp" aria-hidden="true"></i>

</a>
  
<meta name="facebook-domain-verification" content="rf1sn9cu9aztqowrio91nihcc6o6yz" />
               
    </head>
    <body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif @if (Theme::get('bodyClass')) class="{{ Theme::get('bodyClass') }}" @endif>
        @if (theme_option('preloader_enabled', 'yes') == 'yes')
            {!! Theme::partial('preloader') !!}
        @endif

        {!! Theme::partial('svg-icons') !!}
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <header class="header header-js-handler" data-sticky="{{ theme_option('sticky_header_enabled', 'yes') == 'yes' ? 'true' : 'false' }}">
            <div class="header-top d-none d-lg-block">
                <div class="container-xxxl">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="header-info">
                                {!! Menu::renderMenuLocation('header-navigation', ['view' => 'menu-default']) !!}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="header-info header-info-right">
                                <ul>
                                    @if (is_plugin_active('language'))
                                        {!! Theme::partial('language-switcher') !!}
                                    @endif
                                    @if (is_plugin_active('ecommerce'))
                                        @if (count($currencies) > 1)
                                            <li>
                                                <a class="language-dropdown-active" href="#">
                                                    <span>{{ get_application_currency()->title }}</span>
                                                    <span class="svg-icon">
                                                        <svg>
                                                            <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <ul class="language-dropdown">
                                                    @foreach ($currencies as $currency)
                                                        @if ($currency->id !== get_application_currency_id())
                                                            <li>
                                                                <a href="{{ route('public.change-currency', $currency->title) }}">
                                                                    <span>{{ $currency->title }}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                        @if (auth('customer')->check())
                                            <li>
                                                <a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a> <span class="d-inline-block ms-1">(<a href="{{ route('customer.logout') }}" class="color-primary">{{ __('Logout') }}</a>)</span>
                                            </li>
                                        @else
                                            <li><a href="{{ route('customer.login') }}">{{ __('Login') }}</a></li>
                                            <li><a href="{{ route('customer.register') }}">{{ __('Register') }}</a></li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle">
                <div class="container-xxxl">
                    <div class="header-wrapper">
                        <div class="header-items header__left" style="max-width:140px!important;">
                            @if (theme_option('logo'))
                                <div class="logo">
                                    <a href="{{ route('public.index') }}">
                                        <img  style="width:140px !important;" src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" />
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="header-items header__center">
                            @if (is_plugin_active('ecommerce'))
                                <form class="form--quick-search" action="{{ route('public.products') }}" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                                    <div class="form-group--icon" style="display: none">
                                        <div class="product-category-label">
                                            <span class="text">{{ __('All Categories') }}</span>
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                </svg>
                                            </span>
                                        </div>
                                        <select class="form-control product-category-select" name="categories[]">
                                            <option value="0">{{ __('All Categories') }}</option>
                                            {!! Theme::partial('product-categories-select', ['categories' => $categories, 'indent' => null]) !!}
                                        </select>
                                    </div>
                                    <input class="form-control input-search-product" name="q" type="text"
                                        placeholder="{{ __("Im shopping for...") }}" autocomplete="off">
                                    <button class="btn" type="submit">
                                        <span class="svg-icon">
                                            <svg>
                                                <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="panel--search-result"></div>
                                </form>
                            @endif
                        </div>
                        <div class="header-items header__right">
                            @if (theme_option('hotline'))
                                <div class="header__extra header-support">
                                    <div class="header-box-content">
                                        <span>{{ theme_option('hotline') }}</span>
                                        <p>{{ __('Support 24/7') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (is_plugin_active('ecommerce'))
                                @if (EcommerceHelper::isCompareEnabled())
                                    <div class="header__extra header-compare">
                                        <a class="btn-compare" href="{{ route('public.compare') }}">
                                            <i class="icon-repeat"></i>
                                            <span class="header-item-counter">{{ Cart::instance('compare')->count() }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if (EcommerceHelper::isWishlistEnabled())
                                    <div class="header__extra header-wishlist">
                                        <a class="btn-wishlist" href="{{ route('public.wishlist') }}">
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-wishlist" xlink:href="#svg-icon-wishlist"></use>
                                                </svg>
                                            </span>
                                            <span class="header-item-counter">
                                                {{ auth('customer')->check() ? auth('customer')->user()->wishlist()->count() : Cart::instance('wishlist')->count() }}
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (EcommerceHelper::isCartEnabled())
                                    <div class="header__extra cart--mini" tabindex="0" role="button">
                                        <div class="header__extra">
                                            <a class="btn-shopping-cart" href="{{ route('public.cart') }}">
                                                <span class="svg-icon">
                                                    <svg>
                                                        <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                                    </svg>
                                                </span>
                                                <span class="header-item-counter">{{ Cart::instance('cart')->count() }}</span>
                                            </a>
                                            <span class="cart-text">
                                                <span class="cart-title">{{ __('Your Cart') }}</span>
                                                <span class="cart-price-total">
                                                    <span class="cart-amount">
                                                        <bdi>
                                                            <span>{{ format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()) }}</span>
                                                        </bdi>
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="cart__content" id="cart-mobile">
                                            <div class="backdrop"></div>
                                            <div class="mini-cart-content">
                                                <div class="widget-shopping-cart-content">
                                                    {!! Theme::partial('cart-mini.list') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div hidden class="header-bottom">
                <div class="header-wrapper">
                    <nav class="navigation">
                        <div class="container-xxxl">
                            <div class="navigation__left">
                                @if (is_plugin_active('ecommerce'))
                                    <div class="menu--product-categories">
                                        <div class="menu__toggle">
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-list" xlink:href="#svg-icon-list"></use>
                                                </svg>
                                            </span>
                                            <span class="menu__toggle-title">{{ __('Shop by Category') }}</span>
                                        </div>
                                        <div class="menu__content">
                                            <ul class="menu--dropdown">
                                                {!! Theme::partial('product-categories-dropdown', compact('categories')) !!}
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="navigation__center">
                                {!! Menu::renderMenuLocation('main-menu', [
                                    'view'    => 'menu',
                                    'options' => ['class' => 'menu'],
                                ]) !!}
                            </div>
                            <div class="navigation__right">
                                @if (is_plugin_active('ecommerce') && EcommerceHelper::isEnabledCustomerRecentlyViewedProducts())
                                    <div class="header-recently-viewed" data-url="{{ route('public.ajax.recently-viewed-products') }}" role="button">
                                        <h3 class="recently-title">
                                            <span class="svg-icon recent-icon">
                                                <svg>
                                                    <use href="#svg-icon-refresh" xlink:href="#svg-icon-refresh"></use>
                                                </svg>
                                            </span>
                                            {{ __('Recently Viewed') }}
                                        </h3>
                                        <div class="recently-viewed-inner container-xxxl">
                                            <div class="recently-viewed-content">
                                                <div class="loading--wrapper">
                                                    <div class="loading"></div>
                                                </div>
                                                <div class="recently-viewed-products"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="header-mobile header-js-handler" data-sticky="{{ theme_option('sticky_header_mobile_enabled', 'yes') == 'yes' ? 'true' : 'false' }}"  style="max-height:100px!important; padding:5px!important;">
                <div class="header-items-mobile header-items-mobile--left">
                    <div class="menu-mobile">
                        <div class="menu-box-title">
                            <div class="icon menu-icon toggle--sidebar" href="#menu-mobile">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-list" xlink:href="#svg-icon-list"></use>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-items-mobile header-items-mobile--center">
                    @if (theme_option('logo'))
                        <div class="logo">
                            <a href="{{ route('public.index') }}">
                                <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" width="60"  style="margin-{{$dir}}:40px;">
                            </a>
                        </div>
                    @endif
                </div>
                <div class="header-items-mobile header-items-mobile--right">
                    <div class="search-form--mobile search-form--mobile-right search-panel">
                        <a class="open-search-panel toggle--sidebar" href="#search-mobile">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
