<?php
/**
 * Returns the file site map in a standard nested list.
 *
 * @param string $web_property_id
 * @return string
 */
function rt_site_page_map($rt_site_page = null, $options = array())
{
  $options['render_full'] = isset($options['render_full']) ? $options['render_full'] : false;
  $options['include_root'] = isset($options['include_root']) ? $options['include_root'] : true;
  $options['limit_lower'] = isset($options['limit_lower']) ? $options['limit_lower'] : 1;
  $options['limit_upper'] = isset($options['limit_upper']) ? $options['limit_upper'] : 100;

  $root_page = Doctrine::getTable('rtSitePage')->findRoot();

  if(!$root_page)
  {
    return '';
  }

  $string = '';

  if($options['include_root'])
  {
    $string .= rt_site_page_map_li($root_page, $rt_site_page, array('closing_tag' => ''));
  }

  $tree = Doctrine::getTable('rtSitePage')->getDescendantsOfRoot($root_page, null, true);

  if(!$options['render_full'] && !is_null($rt_site_page))
  {
    $ancestors = $rt_site_page->getNode()->getAncestors();

    $cleaned_ancestors = array();

    if($ancestors)
    {
      foreach($ancestors as $a)
      {
        $cleaned_ancestors[] = $a;
      }
    }

    $cleaned_ancestors[] = $rt_site_page;

    $cleaned_tree = array();

    foreach($tree as $page)
    {
      if(!isset($cleaned_ancestors[$page['level'] - 1]))
      {
        continue;
      }
      $parent = $cleaned_ancestors[$page['level'] - 1];
      
      if($page['lft'] > $parent['lft'] && $page['rgt'] < $parent['rgt'])
      {
        $cleaned_tree[] = $page;
      }
    }

    $tree = $cleaned_tree;
  }
  else
  {
    if(!$options['render_full'])
    {
      $options['limit_upper'] =1;
    }

    $query = Doctrine::getTable('rtSitePage')->getQuery();
    $query->andWhere('page.display_in_menu = 1');
    $query->andWhere('page.level <= ?', $options['limit_upper']);
    $query->andWhere('page.level >= ?', $options['limit_lower']);
    $tree = Doctrine::getTable('rtSitePage')->getDescendantsOfRoot($root_page, $query, true);;
  }

  $level = $options['limit_lower'];

  if($tree)
  {
    foreach($tree as $node)
    {
      if(!$node['display_in_menu'])
      {
        continue;
      }

      if(!$options['render_full'] && !is_null($rt_site_page))
      {
        if(($node['level'] < $options['limit_lower'] || $node['level'] > $options['limit_upper']))
        {
          // know your limits
          continue;
        }

        if($node['level'] > $rt_site_page['level'] + 1)
        {
          // allow for one level in from parent
          continue;
        }

        $level_scope[$level]['lft'] = 1;
        $level_scope[$level]['rgt'] = 1;
      }

      if($level < $node['level'])
      {
        $string .=  "\n" . '<ul>' . "\n";
      }
      elseif($level > $node['level'])
      {
        $string .= '</li>' . "\n";

        for($i=$level; $i>$node['level'];$i--)
        {
          $string .= '</ul></li>';
        }
      }
      else
      {
        $string .= '</li>' . "\n";
      }

      $string .= rt_site_page_map_li($node, $rt_site_page, array('closing_tag' => ''));;

      $level = $node['level'];
    }
  }

  if($level !== 1)
  {
    for($i=$level; $i>1;$i--)
    {
      $string .= '</li></ul>';
    }
  }

  $string = '<ul class="rt-site-page-navigation">' . $string . '</li></ul>';

  $string = str_replace('<ul class="rt-site-page-navigation"></li>', '<ul class="rt-site-page-navigation">', $string);

  if(trim(strip_tags($string)) == '')
  {
    return '';
  }

  return $string;
}

/**
 * Print a single 
 */
function rt_site_page_map_li($page, $selected_page = null, $options = array())
{
  $options['closing_tag'] = isset($options['closing_tag']) ? $options['closing_tag'] : '</li>';
  $options['class_here'] = isset($options['class_here']) ? $options['class_here'] : 'here';
  $options['class_in_path'] = isset($options['class_in_path']) ? $options['class_in_path'] : 'in-path';
  
  $is_in_path = false;
  $is_current = false;
  
  if(!is_null($page))
  {
    $is_current = $page['id'] == $selected_page['id'];

    if($selected_page['lft'] > $page['lft'] && $selected_page['rgt'] < $page['rgt'])
    {
      $is_in_path = true;
    }
  }

  $class = '';

  if($is_current)
  {
    $class = sprintf(' class="%s"', $options['class_here']);
  }elseif($is_in_path)
  {
    $class = sprintf(' class="%s"', $options['class_in_path']);
  }

  $title = $page['title'];
  
  if(!is_null($page['menu_title']) && trim($page['menu_title']) !== '')
  {
    $title = $page['menu_title'];
  }

  $link = '';

  if($page['level'] == 0)
  {
    $link = link_to($title, 'homepage');
  }
  else
  {
    if(!$page instanceof rtSitePage)
    {
      // Clean arrays of extra values
      $tmp_page = array();
      $tmp_page['id'] = $page['id'];
      $tmp_page['slug'] = $page['slug'];
      $page = $tmp_page;
    }

    $link = link_to($title, 'rt_site_page_show', array('slug' => $page['slug']));
  }
  
  return sprintf('<li%s>%s', $class, $link);
}