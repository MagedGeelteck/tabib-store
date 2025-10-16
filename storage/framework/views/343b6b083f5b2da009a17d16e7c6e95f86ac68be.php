<div class="product-gallery product-gallery--with-images row">
    <div class="product-gallery__wrapper">
        <?php $__empty_1 = true; $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="product-gallery__imag item">
                <a class="img-fluid-eq" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($key); ?>">
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img class="mx-auto" title="<?php echo e($product->name); ?>" src="<?php echo e(image_placeholder($img)); ?>" data-lazy="<?php echo e(RvMedia::getImageUrl($img)); ?>">
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          
        <?php endif; ?>
    </div>
    <div class="product-gallery__variants px-1 py-1">
        <?php $__empty_1 = true; $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="item">
                <div class="border p-1 m-1">
                    <img class="lazyload" title="<?php echo e($product->name); ?>" src="<?php echo e(image_placeholder($img, 'thumb')); ?>" data-src="<?php echo e(RvMedia::getImageUrl($img, 'thumb')); ?>">
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
           
        <?php endif; ?>
    </div>
</div>

<?php $__empty_1 = true; $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="modal fade" id="exampleModal<?php echo e($key); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg photo-galery-with-zoom">
    <div class="modal-content"> 
      <div class="modal-header text-center">
        <button type="button" class="btn btn-dark"  data-bs-dismiss="modal" aria-label="Close" style="z-index:100; margin-top:-400px!important; font-size:16px; border:1px solid red;">Close <i class="fa fa-window-close-o" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body gallery-modal-body">
     <img  class="lazyload" title="<?php echo e($product->name); ?>" src="<?php echo e(image_placeholder($img, 'thumb')); ?>" data-src="<?php echo e(RvMedia::getImageUrl($img, 'thumb')); ?>">

      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/ecommerce/product-gallery.blade.php ENDPATH**/ ?>