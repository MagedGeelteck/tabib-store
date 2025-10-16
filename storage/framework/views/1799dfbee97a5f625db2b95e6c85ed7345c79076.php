<?php $__currentLoopData = $attributeSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attributeSet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(view()->exists(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts-filter.' . $attributeSet->display_layout)): ?>
        <?php echo $__env->make(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts-filter.' . $attributeSet->display_layout, [
            'set'        => $attributeSet,
            'attributes' => $attributeSet->attributes,
            'selected'   => (array)request()->query('attributes', []),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.dropdown', [
            'set'        => $attributeSet,
            'attributes' => $attributeSet->attributes,
            'selected'   => (array)request()->query('attributes', []),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/attributes/attributes-filter-renderer.blade.php ENDPATH**/ ?>