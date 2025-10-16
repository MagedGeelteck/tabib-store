<?php

$tag_ids=DB::table('ec_product_tag_product')->where(['product_id'=>$product->id])->pluck('tag_id');
$tags=DB::table('ec_product_tags')->whereIn('id', $tag_ids)->get();

?>

<?php if($tags): ?>
<div class="summary-meta">
<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="product-stock in-stock d-inline-block">
                <?php echo e($tag->name); ?>

            </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?><?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/ecommerce/product-availability.blade.php ENDPATH**/ ?>