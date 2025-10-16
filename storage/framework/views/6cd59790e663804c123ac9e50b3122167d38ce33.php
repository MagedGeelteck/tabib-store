<?php
$product->image=$product->images[0] ?? RvMedia::getDefaultImage();
?>



<div class="product-thumbnail">
    <a class="product-loop__link img-fluid-eq" href="<?php echo e($product->url); ?>" tabindex="0">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap hover-effect">
            <figure class="text-center">
            <img class="lazyload product-thumbnail__img"
                src="<?php echo e(RvMedia::getImageUrl($product->image)); ?>"
                data-src="<?php echo e(RvMedia::getImageUrl($product->image)); ?>"
            alt="<?php echo e($product->name); ?>" style="max-height:299px;"> <figcaption>Test message</figcaption></figure>

        </div>
 <span class="ribbons">
            <?php if($product->stock_status!="in_stock" ||($product->with_storehouse_management==1 && $product->quantity==0)): ?>
                <span class="ribbon out-stock bg-warning"><?php echo e(__('Out Of Stock')); ?></span>
            <?php else: ?>

                    <?php if($product->sale_price > $product->price): ?>
                        <div class="featured ribbon" dir="ltr"><?php echo e(get_sale_percentage($product->price, $product->sale_price)); ?></div>
                    <?php endif; ?>
                    <?php if(true): ?>
                        <div class="ribbon m-1 bg-transparent" dir="ltr">
                            
                            
<form class="cart-form" action="<?php echo e(route('public.cart.add-to-cart')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php if(!empty($withVariations) && $product->variations()->count() > 0): ?>
        <div class="pr_switch_wrap">
            <?php echo render_product_swatches($product, [
                'selected' => $selectedAttrs,
                'view'     => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
            ]); ?>

        </div>
    <?php endif; ?>


    <input type="hidden"
        name="id" class="hidden-product-id"
        value="<?php echo e($product->id); ?>"/>

    <?php if(EcommerceHelper::isCartEnabled() || !empty($withButtons)): ?>
        <?php echo apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product); ?>

        <div class="product-button">
            <?php if(EcommerceHelper::isCartEnabled()): ?>

                <button type="submit" name="add_to_cart" value="1" style="padding:5px; background-color:transparent; font-size:23px;" class="btn btn-primary  add-to-cart-button <?php if($product->stock_status!="in_stock"): ?> disabled <?php endif; ?>" <?php if($product->stock_status!="in_stock"): ?> disabled <?php endif; ?> title="<?php echo e(__('Add to cart')); ?>">
                        <i class="icon-cart"></i>
                </button>

            <?php endif; ?>
            
        </div>
    <?php endif; ?>
</form>

                            </div>
                    <?php endif; ?>
            <?php endif; ?>
        </span>
    </a>
</div>
<div class="product-details position-relative" style="background-color:#fff!important;">
    <div class="product-content-box p-1">

        <h6 class="product__title">
            <a href="<?php echo e($product->url); ?>" tabindex="0"><small><p 
            style="overflow: hidden;max-width: 45ch;white-space: nowrap; text-overflow: ellipsis; font-size:13px;">
        <?php echo BaseHelper::clean($product->name); ?>

        </p></small></a>
        </h6>
        
        
        
        <div class="row">

<div class="col-1 pt-1"></div>
<div class="col-11 pt-1">  

<span class="product-price">
    <span class="product-price-sale d-flex align-items-center <?php if($product->price <= $product->sale_price || $product->sale_price==null): ?> d-none <?php endif; ?>">
        <del aria-hidden="true">
            <span class="price-amount">
                <bdi>
                    <span class="amount" style="font-size:18px;"><?php echo e(format_price($product->price)); ?></span>
                </bdi>
            </span>
        </del>
        <ins>
            <span class="price-amount">
                <bdi>
                    <span class="amount" style="font-size:18px;"><?php echo e(format_price($product->sale_price)); ?></span>
                </bdi>
            </span>
        </ins>
    </span>
    <span class="product-price-original <?php if($product->price > $product->sale_price && $product->sale_price!=null): ?> d-none <?php endif; ?>">
        <span class="price-amount">
            <bdi>
                <span class="amount" style="font-size:18px;"><?php echo e(format_price($product->price)); ?></span>
            </bdi>
        </span>
    </span>
</span>

</div>
</div></div></div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/ecommerce/product-item.blade.php ENDPATH**/ ?>