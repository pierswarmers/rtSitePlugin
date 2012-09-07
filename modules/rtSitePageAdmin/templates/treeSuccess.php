<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Site Page Structure') ?></h1>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('object' => new rtSitePage))?>
<?php end_slot(); ?>

<?php echo get_tree_manager("rtSitePage", "title"); ?>