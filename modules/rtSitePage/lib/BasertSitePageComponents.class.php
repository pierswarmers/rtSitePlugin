<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSitePageComponents
 *
 * @package    rtSitePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSitePageComponents extends sfComponents
{
  /**
   * Return site navigation as unordered list
   * 
   * @param sfWebRequest $request
   */
  public function executeNavigation(sfWebRequest $request)
  {
    $module = $request->getParameter('module');
    $action = $request->getParameter('action');

    if($module === 'rtSitePage' && ($action === 'show' || $action === 'index'))
    {
      if($action === 'index')
      {
        $rt_site_page = Doctrine::getTable('rtSitePage')->findRoot();
      }
      else
      {
        $rt_site_page = Doctrine::getTable('rtSitePage')->findOnePublishedById($request->getParameter('id'));
      }
      if($rt_site_page)
      {
        $this->rt_site_page = $rt_site_page;
      }
    }
  }
  
  /**
   * Return site navigation as dropdown list
   * 
   * @param sfWebRequest $request
   */  
  public function executeNavigationDropdown(sfWebRequest $request)
  {
    $module = $request->getParameter('module');
    $action = $request->getParameter('action');

    if($module === 'rtSitePage' && ($action === 'show' || $action === 'index'))
    {
      if($action === 'index')
      {
        $rt_site_page = Doctrine::getTable('rtSitePage')->findRoot();
      }
      else
      {
        $rt_site_page = Doctrine::getTable('rtSitePage')->findOnePublishedById($request->getParameter('id'));
      }
      if($rt_site_page)
      {
        $this->rt_site_page = $rt_site_page;
      }
    }
  }
}

