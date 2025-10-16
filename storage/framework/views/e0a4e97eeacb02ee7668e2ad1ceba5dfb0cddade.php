<div class="product-loop__buttons pt-3">
    <div class="quick-view-button product-loop_button product-quick-view-button"  style="padding-left:12px;">
        <a class="quick-view product-loop_action" href="#"
            data-url="<?php echo e(route('public.ajax.quick-view', ['product_id' => $product->id])); ?>"
            title="<?php echo e(__('Quick view')); ?>" data-bs-toggle="tooltip">
            <div class="product-loop_icon pb-2">
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-quick-view" xlink:href="#svg-icon-quick-view"></use>
                    </svg>
                </span>
            </div>
            <span class="text"><?php echo e(__('Quick view')); ?></span>
        </a>
    </div>
    <?php if(EcommerceHelper::isWishlistEnabled()): ?>
        <div class="wishlist-button product-wishlist-button product-loop_button" style="padding-left:6px;">
            <a class="wishlist product-loop_action <?php if(!empty($wishlistIds) && in_array($product->id, $wishlistIds)): ?> added-to-wishlist <?php endif; ?>" href="#"
                data-url="<?php echo e(route('public.ajax.add-to-wishlist', ['product_id' => $product->id])); ?>" title="<?php echo e(__('Wishlist')); ?>">
                <div class="wishlist-icons product-loop_icon pb-2">
                    <span class="svg-icon">
                        <svg>
                            <use href="#svg-icon-wishlist" xlink:href="#svg-icon-wishlist"></use>
                        </svg>
                    </span>
                    <span class="svg-icon">
                        <svg>
                            <use href="#svg-icon-wishlisted" xlink:href="#svg-icon-wishlisted"></use>
                        </svg>
                    </span>
                </div>
                <span class="text"><?php echo e(__('Wishlist')); ?></span>
            </a>
        </div>
    <?php endif; ?>
    <?php if(EcommerceHelper::isCompareEnabled()): ?>
        <div hidden class="compare-button product-compare-button product-loop_button">
            <a class="compare product-loop_action" href="#" data-url="<?php echo e(route('public.compare.add', $product->id)); ?>" title="<?php echo e(__('Compare')); ?>">
                <div class="compare-icons product-loop_icon">
                    <span class="svg-icon">
                        <svg>
                            <use href="#svg-icon-compare" xlink:href="#svg-icon-compare"></use>
                        </svg>
                    </span>
                </div>
                <span class="text"><?php echo e(__('Compare')); ?></span>
            </a>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/ecommerce/product-loop-buttons.blade.php ENDPATH**/ ?>