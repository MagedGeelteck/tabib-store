<?php if($paginator->hasPages()): ?>
    <div class="pagination-numeric-short">
        <?php if($paginator->onFirstPage()): ?>
            <a href="#" class="disabled" aria-disabled="true" style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-left " style="font-size:16px; color:#000; margin-top:10px;"></i>
                </span>
            </a>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>"style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-left " style="font-size:16px; color:#000; margin-top:10px;"></i>
                </span>
            </a>
        <?php endif; ?>

        <form class="toolbar-pagination" action="<?php echo e($paginator->path()); ?>" method="GET">
            <?php $__currentLoopData = request()->input(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key != $paginator->getPageName() && is_string($item)): ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($item); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <input style="min-width:70px; font-size:15px;" class="catalog-page-number" type="number" name="<?php echo e($paginator->getPageName()); ?>" value="<?php echo e($paginator->currentPage()); ?>" min="1" max="<?php echo e($paginator->lastPage()); ?>" step="1">
        </form><span style="font-size:16px;"> / <?php echo e($paginator->lastPage()); ?></span>

        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-right " style="font-size:16px; color:#000; margin-top:10px;"></i>

                </span>
            </a>
        <?php else: ?>
            <a href="#" class="disabled" aria-disabled="true" style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-right " style="font-size:16px; color:#000; margin-top:10px;"></i>

                </span>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/pagination-numeric.blade.php ENDPATH**/ ?>