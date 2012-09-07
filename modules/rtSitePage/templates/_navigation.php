<?php

use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite');

$options = isset($options) ? $options->getRawValue() : array();
$rt_site_page = isset($rt_site_page) ? $rt_site_page : null;

?>

<?php echo rt_site_page_map($rt_site_page, $options) ?>
