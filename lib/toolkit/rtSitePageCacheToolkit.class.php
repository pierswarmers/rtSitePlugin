<?php

/*
 * This file is part of the steercms package.
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtAssetToolkit provides a generic set of file system tools.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtSitePageCacheToolkit
{
  public static function clearCache($rt_site_page = null)
  {
    $cache = sfContext::getInstance()->getViewCacheManager();
    
    if ($cache)
    {
      rtGlobalCacheToolkit::clearCache();
      
      $cache->remove('rtSitePage/index');

      $file_cache = new sfFileCache(
      array( 'cache_dir' => sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'frontend' ) );
      $file_cache->removePattern('**/rtSitePage/_navigation/*');

      $cache->remove('@sf_cache_partial?module=rtSitePage&action=_navigation&sf_cache_key=*');
      $cache->remove('@sf_cache_partial?module=rtSitePage&action=_navigation&sf_cache_key=40cd750bba9870f18aada2478b24840a');
      $cache->remove('rtSitePage/_navigation?module=rtSitePage&action=*&sf_cache_key=*');

      if(!is_null($rt_site_page))
      {
        $cache->remove(sprintf('rtSitePage/show?id=%s&slug=%s', $rt_site_page->getId(), $rt_site_page->getSlug())); // show page
        $cache->remove('@sf_cache_partial?module=rtSitePage&action=_site_page&sf_cache_key='.$rt_site_page->getId()); // show page partial.
      }
    }
  }
}