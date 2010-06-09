<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite') ?>
<div class="rt-site-page-show rt-admin-edit-tools-panel">
  <?php echo link_to(__('Edit'), 'rtSitePageAdmin/edit?id='.$rt_site_page->getId(), array('class' => 'rt-admin-edit-tools-trigger')) ?>
  <?php include_partial('site_page', array('rt_site_page' => $rt_site_page, 'sf_cache_key' => $rt_site_page->getId())) ?>
  <dl class="rt-meta-data">
    <dt><?php echo __('Created') ?>:</dt>
    <dd><?php echo time_ago_in_words_abbr($rt_site_page->getCreatedAt(), $sf_user->getCulture()) ?></dd>
    <dt><?php echo __('Updated') ?>:</dt>
    <dd><?php echo time_ago_in_words_abbr($rt_site_page->getUpdatedAt(), $sf_user->getCulture()) ?></dd>
    <dt><?php echo __('Version') ?>:</dt>
    <dd><?php echo $rt_site_page->version ?></dd>
  </dl>
</div>