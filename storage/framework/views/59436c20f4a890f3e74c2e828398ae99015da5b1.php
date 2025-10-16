<span class="product-price">
    <span class="product-price-sale d-flex align-items-center <?php if($product->front_sale_price === $product->price): ?> d-none <?php endif; ?>">
        <del aria-hidden="true">
            <span class="price-amount">
                <bdi>
                    <span class="amount"><?php echo e(format_price($product->price_with_taxes)); ?></span>
                </bdi>
            </span>
        </del>
        <ins>
            <span class="price-amount">
                <bdi>
                    <span class="amount"><?php echo e(format_price($product->front_sale_price_with_taxes)); ?></span>
                </bdi>
            </span>
        </ins>
    </span>
    <span class="product-price-original <?php if($product->front_sale_price !== $product->price): ?> d-none <?php endif; ?>">
        <span class="price-amount">
            <bdi>
                <span class="amount"><?php echo e(format_price($product->front_sale_price_with_taxes)); ?></span>
            </bdi>
        </span>
    </span>
</span>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/ecommerce/product-price.blade.php ENDPATH**/ ?>