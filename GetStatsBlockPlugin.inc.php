<?php
import('lib.pkp.classes.plugins.BlockPlugin');

class GetStatsBlockPlugin extends BlockPlugin {
	/**
	 * Install default settings on journal creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

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
		return __('plugins.block.get.displayName');
	}

	/**
   * Provide a description for this plugin
   *
   * The description will appear in the plugins list where editors can
   * enable and disable plugins.
   */
	public function getDescription() {
		return __('plugins.block.get.description');
	}

  /**
   * Added to display block at general site
   */
  public function isSitePlugin() {
    return true;
  }

  public function getContents($templateMgr, $request = null) {
    
    //Tentativa de fazer a linha SQL, porém não funcionou e não entendo o porque.
    //$reviewRoundDao = DAORegistry::getDAO('ReviewRoundDAO');
    //$result = DAO::retrieve('SELECT * FROM `journals`', [$reviewRoundDao]);
    //var_dump($result);
    //$sql = DAORegistry::getDAO();

    $journalDao = DAORegistry::getDAO('JournalDAO');
    $metricsDao = DAORegistry::getDAO('MetricsDAO');
    $issueDao = DAORegistry::getDAO('IssueDAO');
    $submissionDao = DAORegistry::getDAO('SubmissionDAO');

    //Número de Revistas
    $journalDao = Application::getContextDAO();
    $revistas = $journalDao->getTitles();
    $journals = $journalDao->getAll();


 //Número de Faciculos
    $fasciculos = 0;
    $controlador = 1;
    for($controler = 1; ;){
      $controlador = $issueDao->getById($controler);
      if($controlador == NULL)
      {
        break;
      }
      else
      {
        $fasciculos++;
      }
      $controler++;
    }

    //Número de artigos
    //Não está funcionando pois o artigo em minha maquina começa no numero 4 e vai ate o 8, logo após dele vem o 10.
    $artigos = 0;
    $controlador_A = 1;
    for($controler = 1; ;){
      $controlador_A = $submissionDao->getById($controler);
      if($controlador_A == NULL)
      {
        break;
      }
      else
      {
        $artigos++; 
      }
      $controler++;
    }

    //Número de downloads
    //Precisa do MetricsDao, o qual não entendi como obter


    //Número de acessos
    //Precisa do MetricsDao, o qual não entendi como obter

   // $numAcessos = $metricsDao->getTotalViews();

    //Exibição
    $templateMgr->assign('revistas', count($revistas));
    $templateMgr->assign('fasciculos', $fasciculos);
    $templateMgr->assign('artigos', $artigos);
    $templateMgr->assign('downloads', $numDownloads);
    $templateMgr->assign('acessos', $numAcessos);
    return parent::getContents($templateMgr, $request);
  }
}