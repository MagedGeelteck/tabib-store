    <footer id="footer">
        <div hidden class="footer-info border-top">
            <div class="container-xxxl py-3">
                <?php echo dynamic_sidebar('pre_footer_sidebar'); ?>

            </div>
        </div>
        <?php if(Widget::group('footer_sidebar')->getWidgets()): ?>
            <div class="footer-widgets">
                <div class="container-xxxl">
                    <div class="row border-top py-5">
                        <?php echo dynamic_sidebar('footer_sidebar'); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if(Widget::group('bottom_footer_sidebar')->getWidgets()): ?>
            <div hidden class="container-xxxl">
                <div class="footer__links" id="footer-links">
                    <?php echo dynamic_sidebar('bottom_footer_sidebar'); ?>

                </div>
            </div>
        <?php endif; ?>
        <div class="container-xxxl">
            <div class="row border-top py-4">
                <div class="col-lg-3 col-md-4 py-3">
                    <div class="copyright d-flex justify-content-center justify-content-md-start">
                        <span><?php echo e(theme_option('copyright')); ?></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4 py-3">
                    <?php if(theme_option('payment_methods_image')): ?>
                        <div class="footer-payments d-flex justify-content-center">
                            <?php if(theme_option('payment_methods_link')): ?>
                                <a href="<?php echo e(url(theme_option('payment_methods_link'))); ?>" target="_blank">
                            <?php endif; ?>

                            <img class="lazyload"
                                data-src="<?php echo e(RvMedia::getImageUrl(theme_option('payment_methods_image'))); ?>" alt="footer-payments">

                            <?php if(theme_option('payment_methods_link')): ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="footer-socials d-flex justify-content-md-end justify-content-center">
                        <?php if(theme_option('social_links')): ?>
                            <p class="me-3 mb-0"><?php echo e(__('Stay connected:')); ?></p>
                            <div class="footer-socials-container">
                                <ul class="ps-0 mb-0">
                                    <?php $__currentLoopData = json_decode(theme_option('social_links'), true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialLink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(count($socialLink) == 3): ?>
                                            <li class="d-inline-block ps-1 my-1">
                                                <a target="_blank" href="<?php echo e(Arr::get($socialLink[2], 'value')); ?>" title="<?php echo e(Arr::get($socialLink[0], 'value')); ?>">
                                                    <img class="lazyload" data-src="<?php echo e(RvMedia::getImageUrl(Arr::get($socialLink[1], 'value'))); ?>"
                                                        alt="<?php echo e(Arr::get($socialLink[0], 'value')); ?>" />
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php if(is_plugin_active('ecommerce')): ?>
        <div class="panel--sidebar" id="navigation-mobile">
            <div class="panel__header">
                <span class="svg-icon close-toggle--sidebar">
                    <svg>
                        <use href="#svg-icon-arrow-left" xlink:href="#svg-icon-arrow-left"></use>
                    </svg>
                </span>
                <h3><?php echo e(__('Categories')); ?></h3>
            </div>
            <div class="panel__content">
                <ul class="menu--mobile">
                    <?php echo Theme::partial('product-categories-dropdown', compact('categories')); ?>

                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="panel--sidebar" id="menu-mobile">
        <div class="panel__header">
            <span class="svg-icon close-toggle--sidebar">
                <svg>
                    <use href="#svg-icon-arrow-left" xlink:href="#svg-icon-arrow-left"></use>
                </svg>
            </span>
            <h3><?php echo e(__('Menu')); ?></h3>
        </div>
        <div class="panel__content">
            <?php echo Menu::renderMenuLocation('main-menu', [
                'view'    => 'menu',
                'options' => ['class' => 'menu--mobile'],
            ]); ?>


            <?php echo Menu::renderMenuLocation('header-navigation', [
                'view'    => 'menu',
                'options' => ['class' => 'menu--mobile'],
            ]); ?>


            <ul class="menu--mobile">

                <?php if(is_plugin_active('ecommerce')): ?>
                    <?php if(EcommerceHelper::isCompareEnabled()): ?>
                        <li><a href="<?php echo e(route('public.compare')); ?>"><span><?php echo e(__('Compare')); ?></span></a></li>
                    <?php endif; ?>

                    <?php $currencies = get_all_currencies(); ?>
                    <?php if(count($currencies) > 1): ?>
                        <li class="menu-item-has-children">
                            <a href="#">
                                <span><?php echo e(get_application_currency()->title); ?></span>
                                <span class="sub-toggle">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                    </svg>
                                </span>
                            </span>
                            </a>
                            <ul class="sub-menu">
                                <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($currency->id !== get_application_currency_id()): ?>
                                        <li><a href="<?php echo e(route('public.change-currency', $currency->title)); ?>"><span><?php echo e($currency->title); ?></span></a></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(is_plugin_active('language')): ?>
                        <?php
                            $supportedLocales = Language::getSupportedLocales();
                        ?>

                        <?php if($supportedLocales && count($supportedLocales) > 1): ?>
                            <?php
                                $languageDisplay = setting('language_display', 'all');
                            ?>
                            
        <li>
            
            <?php
    $supportedLocales = Language::getSupportedLocales();
    if (empty($options)) {
        $options = [
            'before'    => '',
            'lang_flag'  => true,
            'lang_name' => true,
            'class'     => '',
            'after'     => '',
        ];
    }
?>
            <?php echo Arr::get($options, 'before'); ?>

        <?php $__currentLoopData = $supportedLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($localeCode != Language::getCurrentLocale()): ?>
                    <a href="<?php echo e(Language::getSwitcherUrl($localeCode, $properties['lang_code'])); ?>">
                        <?php if(Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag')): ?>
                            <?php echo language_flag($properties['lang_flag'], $properties['lang_name']); ?>

                        <?php endif; ?>
                        <?php if(Arr::get($options, 'lang_name', true) && ($languageDisplay == 'all' || $languageDisplay == 'name')): ?>
                            <span class="text-dark"><?php echo e($properties['lang_name']); ?></span>
                        <?php endif; ?>
                    </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </li>

                        <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="panel--sidebar panel--sidebar__right" id="search-mobile">
        <div class="panel__header">
            <?php if(is_plugin_active('ecommerce')): ?>
            <form class="form--quick-search w-100" action="<?php echo e(route('public.products')); ?>" data-ajax-url="<?php echo e(route('public.ajax.search-products')); ?>" method="get">
                <div class="search-inner-content">
                    <div class="text-search">
                        <div class="search-wrapper">
                            <input class="search-field input-search-product" name="q" type="text" placeholder="<?php echo e(__('Search something...')); ?>" autocomplete="off">
                            <button class="btn" type="submit">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <a class="close-search-panel close-toggle--sidebar" href="#">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-times" xlink:href="#svg-icon-times"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="panel--search-result"></div>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-mobile">
        <ul class="menu--footer">
            <li>
                <a href="<?php echo e(route('public.index')); ?>">
                    <i class="icon-home3"></i>
                    <span><?php echo e(__('Home')); ?></span>
                </a>
            </li>
            <?php if(is_plugin_active('ecommerce')): ?>
                <li>
                    <a class="toggle--sidebar" href="#navigation-mobile">
                        <i class="icon-list"></i>
                        <span><?php echo e(__('Category')); ?></span>
                    </a>
                </li>
                <?php if(EcommerceHelper::isCartEnabled()): ?>
                    <li>
                        <a href="<?php echo e(route('public.cart')); ?>">
                            <i class="icon-cart">
                                <span class="cart-counter"><?php echo e(Cart::instance('cart')->count()); ?></span>
                            </i>
                            <span><?php echo e(__('Cart')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(EcommerceHelper::isWishlistEnabled()): ?>
                    <li>
                        <a href="<?php echo e(route('public.wishlist')); ?>">
                            <i class="icon-heart"></i>
                            <span><?php echo e(__('Wishlist')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo e(route('customer.overview')); ?>">
                        <i class="icon-user"></i>
                        <span><?php echo e(__('Account')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if(is_plugin_active('ecommerce')): ?>
        <?php echo Theme::partial('ecommerce.quick-view-modal'); ?>

    <?php endif; ?>
    <?php echo Theme::partial('toast'); ?>


    <div class="panel-overlay-layer"></div>
    <div id="back2top" class="d-none d-xl-block">
        <span class="svg-icon">
            <svg>
                <use href="#svg-icon-arrow-up" xlink:href="#svg-icon-arrow-up"></use>
            </svg>
        </span>
    </div>

    <script>
        'use strict';

        window.trans = {
            "View All": "<?php echo e(__('View All')); ?>",
            "No reviews!": "<?php echo e(__('No reviews!')); ?>"
        };

        window.siteConfig = {
            "url"            : "<?php echo e(route('public.index')); ?>",
            "img_placeholder": "<?php echo e(theme_option('lazy_load_image_enabled', 'yes') == 'yes' ? image_placeholder() : null); ?>",
            "countdown_text" : {
                "days"   : "<?php echo e(__('days')); ?>",
                "hours"  : "<?php echo e(__('hours')); ?>",
                "minutes": "<?php echo e(__('mins')); ?>",
                "seconds": "<?php echo e(__('secs')); ?>"
            }
        };

        <?php if(is_plugin_active('ecommerce') && EcommerceHelper::isCartEnabled()): ?>
            siteConfig.ajaxCart = "<?php echo e(route('public.ajax.cart')); ?>";
            siteConfig.cartUrl = "<?php echo e(route('public.cart')); ?>";
        <?php endif; ?>
    </script>

    <?php echo Theme::footer(); ?>


     <?php if(session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg)): ?>
         <script type="text/javascript">
             window.onload = function () {
                 <?php if(session()->has('success_msg')): ?>
                    MartApp.showSuccess('<?php echo e(session('success_msg')); ?>');
                 <?php endif; ?>

                 <?php if(session()->has('error_msg')): ?>
                    MartApp.showError('<?php echo e(session('error_msg')); ?>');
                 <?php endif; ?>

                 <?php if(isset($error_msg)): ?>
                    MartApp.showError('<?php echo e($error_msg); ?>');
                 <?php endif; ?>

                 <?php if(isset($errors)): ?>
                     <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        MartApp.showError('<?php echo BaseHelper::clean($error); ?>');
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>
             };
         </script>
     <?php endif; ?>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });

$('.modal-backdrop').hide();

    
</script>

<script>
 $(".container-xl").addClass("container-xxxl");
 </script>
       
            
    </body>
</html>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/footer.blade.php ENDPATH**/ ?>