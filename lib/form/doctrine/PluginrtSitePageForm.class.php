<?php

/**
 * PluginrtSitePage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrtSitePageForm extends BasertSitePageForm
{
  public function setup()
  {
    parent::setup();
    unset($this['level'], $this['comment_status'], $this['lft'], $this['rgt'], $this['root_id']);
  }
}
