<?php
/**
 * The following creates the desired sitePage routes.
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
     * Enable the required routes
     *
     * @param sfEvent $event
     */
    public function listenToRoutingLoadConfiguration(sfEvent $event)
    {
        $routing = $event->getSubject();

        if(sfConfig::get('app_rt_site_page_simple_routes', true)) {
            // Note the appendRoute(). It is very important that this is the only lean "/blah" route that is
            // set by append. Consider the collision implications for non-page routes like "/contact".
            $routing->prependRoute(
                'rt_site_page_show',
                new sfDoctrineRoute(
                    '/:slug',
                    array('module' => 'rtSitePage', 'action' => 'show'),
                    array('sf_method' => array('get')),
                    array('model' => 'rtSitePage', 'type' => 'object')
                )
            );

            if($pages = Doctrine::getTable('rtSitePage')->findAllPages()) {
                foreach($pages as $page) {
                    $routing->prependRoute(
                        'rt_site_page_show_' . $page->getSlug(),
                        new sfDoctrineRoute(
                            '/'.$page->getSlug(),
                            array('module' => 'rtSitePage', 'action' => 'show', 'slug' => $page->getSlug()),
                            array('sf_method' => array('get')),
                            array('model' => 'rtSitePage', 'type' => 'object')
                        )
                    );
                }
            }

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
            new sfRoute('/site',array('module' => 'rtSitePage', 'action' => 'index'))
        );

        $routing->prependRoute(
            'rt_site_page_create',
            new sfRoute('/site-page/create-from-404/:slug',array('module' => 'rtSitePage', 'action' => 'create'))
        );
    }
}