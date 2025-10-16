<?php
    Theme::layout('full-width');
    $products->loadMissing('defaultVariation');
?>

<?php echo $widgets = dynamic_sidebar('products_list_sidebar'); ?>


<?php if(empty($widgets)): ?>
    <?php echo Theme::partial('page-header', ['size' => 'xxxl', 'withTitle' => false]); ?>

<?php endif; ?>

<div class="container-xxxl">
    <div class="row my-5">
        <div class="col-12">
            <div class="row catalog-header justify-content-between">
                <div class="col-auto catalog-header__left d-flex align-items-center">
                    <h1 hidden class="h2 catalog-header__title d-none d-lg-block"><?php echo e(__('Search')); ?></h1>
                    <a class="d-lg-none sidebar-filter-mobile" href="#">
                        <span class="svg-icon me-2">
                            <svg>
                                <use href="#svg-icon-filter" xlink:href="#svg-icon-filter"></use>
                            </svg>
                        </span>
                        <span><?php echo e(__('Filter')); ?></span>
                    </a>
                </div>
                <div class="col-auto catalog-header__right">
                    <div class="catalog-toolbar row align-items-center">
                        <?php echo $__env->make(Theme::getThemeNamespace() . '::views.ecommerce.includes.sort', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make(Theme::getThemeNamespace() . '::views.ecommerce.includes.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div  hidden class="col-xxl-2 col-lg-3">
            <form action="<?php echo e(URL::current()); ?>"
                data-action="<?php echo e(route('public.products')); ?>"
                method="GET"
                id="products-filter-form">
                <?php echo $__env->make(Theme::getThemeNamespace() . '::views.ecommerce.includes.filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </form>
        </div>
        <div class="col-xxl-12 col-lg-12 products-listing position-relative">
            <?php echo $__env->make(Theme::getThemeNamespace('views.ecommerce.includes.product-items'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/products.blade.php ENDPATH**/ ?>