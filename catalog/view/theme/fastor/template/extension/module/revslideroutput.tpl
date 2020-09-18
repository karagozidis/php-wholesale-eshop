<?php $config = $registry->get('config'); ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/css/slider.css" property='stylesheet' />

<script type="text/javascript" src="system/config/revslider/public/assets/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="system/config/revslider/public/assets/js/jquery.themepunch.revolution.min.js"></script>
<?php echo $rev_content; ?>

<?php if($slider_align_top == 1) { ?>
<script type="text/javascript">
     $('body').addClass('slider-align-top');
</script>
<?php } ?>