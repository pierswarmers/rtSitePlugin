<?php

use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite');

$options  = isset($options) ? $options->getRawValue() : array();
$options['include_root'] = isset($options['include_root']) ? $options['include_root'] : false;

// Get root
$root_page = Doctrine::getTable('rtSitePage')->findRoot();

if(!$root_page)
{
  return;
}

// Get tree
$table = Doctrine::getTable('rtSitePage');
$query = $table->getQuery();
$query = $table->addPublishedQuery($query);
$query->andWhere('page.display_in_menu = 1');
$query->andWhere('page.level <= ?', 1);
$query->andWhere('page.level >= ?', 0);
$tree = Doctrine::getTable('rtSitePage')->getDescendantsOfRoot($root_page, $query, false);

?>

<form action="/" method="post">
  <select class="rt-site-page-navigation-dropdown">
    
    <option value="-">Navigate Site &rarr;</option>

    <optgroup label="General Pages">

    <?php if($options['include_root']): ?>
      <?php 
        $display_name = (!is_null($root_page->getMenuTitle()) && trim($root_page->getMenuTitle()) !== '') ? $root_page->getMenuTitle() : $root_page->getTitle(); 
        $is_current = ($rt_site_page && $root_page->getId() == $rt_site_page->getId()) ? true : false;
      ?>
      <option value="<?php echo url_for('rt_site_page_show', $root_page); ?>"><?php echo $display_name ?></option>
    <?php endif; ?>
        
    <?php if($tree): ?>
      <?php foreach($tree as $page): ?>
        <?php 
          $display_name = (!is_null($page->getMenuTitle()) && trim($page->getMenuTitle()) !== '') ? $page->getMenuTitle() : $page->getTitle(); 
          $is_current = ($rt_site_page && $page->getId() == $rt_site_page->getId()) ? true : false;
        ?>
        <option value="<?php echo url_for('rt_site_page_show', $page); ?>"><?php echo $display_name ?></option>
      <?php endforeach; ?>          
    <?php endif; ?>
      
    </optgroup>

<?php


// Get root
$root_page = Doctrine::getTable('rtShopCategory')->findRoot();

if(!$root_page)
{
  return;
}

// Get tree
$table = Doctrine::getTable('rtShopCategory');
$query = $table->getQuery();
$query = $table->addPublishedQuery($query);
$query->andWhere('page.display_in_menu = 1');
$query->andWhere('page.level <= ?', 1);
$query->andWhere('page.level >= ?', 0);
$tree = Doctrine::getTable('rtShopCategory')->getDescendantsOfRoot($root_page, $query, false);

?>
    
    <optgroup label="Product Categories">
    <?php if($options['include_root']): ?>
      <?php
        $display_name = (!is_null($root_page->getMenuTitle()) && trim($root_page->getMenuTitle()) !== '') ? $root_page->getMenuTitle() : $root_page->getTitle();
        $is_current = ($rt_site_page && $root_page->getId() == $rt_site_page->getId()) ? true : false;
      ?>
      <option value="<?php echo url_for('rt_shop_category_show', $root_page); ?>"><?php echo $display_name ?></option>
    <?php endif; ?>

    <?php if($tree): ?>
      <?php foreach($tree as $page): ?>
        <?php
          $display_name = (!is_null($page->getMenuTitle()) && trim($page->getMenuTitle()) !== '') ? $page->getMenuTitle() : $page->getTitle();
          $is_current = ($rt_site_page && $page->getId() == $rt_site_page->getId()) ? true : false;
        ?>
        <option value="<?php echo url_for('rt_shop_category_show', $page); ?>"><?php echo $display_name ?></option>
      <?php endforeach; ?>
    <?php endif; ?>
    </optgroup>
    
  </select>
</form>

<script type="text/javascript"> 
  $(function() {
    
    $(".rt-site-page-navigation-dropdown").change(function() {
      if($(this).val() != '-')
      {
        window.location.href = $(this).val();
      }
    });    
    
  });
</script> 