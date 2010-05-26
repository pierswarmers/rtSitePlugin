<?php

/*
 * This file is part of the steercms package.
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnAssetToolkit provides a generic set of file system tools.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnSitePageCacheToolkit
{
  public static function clearCache($gn_site_page = null)
  {
    $cache = sfContext::getInstance()->getViewCacheManager();
    
    if ($cache)
    {
      $cache->remove('gnSitePage/index');

      $file_cache = new sfFileCache(
      array( 'cache_dir' => sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'frontend' ) );
      $file_cache->removePattern('**/gnSitePage/_navigation/*');

      $cache->remove('@sf_cache_partial?module=gnSitePage&action=_navigation&sf_cache_key=*');
      $cache->remove('@sf_cache_partial?module=gnSitePage&action=_navigation&sf_cache_key=40cd750bba9870f18aada2478b24840a');
      $cache->remove('gnSitePage/_navigation?module=gnSitePage&action=*&sf_cache_key=*');

      if(!is_null($gn_site_page))
      {
        $cache->remove(sprintf('gnSitePage/show?id=%s&slug=%s', $gn_site_page->getId(), $gn_site_page->getSlug())); // show page
        $cache->remove('@sf_cache_partial?module=gnSitePage&action=_blog_page&sf_cache_key='.$gn_site_page->getId()); // show page partial.
      }
    }
  }
}