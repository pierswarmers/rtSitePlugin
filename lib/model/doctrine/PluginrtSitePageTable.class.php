<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PluginrtPageTable
 *
 * @package    gumnut
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class PluginrtSitePageTable extends rtPageTable
{
  public function findRoot(Doctrine_Query $query = null, $as_array = false)
  {
    $query = $this->addSiteQuery($query);
    $query = $this->addRootQuery($query);

    if($as_array)
    {
      $result = $query->fetchArray();
      return $result[0];
    }

    return $query->fetchOne();
  }

  /**
   * Return a published page by a given ID.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Collection
   */
  public function findOnePublishedBySlug($id, Doctrine_Query $query = null)
  {
    $query = $this->addSiteQuery($query);
    $query = $this->addPublishedQuery($query);
    return $this->findOneBySlug($id);
  }

  public function getDescendantsOfRoot($root_rt_site_page, Doctrine_Query $query = null, $as_array = false)
  {
    $query = $this->getQuery($query);

    $query = $this->addPublishedQuery($query);

    if($root_rt_site_page['level'] !== '0')
    {
      throw new sfException('Delivered page must be a root level node. Got level = '.$root_rt_site_page['level']);
    }

    $query->andWhere('page.lft > ?', $root_rt_site_page['lft'])
          ->andWhere('page.rgt < ?', $root_rt_site_page['rgt'])
          ->andWhere('page.root_id = ?', $root_rt_site_page['root_id'])
          ->orderBy('page.lft ASC');

    if($as_array)
    {
      return $query->fetchArray();
    }

    return $query->execute();
  }

  /**
   * Add root definition requirements to a query.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function addRootQuery(Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query->andWhere('page.level = 0');
    return $query;
  }
}
