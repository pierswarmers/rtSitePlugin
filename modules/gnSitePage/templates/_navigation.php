<?php

use_helper('I18N', 'Date', 'gnText', 'gnForm', 'gnDate', 'gnSite');

$options = isset($options) ? $options->getRawValue() : array();
$gn_site_page = isset($gn_site_page) ? $gn_site_page : null;
$render_full = isset($render_full) ? $render_full : false;

?>

<?php echo gn_site_page_map($gn_site_page, $render_full, $options) ?>

<?php //echo gn_site_page_map(isset($gn_site_page) ? $gn_site_page : null, false, array('limit_lower' => 2, 'include_root' => false)) ?>