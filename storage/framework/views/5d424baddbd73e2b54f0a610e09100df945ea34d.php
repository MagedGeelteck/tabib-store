<div class="panel__header">
    <span class="panel__header-title"><?php echo e(__('Shopping Cart')); ?>

        <span class="cart-counter">(<?php echo e(Cart::instance('cart')->count()); ?>)</span>
    </span>
    <a class="close-toggle--sidebar" href="#" data-toggle-closest=".cart__content">
        <span class="svg-icon">
            <svg>
                <use href="#svg-icon-arrow-right" xlink:href="#svg-icon-arrow-right"></use>
            </svg>
        </span>
    </a>
</div>
<div class="cart__items">
    <?php if(Cart::instance('cart')->count() > 0 && ($products = Cart::instance('cart')->products()) && $products->count() > 0): ?>
        <ul class="mini-product-cart-list">
            <?php $__currentLoopData = Cart::instance('cart')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($product = $products->find($cartItem->id)): ?>
                    <?php echo Theme::partial('cart-mini.item', compact('product', 'cartItem')); ?>

                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <div class="cart_no_items py-3 px-3">
            <span class="cart-empty-message"><?php echo e(__('No products in the cart.')); ?></span>
        </div>
    <?php endif; ?>
</div>

<?php if(Cart::instance('cart')->count() > 0 && Cart::instance('cart')->products()->count() > 0): ?>
    <div class="control-buttons">
        <?php if(EcommerceHelper::isTaxEnabled()): ?>
            <div class="mini-cart__total">
                <strong><?php echo e(__('Sub Total')); ?>:</strong>
                <span class="price-amount">
                    <bdi><?php echo e(format_price(Cart::instance('cart')->rawSubTotal())); ?></bdi>
                </span>
            </div>
            <div class="mini-cart__total">
                <strong><?php echo e(__('Tax')); ?>:</strong>
                <span class="price-amount">
                    <bdi><?php echo e(format_price(Cart::instance('cart')->rawTax())); ?></bdi>
                </span>
            </div>
            <div class="mini-cart__total">
                <strong class="text-uppercase"><?php echo e(__('Total')); ?>:</strong>
                <span class="price-amount">
                    <bdi><?php echo e(format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax())); ?></bdi>
                </span>
            </div>
        <?php else: ?>
            <div class="mini-cart__total">
                <strong class="text-uppercase"><?php echo e(__('Sub Total')); ?>:</strong>
                <span class="price-amount">
                    <bdi>
                        <?php echo e(format_price(Cart::instance('cart')->rawSubTotal())); ?>

                    </bdi>
                </span>
            </div>
        <?php endif; ?>
        <div class="mini-cart__buttons row g-0">
            <div class="col me-2">
                <a class="btn btn-light" href="<?php echo e(route('public.cart')); ?>"><?php echo e(__('View Cart')); ?></a></div>
            <div class="col ms-2">
                <?php if(session('tracked_start_checkout')): ?>
                    <a class="btn btn-primary checkout"
                        href="<?php echo e(route('public.checkout.information', session('tracked_start_checkout'))); ?>"><?php echo e(__('Checkout')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/cart-mini/list.blade.php ENDPATH**/ ?>