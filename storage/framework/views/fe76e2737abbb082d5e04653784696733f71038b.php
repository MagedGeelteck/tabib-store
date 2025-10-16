<?php echo SeoHelper::render(); ?>


<?php if($favicon = theme_option('favicon')): ?>
    <link rel="shortcut icon" href="<?php echo e(RvMedia::getImageUrl($favicon)); ?>">
<?php endif; ?>

<?php if(Theme::has('headerMeta')): ?>
    <?php echo Theme::get('headerMeta'); ?>

<?php endif; ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "<?php echo e(rescue(fn() => SeoHelper::openGraph()->getProperty('site_name'))); ?>",
  "url": "<?php echo e(url('')); ?>"
}
</script>

<?php echo Theme::asset()->styles(); ?>

<?php echo Theme::asset()->container('after_header')->styles(); ?>

<?php echo Theme::asset()->container('header')->scripts(); ?>


<?php echo apply_filters(THEME_FRONT_HEADER, null); ?>


<script>
    window.siteUrl = "<?php echo e(route('public.index')); ?>";
</script>
<?php /**PATH /home/tabibj5/public_html/platform/packages/theme/resources/views/partials/header.blade.php ENDPATH**/ ?>