<div class="col-xl-2">
    <div class="col mb-5">
        <div class="widget widget-custom-menu">
            <h5 class="fw-bold widget-title mb-4"><?php echo BaseHelper::clean($config['name']); ?></h5>
            <?php echo Menu::generateMenu(['slug' => $config['menu_id'], 'options' => ['class' => 'ps-0'], 'view' => 'menu-default']); ?>

        </div>
    </div>
</div>

<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/////widgets/custom-menu/templates/frontend.blade.php ENDPATH**/ ?>