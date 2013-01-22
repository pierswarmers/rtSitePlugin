<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rtSitePluginConfigurationclass
 *
 * @author pierswarmers
 */
class rtSitePluginConfiguration extends sfPluginConfiguration
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

    if(sfConfig::get('app_rt_site_page_simple_routes', true)) {

        $routing->prependRoute(
            'rt_site_page_show',
            new sfDoctrineRoute(
                '/s/:slug',
                array('module' => 'rtSitePage', 'action' => 'show'),
                array('sf_method' => array('get')),
                array('model' => 'rtSitePage', 'type' => 'object')
            )
        );

    } else {

        $routing->prependRoute(
            'rt_site_page_show',
            new sfDoctrineRoute(
                '/site/:id/:slug',
                array('module' => 'rtSitePage', 'action' => 'show'),
                array('id' => '\d+', 'sf_method' => array('get')),
                array('model' => 'rtSitePage', 'type' => 'object')
            )
        );

    }


    $routing->prependRoute(
      'rt_site_page_index',
      new sfRoute('/',array('module' => 'rtSitePage', 'action' => 'index'))
    );
  }
}