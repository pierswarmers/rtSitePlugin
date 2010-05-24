<?php use_helper('I18N', 'Date', 'gnText', 'gnForm', 'gnDate', 'gnSite') ?>

<?php echo gn_site_page_map(isset($gn_site_page) ? $gn_site_page : null) ?>

<?php //echo gn_site_page_map(isset($gn_site_page) ? $gn_site_page : null, false, array('limit_lower' => 2, 'include_root' => false)) ?>