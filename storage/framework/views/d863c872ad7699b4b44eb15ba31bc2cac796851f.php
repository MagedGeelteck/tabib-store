<div class="text-swatches-wrapper widget-filter-item" data-type="text">
    <h4 class="widget-title"><?php echo e(__('By :name', ['name' => $set->title])); ?></h4>
    <div class="widget-content">
        <div class="attribute-values">
            <ul class="text-swatch">
                <?php $__currentLoopData = $attributes->where('attribute_set_id', $set->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-slug="<?php echo e($attribute->slug); ?>">
                        <div>
                            <label>
                                <input class="product-filter-item" type="checkbox" name="attributes[]" value="<?php echo e($attribute->id); ?>" <?php if(in_array($attribute->id, $selected)): echo 'checked'; endif; ?>>
                                <span><?php echo e($attribute->title); ?></span>
                            </label>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/attributes/_layouts-filter/text.blade.php ENDPATH**/ ?>