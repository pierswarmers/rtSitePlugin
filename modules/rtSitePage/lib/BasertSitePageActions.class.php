<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSitePageActions
 *
 * @package    rtSitePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSitePageActions extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   *
   * By default, this method is empty.
   */
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Site');
    rtTemplateToolkit::setFrontendTemplateDir();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->rt_site_page = Doctrine::getTable('rtSitePage')->findRoot();
    $this->forward404Unless($this->rt_site_page);
    $this->updateResponse($this->rt_site_page);
    $this->setTemplate('show');
  }

  public function executeShowHandler(sfWebRequest $request)
  {
    rtSiteToolkit::siteRedirect($this->getGnSitePage($request));
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->rt_site_page = $this->getRoute()->getObject();
    
    $this->forward404Unless($this->rt_site_page);

    rtSiteToolkit::checkSiteReference($this->rt_site_page);

    $this->handleLinks($this->rt_site_page);

    if($this->rt_site_page->getNode()->isRoot())
    {
      $this->redirect('rt_site_page_index');
    }

    if(!$this->rt_site_page->isPublished() && !$this->isAdmin())
    {
      $this->forward404('Page isn\'t published.');
    }

    $this->updateResponse($this->rt_site_page);
  }

  private function updateResponse(rtSitePage $page)
  {
    rtResponseToolkit::setCommonMetasFromPage($page, $this->getUser(), $this->getResponse());
  }

  private function isAdmin()
  {
    return $this->getUser()->hasCredential(sfConfig::get('app_rt_site_admin_credential', 'admin_site'));
  }

  private function handleLinks(rtSitePage $rt_site_page)
  {
    $pattern = sprintf(sfValidatorUrl::REGEX_URL_FORMAT, implode('|', array('http', 'https', 'ftp', 'ftps')));
    $text = trim($rt_site_page->getContent());
    if(preg_match($pattern, $text) > 0 || substr($text,0,1) == '/')
    {
      $this->redirect($text);
    }
  }
}