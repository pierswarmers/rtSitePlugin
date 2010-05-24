<?php

/**
 * gnSitePageAdmin actions.
 *
 * @package    symfony
 * @subpackage gnSitePageAdmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gnSitePageAdminActions extends sfActions
{
  private $_gn_site_page;

  public function getGnSitePage(sfWebRequest $request)
  {
    $this->forward404Unless($gn_site_page = Doctrine::getTable('gnSitePage')->find(array($request->getParameter('id'))), sprintf('Object gn_site_page does not exist (%s).', $request->getParameter('id')));
    return $gn_site_page;
  }

  public function preExecute()
  {
    gnTemplateToolkit::setTemplateForMode('backend');
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('gnSitePage')->addSiteQuery();
    $query->orderBy('page.root_id ASC, page.lft ASC');
    $this->gn_site_pages = $query->execute();
  }

  public function executeTree(sfWebRequest $request)
  {
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->getUser()->setFlash('notice', 'Please select the tree to create the page in.');
    $this->redirect('gnSitePageAdmin/tree');
    $this->form = new gnSitePageForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new gnSitePageForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $gn_site_page = $this->getGnSitePage($request);
    $this->form = new gnSitePageForm($gn_site_page);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $gn_site_page = $this->getGnSitePage($request);
    $this->form = new gnSitePageForm($gn_site_page);

    $this->processForm($request, $this->form);
    $this->clearCache($gn_site_page);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $gn_site_page = $this->getGnSitePage($request);
    $this->clearCache($gn_site_page);
    $gn_site_page->getNode()->delete();

    $this->redirect('gnSitePageAdmin/index');
  }
  
  public function executeVersions(sfWebRequest $request)
  {
    $this->gn_site_page = $this->getGnSitePage($request);
    $this->gn_site_page_versions = Doctrine::getTable('gnSitePageVersion')->findById($this->gn_site_page->getId());
  }

  public function executeCompare(sfWebRequest $request)
  {
    $this->gn_site_page = $this->getGnSitePage($request);
    $this->current_version = $this->gn_site_page->version;

    if(!$request->hasParameter('version1') || !$request->hasParameter('version2'))
    {
      $this->getUser()->setFlash('error', 'Please select two versions to compare.', false);
      $this->redirect('gnSitePage/versions?id='.$this->gn_site_page->getId());
    }

    $this->version_1 = $request->getParameter('version1');
    $this->version_2 = $request->getParameter('version2');
    $this->versions = array();

    $this->versions[1] = array(
      'title' => $this->gn_site_page->revert($this->version_1)->title,
      'content' => $this->gn_site_page->revert($this->version_1)->content,
      'description' => $this->gn_site_page->revert($this->version_1)->description,
      'updated_at' => $this->gn_site_page->revert($this->version_1)->updated_at
    );
    $this->versions[2] = array(
      'title' => $this->gn_site_page->revert($this->version_2)->title,
      'content' => $this->gn_site_page->revert($this->version_2)->content,
      'description' => $this->gn_site_page->revert($this->version_1)->description,
      'updated_at' => $this->gn_site_page->revert($this->version_1)->updated_at
    );
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $gn_site_page = $form->save();
      $this->redirect('gnSitePageAdmin/index');
    }
  }

  public function executeRevert(sfWebRequest $request)
  {
    $this->gn_site_page = $this->getGnSitePage($request);
    $this->gn_site_page->revert($request->getParameter('revert_to'));
    $this->gn_site_page->save();
    $this->getUser()->setFlash('notice', 'Reverted to version ' . $request->getParameter('revert_to'), false);
    $this->clearCache($this->gn_site_page);
    $this->redirect('gnSitePageAdmin/edit?id='.$this->gn_site_page->getId());
  }

  private function clearCache($gn_site_page)
  {
    $cache = $this->getContext()->getViewCacheManager();
    if ($cache)
    {
      $cache->remove('gnSitePage/index?sf_format=*');
      $cache->remove(sprintf('gnSitePage/show?id=%s&slug=%s', $gn_site_page->getId(), $gn_site_page->getSlug()));
      $cache->remove('@sf_cache_partial?module=gnSitePage&action=_site_page&sf_cache_key='.$gn_site_page->getId());
    }
  }
}
