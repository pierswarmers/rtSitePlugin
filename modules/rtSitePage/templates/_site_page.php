<?php use_helper('rtText') ?>
<?php slot('rt-title') ?>
<?php echo $rt_site_page->getTitle() ?>
<?php end_slot(); ?>

<?php echo markdown_to_html($rt_site_page->getContent(), $rt_site_page); ?>