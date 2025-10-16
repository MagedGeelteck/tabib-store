<?php

if(BaseHelper::siteLanguageDirection() != 'rtl'){
$dir='left';
}else{
$dir='right';
}
?>

<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <?php echo BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('primary_font', 'Muli')) . ':wght@400;600;700&display=swap'); ?>


        <style>
            :root {
                --primary-font: '<?php echo e(theme_option('primary_font', 'Muli')); ?>', sans-serif;
                --primary-color: <?php echo e(theme_option('primary_color', '#fab528')); ?>;
                --heading-color: <?php echo e(theme_option('heading_color', '#000')); ?>;
                --text-color: <?php echo e(theme_option('text_color', '#000')); ?>;
                --primary-button-color: <?php echo e(theme_option('primary_button_color', '#000')); ?>;
                --top-header-background-color: <?php echo e(theme_option('top_header_background_color', '#f7f7f7')); ?>;
                --middle-header-background-color: <?php echo e(theme_option('middle_header_background_color', '#fff')); ?>;
                --bottom-header-background-color: <?php echo e(theme_option('bottom_header_background_color', '#fff')); ?>;
                --header-text-color: <?php echo e(theme_option('header_text_color', '#000')); ?>;
                --header-text-secondary-color: <?php echo e(BaseHelper::hexToRgba(theme_option('header_text_color', '#000'), 0.5)); ?>;
                --header-deliver-color: <?php echo e(BaseHelper::hexToRgba(theme_option('header_deliver_color', '#000'), 0.15)); ?>;
                --footer-text-color: <?php echo e(theme_option('footer_text_color', '#555')); ?>;
                --footer-heading-color: <?php echo e(theme_option('footer_heading_color', '#555')); ?>;
                --footer-hover-color: <?php echo e(theme_option('footer_hover_color', '#fab528')); ?>;
                --footer-border-color: <?php echo e(theme_option('footer_border_color', '#dee2e6')); ?>;
            }
        </style>

        <?php
            Theme::asset()->remove('language-css');
            Theme::asset()->container('footer')->remove('language-public-js');
            Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-css');
            Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-js');
            Theme::asset()->container('footer')->remove('simple-slider-css');
            Theme::asset()->container('footer')->remove('simple-slider-js');
        ?>

        <?php echo Theme::header(); ?>

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
    <body <?php if(BaseHelper::siteLanguageDirection() == 'rtl'): ?> dir="rtl" <?php endif; ?> <?php if(Theme::get('bodyClass')): ?> class="<?php echo e(Theme::get('bodyClass')); ?>" <?php endif; ?>>
        <?php if(theme_option('preloader_enabled', 'yes') == 'yes'): ?>
            <?php echo Theme::partial('preloader'); ?>

        <?php endif; ?>

        <?php echo Theme::partial('svg-icons'); ?>

        <?php echo apply_filters(THEME_FRONT_BODY, null); ?>


        <header class="header header-js-handler" data-sticky="<?php echo e(theme_option('sticky_header_enabled', 'yes') == 'yes' ? 'true' : 'false'); ?>">
            <div class="header-top d-none d-lg-block">
                <div class="container-xxxl">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="header-info">
                                <?php echo Menu::renderMenuLocation('header-navigation', ['view' => 'menu-default']); ?>

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="header-info header-info-right">
                                <ul>
                                    <?php if(is_plugin_active('language')): ?>
                                        <?php echo Theme::partial('language-switcher'); ?>

                                    <?php endif; ?>
                                    <?php if(is_plugin_active('ecommerce')): ?>
                                        <?php if(count($currencies) > 1): ?>
                                            <li>
                                                <a class="language-dropdown-active" href="#">
                                                    <span><?php echo e(get_application_currency()->title); ?></span>
                                                    <span class="svg-icon">
                                                        <svg>
                                                            <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <ul class="language-dropdown">
                                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($currency->id !== get_application_currency_id()): ?>
                                                            <li>
                                                                <a href="<?php echo e(route('public.change-currency', $currency->title)); ?>">
                                                                    <span><?php echo e($currency->title); ?></span>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(auth('customer')->check()): ?>
                                            <li>
                                                <a href="<?php echo e(route('customer.overview')); ?>"><?php echo e(auth('customer')->user()->name); ?></a> <span class="d-inline-block ms-1">(<a href="<?php echo e(route('customer.logout')); ?>" class="color-primary"><?php echo e(__('Logout')); ?></a>)</span>
                                            </li>
                                        <?php else: ?>
                                            <li><a href="<?php echo e(route('customer.login')); ?>"><?php echo e(__('Login')); ?></a></li>
                                            <li><a href="<?php echo e(route('customer.register')); ?>"><?php echo e(__('Register')); ?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
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
                            <?php if(theme_option('logo')): ?>
                                <div class="logo">
                                    <a href="<?php echo e(route('public.index')); ?>">
                                        <img  style="width:140px !important;" src="<?php echo e(RvMedia::getImageUrl(theme_option('logo'))); ?>" alt="<?php echo e(theme_option('site_title')); ?>" />
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="header-items header__center">
                            <?php if(is_plugin_active('ecommerce')): ?>
                                <form class="form--quick-search" action="<?php echo e(route('public.products')); ?>" data-ajax-url="<?php echo e(route('public.ajax.search-products')); ?>" method="get">
                                    <div class="form-group--icon" style="display: none">
                                        <div class="product-category-label">
                                            <span class="text"><?php echo e(__('All Categories')); ?></span>
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                </svg>
                                            </span>
                                        </div>
                                        <select class="form-control product-category-select" name="categories[]">
                                            <option value="0"><?php echo e(__('All Categories')); ?></option>
                                            <?php echo Theme::partial('product-categories-select', ['categories' => $categories, 'indent' => null]); ?>

                                        </select>
                                    </div>
                                    <input class="form-control input-search-product" name="q" type="text"
                                        placeholder="<?php echo e(__("Im shopping for...")); ?>" autocomplete="off">
                                    <button class="btn" type="submit">
                                        <span class="svg-icon">
                                            <svg>
                                                <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="panel--search-result"></div>
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="header-items header__right">
                            <?php if(theme_option('hotline')): ?>
                                <div class="header__extra header-support">
                                    <div class="header-box-content">
                                        <span><?php echo e(theme_option('hotline')); ?></span>
                                        <p><?php echo e(__('Support 24/7')); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if(is_plugin_active('ecommerce')): ?>
                                <?php if(EcommerceHelper::isCompareEnabled()): ?>
                                    <div class="header__extra header-compare">
                                        <a class="btn-compare" href="<?php echo e(route('public.compare')); ?>">
                                            <i class="icon-repeat"></i>
                                            <span class="header-item-counter"><?php echo e(Cart::instance('compare')->count()); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if(EcommerceHelper::isWishlistEnabled()): ?>
                                    <div class="header__extra header-wishlist">
                                        <a class="btn-wishlist" href="<?php echo e(route('public.wishlist')); ?>">
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-wishlist" xlink:href="#svg-icon-wishlist"></use>
                                                </svg>
                                            </span>
                                            <span class="header-item-counter">
                                                <?php echo e(auth('customer')->check() ? auth('customer')->user()->wishlist()->count() : Cart::instance('wishlist')->count()); ?>

                                            </span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if(EcommerceHelper::isCartEnabled()): ?>
                                    <div class="header__extra cart--mini" tabindex="0" role="button">
                                        <div class="header__extra">
                                            <a class="btn-shopping-cart" href="<?php echo e(route('public.cart')); ?>">
                                                <span class="svg-icon">
                                                    <svg>
                                                        <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                                    </svg>
                                                </span>
                                                <span class="header-item-counter"><?php echo e(Cart::instance('cart')->count()); ?></span>
                                            </a>
                                            <span class="cart-text">
                                                <span class="cart-title"><?php echo e(__('Your Cart')); ?></span>
                                                <span class="cart-price-total">
                                                    <span class="cart-amount">
                                                        <bdi>
                                                            <span><?php echo e(format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax())); ?></span>
                                                        </bdi>
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="cart__content" id="cart-mobile">
                                            <div class="backdrop"></div>
                                            <div class="mini-cart-content">
                                                <div class="widget-shopping-cart-content">
                                                    <?php echo Theme::partial('cart-mini.list'); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div hidden class="header-bottom">
                <div class="header-wrapper">
                    <nav class="navigation">
                        <div class="container-xxxl">
                            <div class="navigation__left">
                                <?php if(is_plugin_active('ecommerce')): ?>
                                    <div class="menu--product-categories">
                                        <div class="menu__toggle">
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-list" xlink:href="#svg-icon-list"></use>
                                                </svg>
                                            </span>
                                            <span class="menu__toggle-title"><?php echo e(__('Shop by Category')); ?></span>
                                        </div>
                                        <div class="menu__content">
                                            <ul class="menu--dropdown">
                                                <?php echo Theme::partial('product-categories-dropdown', compact('categories')); ?>

                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="navigation__center">
                                <?php echo Menu::renderMenuLocation('main-menu', [
                                    'view'    => 'menu',
                                    'options' => ['class' => 'menu'],
                                ]); ?>

                            </div>
                            <div class="navigation__right">
                                <?php if(is_plugin_active('ecommerce') && EcommerceHelper::isEnabledCustomerRecentlyViewedProducts()): ?>
                                    <div class="header-recently-viewed" data-url="<?php echo e(route('public.ajax.recently-viewed-products')); ?>" role="button">
                                        <h3 class="recently-title">
                                            <span class="svg-icon recent-icon">
                                                <svg>
                                                    <use href="#svg-icon-refresh" xlink:href="#svg-icon-refresh"></use>
                                                </svg>
                                            </span>
                                            <?php echo e(__('Recently Viewed')); ?>

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
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="header-mobile header-js-handler" data-sticky="<?php echo e(theme_option('sticky_header_mobile_enabled', 'yes') == 'yes' ? 'true' : 'false'); ?>"  style="max-height:100px!important; padding:5px!important;">
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
                    <?php if(theme_option('logo')): ?>
                        <div class="logo">
                            <a href="<?php echo e(route('public.index')); ?>">
                                <img src="<?php echo e(RvMedia::getImageUrl(theme_option('logo'))); ?>" alt="<?php echo e(theme_option('site_title')); ?>" width="60"  style="margin-<?php echo e($dir); ?>:40px;">
                            </a>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/header.blade.php ENDPATH**/ ?>