<div class="page-header">
    <?php if(!Theme::get('breadcrumbRendered', false)): ?>
        <div class="page-breadcrumbs">
            <div class="container-<?php echo e($size ?? 'xxxl'); ?>">
                <?php echo Theme::partial('breadcrumbs'); ?>

            </div>
        </div>
        <?php
            Theme::set('breadcrumbRendered', true);
        ?>
    <?php endif; ?>

    <?php if(!empty($withTitle) && !Theme::get('titleRendered', false)): ?>
        <div class="page-title text-center">
            <div class="container py-2 my-4">
                <h1><?php echo e($title ?? SeoHelper::getTitle()); ?></h1>
            </div>
        </div>
        <?php
            Theme::set('titleRendered', true);
        ?>
    <?php endif; ?>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/page-header.blade.php ENDPATH**/ ?>