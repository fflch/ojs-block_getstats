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
		return 'Tutorial Example';
	}

	/**
   * Provide a description for this plugin
   *
   * The description will appear in the plugins list where editors can
   * enable and disable plugins.
   */
	public function getDescription() {
		return 'This plugin is an example created for a tutorial on how to create a plugin.';
	}
}
