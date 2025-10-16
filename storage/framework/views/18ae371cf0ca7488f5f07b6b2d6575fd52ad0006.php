<div class="quantity">
    <label class="label-quantity"><?php echo e(__('Quantity')); ?>:</label>
    <div class="qty-box">
        <span class="svg-icon decrease">
            <svg>
                <use href="#svg-icon-decrease" xlink:href="#svg-icon-decrease"></use>
            </svg>
        </span>
        <input class="input-text qty"
            type="number"
            step="1"
            min="1"
            max="<?php echo e($product->with_storehouse_management ? $product->quantity : 1000); ?>"
            name="<?php echo e($name ?? 'qty'); ?>"
            value="<?php echo e($value ?? 1); ?>"
            title="Qty"
            tabindex="0" required>
        <span class="svg-icon increase">
            <svg>
                <use href="#svg-icon-increase" xlink:href="#svg-icon-increase"></use>
            </svg>
        </span>
    </div>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/ecommerce/product-quantity.blade.php ENDPATH**/ ?>