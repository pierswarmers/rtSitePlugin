<h1><?php echo $rt_site_page->getTitle() ?></h1>
<div class="rt-container">
  <?php echo markdown_to_html($rt_site_page->getContent(), $rt_site_page); ?>
</div>