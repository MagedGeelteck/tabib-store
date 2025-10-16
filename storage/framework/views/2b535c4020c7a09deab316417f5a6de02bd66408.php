<?php if(is_plugin_active('ads')): ?>
    <?php if($image = display_ads_advanced($config['ads_key'], ['class' => 'd-flex justify-content-center'])): ?>
        <div class="lazyload" <?php if($config['background']): ?> data-bg="<?php echo e(RvMedia::getImageUrl($config['background'])); ?>" <?php endif; ?>>
            <?php
                $size = 'xxxl'; //full-with
                switch ($config['size']) {
                    case 'large':
                        $size = 'xxl';
                        break;
                    case 'medium':
                        $size = 'lg';
                        break;
                }
            ?>
            <div class="container-<?php echo e($size); ?>">
                <div class="row">
                    <div class="my-5">
                        <?php echo BaseHelper::clean($image); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/////widgets/ads/templates/frontend.blade.php ENDPATH**/ ?>