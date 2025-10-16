<?php
    Theme::layout('full-width');
    Theme::set('bodyClass', 'single-product');
?>
<?php echo Theme::partial('page-header', ['size' => 'xxxl']); ?>


<div class="product-detail-container">
    <div class="bg-light py-md-5 px-lg-3 px-2">
        <div class="container-xxxl rounded-7 bg-white py-lg-5 py-md-4 py-3 px-3 px-md-4 px-lg-5">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-md-1 pb-md-1 mb-3">
                    <?php echo Theme::partial('ecommerce.product-gallery', compact('product', 'productImages')); ?>

                </div>
                <div class="col-lg-6 col-md-6 ps-4 product-details-content">
                    <div class="product-details js-product-content">
                        <div class="entry-product-header">
                            <div class="product-header-left">
                                <h1 class="fs-5 fw-normal product_title entry-title"><?php echo BaseHelper::clean($product->name); ?></h1>
                                <div class="product-entry-meta">
                                    <?php if($product->brand_id): ?>
                                        <p class="mb-0 me-2 pe-2 text-secondary"><?php echo e(__('Brand')); ?>: <a href="<?php echo e($product->brand->url); ?>"><?php echo e($product->brand->name); ?></a></p>
                                    <?php endif; ?>

                                    <?php if(EcommerceHelper::isReviewEnabled()): ?>
                                        <a href="#product-reviews-tab" class="anchor-link">
                                            <?php echo Theme::partial('star-rating', ['avg' => $product->reviews_avg, 'count' => $product->reviews_count]); ?>

                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php echo Theme::partial('ecommerce.product-price', compact('product')); ?>


                        <?php if(is_plugin_active('marketplace') && $product->store_id): ?>
                            <div class="product-meta-sold-by my-2">
                                <span class="d-inline-block"><?php echo e(__('Sold By')); ?>: </span>
                                <a href="<?php echo e($product->store->url); ?>">
                                    <?php echo e($product->store->name); ?>

                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="ps-list--dot">
                            <?php echo apply_filters('ecommerce_before_product_description', null, $product); ?>

                            <?php echo BaseHelper::clean($product->description); ?>

                            <?php echo apply_filters('ecommerce_after_product_description', null, $product); ?>

                        </div>

                        <?php echo Theme::partial('ecommerce.product-availability', compact('product', 'productVariation')); ?>

                        <?php if($flashSale = $product->latestFlashSales()->first()): ?>
                            <div class="deal-expire-date p-4 bg-light mb-2">
                                <div class="row">
                                    <div class="col-xxl-5 d-md-flex justify-content-center align-items-center">
                                        <div class="deal-expire-text mb-2">
                                            <div class="fw-bold text-uppercase"><?php echo e(__('Hurry up! Sale end in')); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-7">
                                        <div class="countdown-wrapper d-none">
                                            <div class="expire-countdown col-auto" data-expire="<?php echo e(now()->diffInSeconds($flashSale->end_date)); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center my-3">
                                    <div class="deal-sold row mt-2">
                                        <div class="deal-text col-auto">
                                            <span class="sold fw-bold">
                                                <span class="text"><?php echo e(__('Sold')); ?>: </span>
                                                <span class="value"><?php echo e($flashSale->pivot->sold . '/' .
                                                    $flashSale->pivot->quantity); ?></span>
                                            </span>
                                        </div>
                                        <div class="deal-progress col">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="<?php echo e($flashSale->pivot->quantity > 0 ? ($flashSale->pivot->sold / $flashSale->pivot->quantity) * 100 : 0); ?>"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: <?php echo e($flashSale->pivot->quantity > 0 ? ($flashSale->pivot->sold / $flashSale->pivot->quantity) * 100 : 0); ?>%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php echo Theme::partial('ecommerce.product-cart-form',
                            compact('product', 'selectedAttrs') + ['withButtons' => true, 'withVariations' => true, 'wishlistIds' => [], 'withBuyNow' => true]); ?>

                        <div class="meta-sku <?php if(!$product->sku): ?> d-none <?php endif; ?>">
                            <span class="meta-label d-inline-block"><?php echo e(__('SKU')); ?>:</span>
                            <span class="meta-value"><?php echo e($product->sku); ?></span>
                        </div>
                        <?php if($product->categories->count()): ?>
                            <div class="meta-categories">
                                <span class="meta-label d-inline-block"><?php echo e(__('Categories')); ?>: </span>
                                <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($category->url); ?>"><?php echo BaseHelper::clean($category->name); ?></a><?php if(!$loop->last): ?>, <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if($product->tags->count()): ?>
                            <div class="meta-categories">
                                <span class="meta-label d-inline-block"><?php echo e(__('Tags')); ?>: </span>
                                <?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($tag->url); ?>"><?php echo e($tag->name); ?></a><?php if(!$loop->last): ?>, <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if(theme_option('social_share_enabled', 'yes') == 'yes'): ?>
                            <div class="my-5">
                                <?php echo Theme::partial('share-socials', compact('product')); ?>


                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div hidden class="col-lg-3 col-md-4">
                    <?php echo dynamic_sidebar('product_detail_sidebar'); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="container-xxxl">
        <div class="row product-detail-tabs mt-3 mb-4">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills me-3" id="product-detail-tabs" role="tablist"
                    aria-orientation="vertical">
                    <a class="nav-link active"
                        id="product-description-tab"
                        data-bs-toggle="pill"
                        href="#product-description"
                        type="button"
                        role="tab"
                        aria-controls="product-description"
                        aria-selected="true">
                        <?php echo e(__('Description')); ?>

                    </a>
                    <?php if(EcommerceHelper::isReviewEnabled()): ?>
                        <a class="nav-link"
                            id="product-reviews-tab"
                            data-bs-toggle="pill"
                            href="#product-reviews"
                            type="button"
                            role="tab"
                            aria-controls="product-reviews"
                            aria-selected="false">
                            <?php echo e(__('Reviews')); ?> (<?php echo e($product->a); ?>)
                        </a>
                    <?php endif; ?>
                    <?php if(is_plugin_active('marketplace') && $product->store_id): ?>
                        <a class="nav-link"
                            id="product-vendor-info-tab"
                            data-bs-toggle="pill"
                            href="#product-vendor-info"
                            type="button"
                            role="tab"
                            aria-controls="product-vendor-info"
                            aria-selected="false">
                            <?php echo e(__('Vendor Info')); ?>

                        </a>
                    <?php endif; ?>
                    <?php if(is_plugin_active('faq') && count($product->faq_items) > 0): ?>
                        <a class="nav-link"
                            id="product-faqs-tab"
                            data-bs-toggle="pill"
                            href="#product-faqs"
                            type="button"
                            role="tab"
                            aria-controls="product-faqs"
                            aria-selected="false">
                            <?php echo e(__('Questions & Answers')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="product-detail-tabs-content">
                    <div class="tab-pane fade show active" id="product-description" role="tabpanel"
                        aria-labelledby="product-description-tab">
                        <?php echo BaseHelper::clean($product->content); ?>


                        <?php if(theme_option('facebook_comment_enabled_in_product', 'yes') == 'yes'): ?>
                            <br />
                            <?php echo apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')); ?>

                        <?php endif; ?>
                    </div>
                    <?php if(EcommerceHelper::isReviewEnabled()): ?>
                        <div class="tab-pane fade" id="product-reviews" role="tabpanel"
                            aria-labelledby="product-reviews-tab">
                            <div class="product-panel-reviews">
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-average-rating">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <div class="average-rating border py-4 px-4">
                                                    <h3 class="h1 average-value text-red"><?php echo e(number_format($product->reviews_avg ?: 0, 2)); ?></h3>
                                                    <div class="product-rating border-bottom pb-3">
                                                        <?php echo Theme::partial('star-rating', ['avg' => $product->reviews_avg, 'count' => $product->reviews_count]); ?>

                                                    </div>
                                                    <div class="bar-rating pt-3">
                                                        <?php $__currentLoopData = EcommerceHelper::getReviewsGroupedByProductId($product->id, $product->reviews_count); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="star-item <?php if(!$item['count']): ?> disabled <?php endif; ?>">
                                                                <span class="slabel"><?php echo e(__(':number Stars', ['number' => $item['star']])); ?></span>
                                                                <div class="progress">
                                                                    <div class="progress-bar"
                                                                        role="progressbar"
                                                                        aria-valuenow="<?php echo e($item['percent']); ?>"
                                                                        aria-valuemin="0"
                                                                        aria-valuemax="100"
                                                                        style="width: <?php echo e($item['percent']); ?>%"></div>
                                                                </div>
                                                                <span class="svalue"><?php echo e($item['percent']); ?> %</span>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-review-form">
                                        <div id="review-form-wrapper">
                                            <div id="review-form">
                                                <div class="comment-respond">
                                                    <h5 class="comment-reply-title text-uppercase"><?php echo e(__('Add your review')); ?></h5>
                                                    <div class="comment-notes">
                                                        <span><?php echo e(__('Your email address will not be published.')); ?></span> <?php echo e(__('Required fields are marked')); ?>

                                                        <span class="required"></span>
                                                    </div>
                                                    <?php echo Form::open([
                                                        'route'  => 'public.reviews.create',
                                                        'method' => 'POST',
                                                        'class'  => 'form-review-product',
                                                        'files'  => true,
                                                    ]); ?>

                                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                                        <div class="row">
                                                            <div class="col-12 mb-3 d-flex mt-2">
                                                                <label class="required" for="rating"><?php echo e(__('Your rating')); ?>:</label>
                                                                <div class="form-rating-stars ms-2">
                                                                    <?php for($i = 5; $i >= 1; $i--): ?>
                                                                        <input class="btn-check" type="radio" id="rating-star-<?php echo e($i); ?>" name="star" value="<?php echo e($i); ?>">
                                                                        <label for="rating-star-<?php echo e($i); ?>" title="<?php echo e($i); ?> stars">
                                                                            <span class="svg-icon">
                                                                                <svg>
                                                                                    <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                                                                                </svg>
                                                                            </span>
                                                                        </label>
                                                                    <?php endfor; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="required" for="txt-comment"><?php echo e(__('Review')); ?>:</label>
                                                                <textarea class="form-control" name="comment" id="txt-comment" required aria-required="true"
                                                                    rows="8" placeholder="<?php echo e(__('Write your review')); ?>"></textarea>
                                                            </div>
                                                            <div class="col-12 mb-3 form-group">
                                                                <script type="text/x-custom-template" id="review-image-template">
                                                                    <span class="image-viewer__item" data-id="__id__">
                                                                        <img src="<?php echo e(RvMedia::getDefaultImage()); ?>" alt="Preview" class="img-responsive d-block">
                                                                        <span class="image-viewer__icon-remove">
                                                                            <i class="icon-cross-circle"></i>
                                                                        </span>
                                                                    </span>
                                                                </script>
                                                                <div class="image-upload__viewer d-flex">
                                                                    <div class="image-viewer__list position-relative">
                                                                        <div class="image-upload__uploader-container">
                                                                            <div class="d-table">
                                                                                <div class="image-upload__uploader">
                                                                                    <i class="icon-file-image image-upload__icon"></i>
                                                                                    <div class="image-upload__text"><?php echo e(__('Upload photos')); ?></div>
                                                                                    <input type="file"
                                                                                        name="images[]"
                                                                                        data-max-files="<?php echo e(EcommerceHelper::reviewMaxFileNumber()); ?>"
                                                                                        class="image-upload__file-input"
                                                                                        accept="image/png,image/jpeg,image/jpg"
                                                                                        multiple="multiple"
                                                                                        data-max-size="<?php echo e(EcommerceHelper::reviewMaxFileSize(true)); ?>"
                                                                                        data-max-size-message="<?php echo e(trans('validation.max.file', ['attribute' => '__attribute__', 'max' => '__max__'])); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="loading">
                                                                            <div class="half-circle-spinner">
                                                                                <div class="circle circle-1"></div>
                                                                                <div class="circle circle-2"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="help-block">
                                                                    <?php echo e(__('You can upload up to :total photos, each photo maximum size is :max kilobytes', [
                                                                            'total' => EcommerceHelper::reviewMaxFileNumber(),
                                                                            'max'   => EcommerceHelper::reviewMaxFileSize(true),
                                                                        ])); ?>

                                                                </div>

                                                            </div>
                                                            <div class="col-12 form-submit">
                                                                <button class="btn btn-primary" type="submit" <?php if(!auth('customer')->check()): ?> disabled <?php endif; ?>>
                                                                    <span class="svg-icon">
                                                                        <svg>
                                                                            <use href="#svg-icon-send" xlink:href="#svg-icon-send"></use>
                                                                        </svg>
                                                                    </span>
                                                                    <span><?php echo e(__('Submit Review')); ?></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(count($product->review_images)): ?>
                                    <div class="my-3">
                                        <h4><?php echo e(__('Images from customer (:count)', ['count' => count($product->review_images)])); ?></h4>
                                        <div class="review-images row m-0 g-0 review-images-total">
                                            <?php $__currentLoopData = $product->review_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(RvMedia::getImageUrl($img)); ?>" class="col-lg-1 col-sm-2 col-3 more-review-images <?php if($loop->iteration > 12): ?> d-none <?php endif; ?>">
                                                    <div class="border position-relative rounded">
                                                        <img src="<?php echo e(RvMedia::getImageUrl($img, 'thumb')); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid rounded h-100">
                                                        <?php if($loop->iteration == 12 && (count($product->review_images) - $loop->iteration > 0)): ?>
                                                            <span>+<?php echo e(count($product->review_images) - $loop->iteration); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($product->reviews_count): ?>
                                    <div class="product-reviews-container my-5">
                                        <h3 class="h5 my-4 fw-bold product-reviews-header">
                                            <?php echo e(__(':total review(s) for ":product"', [
                                                'total'   => $product->reviews_count,
                                                'product' => $product->name,
                                            ])); ?>

                                        </h3>
                                        <product-reviews-component url="<?php echo e(route('public.ajax.product-reviews', $product->id)); ?>"></product-reviews-component>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(is_plugin_active('marketplace') && $product->store_id): ?>
                        <div class="tab-pane fade" id="product-vendor-info" role="tabpanel"
                            aria-labelledby="product-vendor-info-tab">
                            <?php echo $__env->make(Theme::getThemeNamespace() . '::views.marketplace.includes.info-box', ['store' => $product->store], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(is_plugin_active('faq') && count($product->faq_items) > 0): ?>
                        <div class="tab-pane fade" id="product-faqs" role="tabpanel" aria-labelledby="product-faqs-tab">
                            <div class="accordion" id="faq-accordion">
                                <?php $__currentLoopData = $product->faq_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card">
                                        <div class="card-header" id="heading-faq-<?php echo e($loop->index); ?>">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-start <?php if(!$loop->first): ?> collapsed <?php endif; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-<?php echo e($loop->index); ?>" aria-expanded="true" aria-controls="collapse-faq-<?php echo e($loop->index); ?>">
                                                    <?php echo BaseHelper::clean($faq[0]['value']); ?>

                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse-faq-<?php echo e($loop->index); ?>" class="collapse <?php if($loop->first): ?> show <?php endif; ?>" aria-labelledby="heading-faq-<?php echo e($loop->index); ?>" data-bs-parent="#faq-accordion">
                                            <div class="card-body">
                                                <?php echo BaseHelper::clean($faq[1]['value']); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widget-products-with-category py-5 bg-light">
    <div class="container-xxxl">
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center mb-2 widget-header">
                    <h2 class="col-auto mb-0 py-2"><?php echo e(__('Related products')); ?></h2>
                </div>
                <related-products-component
                    limit="6"
                    url="<?php echo e(route('public.ajax.related-products', $product->id)); ?>"
                    slick_config="<?php echo e(json_encode([
                        'rtl' => BaseHelper::siteLanguageDirection() == 'rtl',
                        'appendArrows' => '.arrows-wrapper',
                        'arrows' => true,
                        'dots' => false,
                        'autoplay' => false,
                        'infinite' => false,
                        'autoplaySpeed' => 3000,
                        'speed' => 800,
                        'slidesToShow' => 6,
                        'slidesToScroll' => 1,
                        'swipeToSlide' => true,
                        'responsive' => [
                            [
                                'breakpoint' => 1400,
                                'settings' => [
                                    'slidesToShow' => 5,
                                ],
                            ],
                            [
                                'breakpoint' => 1199,
                                'settings' => [
                                    'slidesToShow' => 4,
                                ],
                            ],
                            [
                                'breakpoint' => 1024,
                                'settings' => [
                                    'slidesToShow' => 3,
                                ],
                            ],
                            [
                                'breakpoint' => 767,
                                'settings' => [
                                    'arrows' => true,
                                    'dots' => false,
                                    'slidesToShow' => 2,
                                    'slidesToScroll' => 2,
                                ],
                            ],
                        ],
                    ])); ?>"
                ></related-products-component>
            </div>
        </div>
    </div>
</div>

<!-- add-to-cart sticky bar -->
<div id="sticky-add-to-cart">
    <header class="header--product js-product-content">
        <nav class="navigation">
            <div class="container">
                <article class="ps-product--header-sticky">
                    <div class="ps-product__thumbnail">
                    </div>

                        <div class="ps-product__shopping">
                            <?php echo Theme::partial('ecommerce.product-price', compact('product')); ?>

                            <?php if(EcommerceHelper::isCartEnabled()): ?>
                                <button type="button" name="add_to_cart" value="1" class="btn btn-primary ms-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>" <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?> title="<?php echo e(__('Add to cart')); ?>">
                                    <span class="svg-icon">
                                        <svg>
                                            <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                        </svg>
                                    </span>
                                    <span class="add-to-cart-text ms-1"><?php echo e(__('Add to cart')); ?></span>
                                </button>
                                <?php if(EcommerceHelper::isQuickBuyButtonEnabled()): ?>
                                    <button type="button" name="checkout" value="1" class="btn btn-primary btn-black ms-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>" <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?> title="<?php echo e(__('Buy Now')); ?>">
                                        <span class="add-to-cart-text"><?php echo e(__('Buy Now')); ?></span>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        </nav>
    </header>

    <div class="sticky-atc-wrap sticky-atc-shown">
        <div class="container">
            <div class="row">
                <div class="sticky-atc-btn product-button">
                    <?php if(EcommerceHelper::isCartEnabled()): ?>
                        <button type="button" name="add_to_cart" value="1" class="btn btn-primary mb-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>" <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?> title="<?php echo e(__('Add to cart')); ?>">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                </svg>
                            </span>
                            <span class="add-to-cart-text ms-1"><?php echo e(__('Add to cart')); ?></span>
                        </button>

                        <?php if(EcommerceHelper::isQuickBuyButtonEnabled()): ?>
                            <button type="button" name="checkout" value="1" class="btn btn-primary btn-black mb-2 ms-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>" <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?> title="<?php echo e(__('Buy Now')); ?>">
                                <span class="add-to-cart-text ms-2"><?php echo e(__('Buy Now')); ?></span>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end add-to-cart sticky bar -->
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/views/ecommerce/product.blade.php ENDPATH**/ ?>