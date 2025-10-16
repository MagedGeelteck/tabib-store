<?php if(is_plugin_active('marketplace') && !auth('customer')->check()): ?>
    <div class="row g-0">
        <div class="col-12">
            <div class="fw-normal fs-6">
                <span><?php echo BaseHelper::clean($config['name'] ?: __('Become a Vendor?')); ?></span>
                <a class="text-primary ps-2" href="<?php echo e(route('customer.login')); ?>"><?php echo e(__('Register now')); ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/////widgets/become-vendor/templates/frontend.blade.php ENDPATH**/ ?>