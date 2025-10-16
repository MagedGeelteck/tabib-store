<?php

if(BaseHelper::siteLanguageDirection() == 'rtl'){
$langcode='ar';
}else{
$langcode='en';
}

$category_id=request()->segment(count(request()->segments()));

?>



            
    
    <div class="section-content lazyload bg-light">
            <div class="row gx-0 gx-md-4">
                <div class="col-md-12">
                    <div class="section-slides-wrapper">
                        <div class="slide-body slick-slides-carousel active">
                                <div class="slide-item">
                                    <div class="slide-item__image">
                                    <?php
                                     $slider=DB::table('simple_slider_items')->orderBy('id','DESC')->first();
                                     ?>
                                            <picture>
                                                <source srcset="<?php echo e(RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage())); ?>" media="(min-width: 1200px)" />
                                                <source srcset="<?php echo e(RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage())); ?>" media="(min-width: 768px)" />
                                                <source srcset="<?php echo e(RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage())); ?>" media="(max-height: 767px)" />
                                                <img src="<?php echo e($slider->image); ?>" alt="slider" / style="border-radius:10px; max-width: 100%;min-width: 300px;height: auto;">
                                            </picture>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<div class="scroll" style="
background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                     <?php 
                                     if(BaseHelper::siteLanguageDirection() != 'rtl'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$category->id)->first();
                                     $category->name=$subcat_translation->name;
                                     }
                                     ?>
                                
                                
                                <?php if($category->id==$category_id || $parent== $category->id): ?>
                                
                                        <a href="<?php echo e(route('products.category',$category->id)); ?>">
                                <span class="font-weight-bold text-dark categories-slider active-category" style="background-color:#7CAA53!important;"><?php echo e($category->name); ?></button>
                                </a>
                                    <?php endif; ?>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($category->id!=$category_id && $parent!= $category->id): ?>
                                
                                        <a href="<?php echo e(route('products.category',$category->id)); ?>">
                                <span class="font-weight-bold text-dark categories-slider"><?php echo e($category->name); ?></button>
                                </a>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

<?php if($subcats): ?>
<div class="scroll" style="
background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                <?php $__currentLoopData = $subcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                     <?php 
                                     if(BaseHelper::siteLanguageDirection() != 'rtl'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$category->id)->first();
                                     $category->name=$subcat_translation->name;
                                     }
                                     ?>                                
                                
                                <?php if($category->id==$category_id || $parent== $category->id ||$parent_sub== $category->id): ?>
                                
                                        <a href="<?php echo e(route('products.category',$category->id)); ?>">
                                <span class="font-weight-bold text-dark categories-slider active-category" style="background-color:#7CAA53!important;"><?php echo e($category->name); ?></button>
                                </a>
                                    <?php endif; ?>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $subcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($category->id!=$category_id && $parent!= $category->id&& $parent_sub!= $category->id): ?>
                                
                                        <a href="<?php echo e(route('products.category',$category->id)); ?>">
                                <span class="font-weight-bold text-dark categories-slider"><?php echo e($category->name); ?></button>
                                </a>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php endif; ?>
<?php if($third_subcats): ?>
<div class="scroll" style="
background-color: #e7f0e9;
width: 100%;overflow-x: scroll;overflow-y: hidden;
white-space: nowrap;border: 1px solid #ddd;border-radius: 0px; 
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                <?php $__currentLoopData = $third_subcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                     <?php 
                                     if(BaseHelper::siteLanguageDirection() != 'rtl'){
                                     $subcat_translation=DB::table('ec_product_categories_translations')->where('ec_product_categories_id',$category->id)->first();
                                     $category->name=$subcat_translation->name;
                                     }
                                     ?>                                 
                                <?php if($category->id==$category_id): ?>
                                
                                        <a href="<?php echo e(route('products.category',$category->id)); ?>">
                                <span class="font-weight-bold text-dark categories-slider active-category" style="background-color:#7CAA53!important;"><?php echo e($category->name); ?></button>
                                </a>
                                    <?php endif; ?>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $third_subcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($category->id!=$category_id): ?>
                                
                                        <a href="<?php echo e(route('products.category',$category->id)); ?>">
                                <span class="font-weight-bold text-dark categories-slider"><?php echo e($category->name); ?></button>
                                </a>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php endif; ?>




<div class="scrolling-pagination bg-light">            
 <div class="row">
 <?php $start=0;?>     
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <?php $start++; 

 if($start=1)

 ?>

<div class="col-lg-2 col-md-2 col-6 p-2">  
<a class="img-fluid-eq" href="/<?php echo e($langcode); ?><?php echo e($product->url); ?>">

<div class="product-thumbnail" style="background-color:#fff!important; max-height:300px;">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap hover-effect">
            <figure class="text-center">
            <img class="lazyload product-thumbnail__img"
           
                src="/public/storage/compressed-images/<?php echo e($product->image); ?>"
                data-src="/public/storage/compressed-images/<?php echo e($product->image); ?>"
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
</div>

<div class="product-details position-relative" style="background-color:#fff!important;">
    <div class="product-content-box p-1">

        <h6 class="product__title" style="padding:0px;height:45px; overflow:hidden;">
            <small><p 
            style="margin-bottom:0px; font-size:13px;">
        <?php echo BaseHelper::clean($product->name); ?>

        </p></small>
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
</div></div></div></a></div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php print_r($links);?>


                           </div>
                     </div> 

                 
                    
                    
                    <?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/views/productCategory.blade.php ENDPATH**/ ?>