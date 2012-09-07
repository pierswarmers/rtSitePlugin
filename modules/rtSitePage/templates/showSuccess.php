<?php

/** @var rtSitePage $rt_site_page */

use_helper('I18N','Date');

slot('rt-title', $rt_site_page->getTitle());

?>

<?php include_partial('site_page', array('rt_site_page' => $rt_site_page, 'sf_cache_key' => $rt_site_page->getId())) ?>
