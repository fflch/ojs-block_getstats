<?php
import('lib.pkp.classes.plugins.BlockPlugin');
class GetStatsBlockPlugin extends BlockPlugin {
	public function register($category, $path, $mainContextId = NULL) {

    // Register the plugin even when it is not enabled
    $success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
      // Do something when the plugin is enabled
    }

		return $success;
	}

  /**
   * Provide a name for this plugin
   *
   * The name will appear in the plugins list where editors can
   * enable and disable plugins.
   */
	public function getDisplayName() {
		return 'Plugin to display statistics from journals';
	}

	/**
   * Provide a description for this plugin
   *
   * The description will appear in the plugins list where editors can
   * enable and disable plugins.
   */
	public function getDescription() {
		return 'This plugin was created to help display informations from Journas at Universidade de São Paulo';
	}

  /**
   * Added to display block at general site
   */
  public function isSitePlugin() {
    return true;
  }

  public function getContents($templateMgr, $request = null) {
    
    $context = Application::get()->getRequest()->getContext();
    if ($context) {
      // When we are inside journal context
      $x=5;
    } else {
      // When we are in site context
      $x=12;
    }
    
    $templateMgr->assign('revistas', $x*100);
    $templateMgr->assign('artigos', $x*5);
    $templateMgr->assign('fasciculos', $x*44);
    $templateMgr->assign('downloads', $x*2.5);
    $templateMgr->assign('acessos', $x*4);
    return parent::getContents($templateMgr, $request);
  }
}
