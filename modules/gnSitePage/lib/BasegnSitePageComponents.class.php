<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasegnSitePageComponents
 *
 * @package    gnSitePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasegnSitePageComponents extends sfComponents
{
  public function executeNavigation(sfWebRequest $request)
  {
    $module = $request->getParameter('module');
    $action = $request->getParameter('action');

    if($module === 'gnSitePage' && ($action === 'show' || $action === 'index'))
    {
      if($action === 'index')
      {
        $gn_site_page = Doctrine::getTable('gnSitePage')->findRoot();
      }
      else
      {
        $gn_site_page = Doctrine::getTable('gnSitePage')->findOnePublishedById($request->getParameter('id'));
      }
      if($gn_site_page)
      {
        $this->gn_site_page = $gn_site_page;
      }
    }
  }
}

