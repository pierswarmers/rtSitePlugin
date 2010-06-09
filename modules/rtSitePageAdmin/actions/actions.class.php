<?php

/**
 * rtSitePageAdmin actions.
 *
 * @package    symfony
 * @subpackage rtSitePageAdmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rtSitePageAdminActions extends sfActions
{
  private $_rt_site_page;

  public function getGnSitePage(sfWebRequest $request)
  {
    $this->forward404Unless($rt_site_page = Doctrine::getTable('rtSitePage')->find(array($request->getParameter('id'))), sprintf('Object rt_site_page does not exist (%s).', $request->getParameter('id')));
    return $rt_site_page;
  }

  public function preExecute()
  {
    rtTemplateToolkit::setTemplateForMode('backend');
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtSitePage')->addSiteQuery();
    $query->orderBy('page.root_id ASC, page.lft ASC');
    $this->rt_site_pages = $query->execute();
  }

  public function executeTree(sfWebRequest $request)
  {
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->getUser()->setFlash('notice', 'Please select the tree to create the page in.');
    $this->redirect('rtSitePageAdmin/tree');
    $this->form = new rtSitePageForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new rtSitePageForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $rt_site_page = $this->getGnSitePage($request);
    $this->form = new rtSitePageForm($rt_site_page);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $rt_site_page = $this->getGnSitePage($request);
    $this->form = new rtSitePageForm($rt_site_page);

    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $rt_site_page = $this->getGnSitePage($request);
    $this->clearCache($rt_site_page);
    $rt_site_page->getNode()->delete();

    $this->redirect('rtSitePageAdmin/index');
  }
  
  public function executeVersions(sfWebRequest $request)
  {
    $this->rt_site_page = $this->getGnSitePage($request);
    $this->rt_site_page_versions = Doctrine::getTable('rtSitePageVersion')->findById($this->rt_site_page->getId());
  }

  public function executeCompare(sfWebRequest $request)
  {
    $this->rt_site_page = $this->getGnSitePage($request);
    $this->current_version = $this->rt_site_page->version;

    if(!$request->hasParameter('version1') || !$request->hasParameter('version2'))
    {
      $this->getUser()->setFlash('error', 'Please select two versions to compare.', false);
      $this->redirect('rtSitePageAdmin/versions?id='.$this->rt_site_page->getId());
    }

    $this->version_1 = $request->getParameter('version1');
    $this->version_2 = $request->getParameter('version2');
    $this->versions = array();

    $this->versions[1] = array(
      'title' => $this->rt_site_page->revert($this->version_1)->title,
      'content' => $this->rt_site_page->revert($this->version_1)->content,
      'description' => $this->rt_site_page->revert($this->version_1)->description,
      'updated_at' => $this->rt_site_page->revert($this->version_1)->updated_at
    );
    $this->versions[2] = array(
      'title' => $this->rt_site_page->revert($this->version_2)->title,
      'content' => $this->rt_site_page->revert($this->version_2)->content,
      'description' => $this->rt_site_page->revert($this->version_1)->description,
      'updated_at' => $this->rt_site_page->revert($this->version_1)->updated_at
    );
  }

  public function executeRevert(sfWebRequest $request)
  {
    $this->rt_site_page = $this->getGnSitePage($request);
    $this->rt_site_page->revert($request->getParameter('revert_to'));
    $this->rt_site_page->save();
    $this->getUser()->setFlash('notice', 'Reverted to version ' . $request->getParameter('revert_to'), false);
    $this->clearCache($this->rt_site_page);
    $this->redirect('rtSitePageAdmin/edit?id='.$this->rt_site_page->getId());
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $rt_site_page = $form->save();
      $this->clearCache($rt_site_page);

      $action = $request->getParameter('rt_post_save_action', 'index');

      if($action == 'edit')
      {
        $this->redirect('rtSitePageAdmin/edit?id='.$rt_site_page->getId());
      }elseif($action == 'show')
      {
        $this->redirect('rt_site_page_show',$rt_site_page);
      }

      $this->redirect('rtSitePageAdmin/index');
    }
  }

  private function clearCache($rt_site_page = null)
  {
    rtSitePageCacheToolkit::clearCache($rt_site_page);
  }
}
