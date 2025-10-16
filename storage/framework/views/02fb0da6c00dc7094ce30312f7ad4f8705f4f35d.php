<?php
    $categories->loadMissing(['slugable', 'activeChildren:id,name,parent_id', 'activeChildren.slugable']);

    if (!empty($categoriesRequest)) {
        $categories = $categories->whereIn('id', $categoriesRequest);
    }
?>

<ul>
    <?php if(!empty($categoriesRequest)): ?>
        <li class="category-filter">
            <a class="nav-list__item-link" href="<?php echo e(route('public.products')); ?>" data-id="">
                <span class="cat-menu-close svg-icon">
                    <svg>
                        <use href="#svg-icon-chevron-left" xlink:href="#svg-icon-close"></use>
                    </svg>
                </span>
                <span><?php echo e(__('All categories')); ?></span>
            </a>
        </li>
    <?php endif; ?>

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isActive = $urlCurrent == $category->url ||
                (!empty($categoriesRequest && in_array($category->id, $categoriesRequest))) ||
                ($loop->first && $categoriesRequest && $categories->count() == 1 && $category->activeChildren->count());
        ?>
        <li class="category-filter <?php if($isActive): ?> opened <?php endif; ?>">
            <div class="widget-layered-nav-list__item">
                <div class="nav-list__item-title">
                    <a class="nav-list__item-link <?php if($isActive): ?> active <?php endif; ?>"
                        href="<?php echo e($category->url); ?>" data-id="<?php echo e($category->id); ?>">
                        <?php if(!$category->parent_id): ?>
                            <?php if($category->getMetaData('icon_image', true)): ?>
                                <img src="<?php echo e(RvMedia::getImageUrl($category->getMetaData('icon_image', true))); ?>" alt="<?php echo e($category->name); ?>" width="18" height="18">
                            <?php elseif($category->getMetaData('icon', true)): ?>
                                <i class="<?php echo e($category->getMetaData('icon', true)); ?>"></i>
                            <?php endif; ?>
                            <span class="ms-1"><?php echo BaseHelper::clean($category->name); ?></span>
                        <?php else: ?>
                            <span><?php echo BaseHelper::clean($category->name); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <?php if($category->activeChildren->count()): ?>
                    <span class="cat-menu-close svg-icon">
                        <svg>
                            <use href="#svg-icon-close" xlink:href="#svg-icon-close"></use>
                        </svg>
                    </span>
                <?php endif; ?>
            </div>
            <?php if($category->activeChildren->count()): ?>
                <?php echo $__env->make(Theme::getThemeNamespace() . '::views.ecommerce.includes.categories', compact('urlCurrent') + [
                    'categories' => $category->activeChildren,
                    'categoriesRequest' => [],
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/includes/categories.blade.php ENDPATH**/ ?>