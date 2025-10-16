<?php
    $supportedLocales = Language::getSupportedLocales();
    if (empty($options)) {
        $options = [
            'before'    => '',
            'lang_flag'  => true,
            'lang_name' => true,
            'class'     => '',
            'after'     => '',
        ];
    }
?>

<?php if($supportedLocales && count($supportedLocales) > 1): ?>
    <?php
        $languageDisplay = setting('language_display', 'all');
    ?>
    <?php if(setting('language_switcher_display', 'dropdown') == 'dropdown'): ?>
        <li>
            <?php echo Arr::get($options, 'before'); ?>

            <span class="language-dropdown-active">
        <?php $__currentLoopData = $supportedLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($localeCode != Language::getCurrentLocale()): ?>
                    <a href="<?php echo e(Language::getSwitcherUrl($localeCode, $properties['lang_code'])); ?>">
                        <?php if(Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag')): ?>
                            <?php echo language_flag($properties['lang_flag'], $properties['lang_name']); ?>

                        <?php endif; ?>
                        <?php if(Arr::get($options, 'lang_name', true) && ($languageDisplay == 'all' || $languageDisplay == 'name')): ?>
                            <span class="text-dark"><?php echo e($properties['lang_name']); ?></span>
                        <?php endif; ?>
                    </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </span>
        </li>
    
<?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/tabibj5/public_html/platform/themes/farmart/partials/language-switcher.blade.php ENDPATH**/ ?>