<?php
    $brands = get_all_brands(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], [], ['products']);
    $tags = app(\Botble\Ecommerce\Repositories\Interfaces\ProductTagInterface::class)->advancedGet([
        'condition' => ['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED],
        'with'      => [],
        'withCount' => ['products'],
        'order_by'  => ['products_count' => 'desc'],
        'take'      => 10,
    ]);
    $rand = mt_rand();
    $categoriesRequest = (array)request()->input('categories', []);
    $urlCurrent = URL::current();

    Theme::asset()->usePath()
                ->add('custom-scrollbar-css', 'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.css');
    Theme::asset()->container('footer')->usePath()
                ->add('custom-scrollbar-js', 'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.js', ['jquery']);
?>

<input type="hidden" name="sort-by" class="product-filter-item" value="<?php echo e(request()->input('sort-by')); ?>">
<input type="hidden" name="layout" class="product-filter-item" value="<?php echo e(request()->input('layout')); ?>">
<input type="hidden" name="q" value="<?php echo e(BaseHelper::stringify(request()->query('q'))); ?>">

<aside class="catalog-primary-sidebar catalog-sidebar" data-toggle-target="product-categories-primary-sidebar">
    <div class="backdrop"></div>
    <div class="catalog-sidebar--inner side-left">
        <div class="panel__header d-md-none mb-4">
            <span class="panel__header-title"><?php echo e(__('Filter Products')); ?></span>
            <a class="close-toggle--sidebar" href="#" data-toggle-closest=".catalog-primary-sidebar">
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-arrow-right" xlink:href="#svg-icon-arrow-right"></use>
                    </svg>
                </span>
            </a>
        </div>
        <div class="catalog-filter-sidebar-content px-3 px-md-0">
            <div class="widget-wrapper widget-product-categories">
                <h4 class="widget-title"><?php echo e(__('Product Categories')); ?></h4>
                <div class="widget-layered-nav-list">
                    <?php echo $__env->make(Theme::getThemeNamespace() . '::views.ecommerce.includes.categories', compact('categories', 'categoriesRequest', 'urlCurrent'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <?php if(count($brands) > 0): ?>
                <div class="widget-wrapper widget-product-brands">
                    <h4 class="widget-title"><?php echo e(__('Brands')); ?></h4>
                    <div class="widget-layered-nav-list ps-custom-scrollbar">
                        <ul>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($brand->products_count > 0): ?>
                                    <li>
                                        <div class="widget-layered-nav-list__item">
                                            <div class="form-check">
                                                <input class="form-check-input product-filter-item" type="checkbox" name="brands[]" value="<?php echo e($brand->id); ?>"
                                                    id="attribute-brand-<?php echo e($rand); ?>-<?php echo e($brand->id); ?>" <?php if(in_array($brand->id, request()->input('brands', []))): ?> checked <?php endif; ?>>
                                                <label class="form-check-label" for="attribute-brand-<?php echo e($rand); ?>-<?php echo e($brand->id); ?>">
                                                    <span><?php echo e($brand->name); ?></span>
                                                    <span class="count">(<?php echo e($brand->products_count); ?>)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(count($tags) > 0): ?>
                <div class="widget-wrapper widget-product-tags">
                    <h4 class="widget-title"><?php echo e(__('Tags')); ?></h4>
                    <div class="widget-layered-nav-list ps-custom-scrollbar">
                        <ul>
                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($tag->products_count > 0): ?>
                                    <li>
                                        <div class="widget-layered-nav-list__item">
                                            <div class="form-check">
                                                <input class="form-check-input product-filter-item" type="checkbox" name="tags[]" value="<?php echo e($tag->id); ?>"
                                                    id="attribute-tag-<?php echo e($rand); ?>-<?php echo e($tag->id); ?>" <?php if(in_array($tag->id, request()->input('tags', []))): ?> checked <?php endif; ?>>
                                                <label class="form-check-label" for="attribute-tag-<?php echo e($rand); ?>-<?php echo e($tag->id); ?>"><span><?php echo e($tag->name); ?></span>
                                                    <span class="count">(<?php echo e($tag->products_count); ?>)</span></label>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <div class="widget-wrapper">
                <h4 class="widget-title"><?php echo e(__('By Price')); ?></h4>
                <div class="widget__content nonlinear-wrapper">
                    <div class="nonlinear" data-min="0" data-max="<?php echo e((int)theme_option('max_filter_price', 100000) * get_current_exchange_rate()); ?>"></div>
                    <div class="slider__meta">
                        <input class="product-filter-item product-filter-item-price-0" name="min_price" data-min="0" value="<?php echo e(request()->input('min_price', 0)); ?>"
                            type="hidden">
                        <input class="product-filter-item product-filter-item-price-1" name="max_price" data-max="<?php echo e(theme_option('max_filter_price', 100000)); ?>"
                            value="<?php echo e(request()->input('max_price', theme_option('max_filter_price', 100000))); ?>" type="hidden">
                            <span class="slider__value">
                                <span class="slider__min"></span>
                                <?php echo e(get_application_currency()->title); ?></span>
                        -<span class="slider__value"><span class="slider__max"></span> <?php echo e(get_application_currency()->title); ?></span>
                    </div>
                </div>
                <?php echo render_product_swatches_filter([
                    'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.attributes-filter-renderer'
                ]); ?>

            </div>
        </div>
    </div>
</aside>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/includes/filters.blade.php ENDPATH**/ ?>