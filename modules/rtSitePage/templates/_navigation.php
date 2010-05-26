<?php

use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite');

$options = isset($options) ? $options->getRawValue() : array();
$rt_site_page = isset($rt_site_page) ? $rt_site_page : null;
$render_full = isset($render_full) ? $render_full : false;

?>

<?php echo rt_site_page_map($rt_site_page, $render_full, $options) ?>

<?php //echo rt_site_page_map(isset($rt_site_page) ? $rt_site_page : null, false, array('limit_lower' => 2, 'include_root' => false)) ?>