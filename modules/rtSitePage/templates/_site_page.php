<?php

/** @var rtSitePage $rt_site_page */

use_helper('I18N', 'Date', 'rtText')

?>

<div class="rt-section rt-site-page">

  <!--RTAS
  <div class="rt-section-tools-header rt-admin-tools">
    <?php echo link_to(__('Edit Page'), 'rtSitePageAdmin/edit?id='.$rt_site_page->getId(), array('class' => 'rt-admin-edit-tools-trigger')) ?>
  </div>
  RTAS-->

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo $rt_site_page->getTitle() ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">
    <?php echo markdown_to_html($rt_site_page->getContent(), $rt_site_page); ?>
  </div>

</div>