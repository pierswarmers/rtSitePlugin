<?php use_helper('I18N', 'Date', 'gnText', 'gnForm', 'gnDate', 'gnSite') ?>
<div class="gn-site-page-show">
  <?php include_partial('site_page', array('gn_site_page' => $gn_site_page, 'sf_cache_key' => $gn_site_page->getId())) ?>
  <dl class="gn-meta-data">
    <dt><?php echo __('Created') ?>:</dt>
    <dd><?php echo time_ago_in_words_abbr($gn_site_page->getCreatedAt(), $sf_user->getCulture()) ?></dd>
    <dt><?php echo __('Updated') ?>:</dt>
    <dd><?php echo time_ago_in_words_abbr($gn_site_page->getUpdatedAt(), $sf_user->getCulture()) ?></dd>
    <dt><?php echo __('Version') ?>:</dt>
    <dd><?php echo $gn_site_page->version ?></dd>
  </dl>
</div>