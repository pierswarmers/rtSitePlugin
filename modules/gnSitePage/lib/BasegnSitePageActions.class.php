<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasegnSitePageActions
 *
 * @package    gnSitePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasegnSitePageActions extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   *
   * By default, this method is empty.
   */
  public function preExecute()
  {
    sfConfig::set('app_gn_node_title', 'Site');
    gnTemplateToolkit::setFrontendTemplateDir();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->gn_site_page = $this->getRoute()->getObject();
    
    $this->forward404Unless($this->gn_site_page);

    if(!$this->gn_site_page->isPublished() && !$this->isAdmin())
    {
      $this->forward404('Page isn\'t published.');
    }

    $this->updateResponse($this->gn_site_page);
  }

  private function updateResponse(gnSitePage $page)
  {
    gnResponseToolkit::setCommonMetasFromPage($page, $this->getUser(), $this->getResponse());
  }

  private function isAdmin()
  {
    return $this->getUser()->hasCredential(sfConfig::get('app_gn_site_admin_credential', 'admin_site'));
  }
}