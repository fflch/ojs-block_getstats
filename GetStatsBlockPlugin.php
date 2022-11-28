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

  public function getContents($templateMgr, $request = null) {
    $templateMgr->assign('revistas', 150);
    $templateMgr->assign('artigos', 5000);
    return parent::getContents($templateMgr, $request);
  }
}
