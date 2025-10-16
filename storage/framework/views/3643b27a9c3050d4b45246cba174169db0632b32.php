<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php $__currentLoopData = $crumbs = Theme::breadcrumb()->getCrumbs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($i != (count($crumbs) - 1)): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e($crumb['url']); ?>"><?php echo BaseHelper::clean($crumb['label']); ?></a>
                    <span class="extra-breadcrumb-name"></span>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <span><?php echo BaseHelper::clean($crumb['label']); ?></span>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/breadcrumbs.blade.php ENDPATH**/ ?>