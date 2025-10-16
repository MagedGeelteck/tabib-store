<div class="col-xl-3">
    <?php if(is_plugin_active('newsletter')): ?>
        <div class="widget mb-5">
            <h4 class="fw-bold widget-title mb-4"><?php echo BaseHelper::clean($config['title']); ?></h4>
            <div class="widget-description pb-3 mb-4"><?php echo BaseHelper::clean($config['subtitle']); ?></div>
            <div class="form-widget">
                <form class="subscribe-form" method="POST" action="<?php echo e(route('public.newsletter.subscribe')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-fields">
                        <div class="input-group">
                            <div class="input-group-text">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-mail" xlink:href="#svg-icon-mail"></use>
                                </svg>
                            </span>
                            </div>
                            <input class="form-control shadow-none" name="email" type="email" placeholder="<?php echo e(__('Your email...')); ?>">
                            <button class="btn btn-outline-secondary" type="submit"><?php echo e(__('Subscribe')); ?></button>
                        </div>
                        <?php if(setting('enable_captcha') && is_plugin_active('captcha')): ?>
                            <div class="form-group">
                                <?php echo Captcha::display(); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/////widgets/newsletter/templates/frontend.blade.php ENDPATH**/ ?>