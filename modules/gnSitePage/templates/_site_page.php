<h1><?php echo $gn_site_page->getTitle() ?></h1>

<div class="gn-page-content clearfix">
<?php echo markdown_to_html($gn_site_page->getContent(), $gn_site_page); ?>
</div>