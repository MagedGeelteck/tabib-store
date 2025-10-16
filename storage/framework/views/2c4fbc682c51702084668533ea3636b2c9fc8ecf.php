<div class="visual-swatches-wrapper widget--colors widget-filter-item" data-type="visual">
    <h4 class="widget-title"><?php echo e(__('By :name', ['name' => $set->title])); ?></h4>
    <div class="widget-content">
        <div class="attribute-values">
            <ul class="visual-swatch color-swatch">
                <?php $__currentLoopData = $attributes->where('attribute_set_id', $set->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-slug="<?php echo e($attribute->slug); ?>"
                        title="<?php echo e($attribute->title); ?>">
                        <div class="custom-checkbox">
                            <label>
                                <input class="form-control product-filter-item" type="checkbox" name="attributes[]" value="<?php echo e($attribute->id); ?>" <?php if(in_array($attribute->id, $selected)): echo 'checked'; endif; ?>>
				                <span style="<?php echo e($attribute->getAttributeStyle()); ?>"></span>
                            </label>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/attributes/_layouts-filter/visual.blade.php ENDPATH**/ ?>