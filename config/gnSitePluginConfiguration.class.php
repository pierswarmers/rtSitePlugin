<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gnSitePluginConfigurationclass
 *
 * @author pierswarmers
 */
class gnSitePluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('routing.load_configuration', array($this, 'listenToRoutingLoadConfiguration'));
  }

  /**
   * Enable the required routes, carefully checking that no customisation are present.
   * 
   * @param sfEvent $event
   */
  public function listenToRoutingLoadConfiguration(sfEvent $event)
  {
    $routing = $event->getSubject();

    $routing->prependRoute(
      'gn_site_page_show',
      new sfDoctrineRoute(
        '/site/:slug/:id',
          array('module' => 'gnSitePage', 'action' => 'show'),
          array('id' => '\d+', 'sf_method' => array('get')),
          array('model' => 'gnSitePage', 'type' => 'object')
      )
    );

    $routing->prependRoute(
      'gn_site_page_index',
      new sfRoute('/site',array('module' => 'gnSitePage', 'action' => 'index'))
    );
  }
}