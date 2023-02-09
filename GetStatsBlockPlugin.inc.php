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

/**
 * http://www.kuliahkomputer.com/2020/01/cara-menampikan-statistik-download-dan.html
 */
  function setGalleys($galleys) {
    return $this->setData('galleys', $galleys);
     }
    
  function getViews() {
    $application = PKPApplication::getApplication();
    return $application->getPrimaryMetricByAssoc(ASSOC_TYPE_ARTICLE, $this->getId());
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

    //print_r(get_class_methods($journalDao));

    //echo "<pre>";
   // print_r($journalDao->getAll()->records->current());
    
    
    //print_r(get_class_methods($x));

    // getIssues ($journalId, $rangeInfo=null)
 
   // die('tyo auqi');

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
    //Não está funcionando pois o artigo em minha maquina começa no numero 4 e vai, em sequencia, ate o 8, logo após dele vem o 10.
    //METRIC QUE PEGA ARTIGOS
    //https://pkp.sfu.ca/ojs/doxygen/master/html/StatisticsHelper_8inc_8php_source.html
    
    //Não sei o que são esses statistics, nem da onde vem. Só funciona!
    $column = array(
      STATISTICS_DIMENSION_SUBMISSION_ID,
    );

    $filter = array(
      STATISTICS_DIMENSION_ASSOC_TYPE => ASSOC_TYPE_SUBMISSION_FILE,
    );

    $orderBy = array(STATISTICS_METRIC => STATISTICS_ORDER_DESC);

    $result = $metricsDao->getMetrics(OJS_METRIC_TYPE_COUNTER, $column, $filter, $orderBy);

    $artigos;

		foreach ($result as $resultRecord) {
      $submissionId = $resultRecord[STATISTICS_DIMENSION_SUBMISSION_ID];
      $article = $submissionDao->getById($submissionId);
      
      //
      $journal = $journalDao->getById($article->getJournalId());

      //Não identifiquei qual esse Path é esse.
      //var_dump($articles[$submissionId]['journalPath'] = $journal->getPath());

      //Aqui temos o número de artigos (Podemos fazer a contagem de artigos por aqui com um count)
      //var_dump($articles[$submissionId]['articleId'] = $article->getBestArticleId());

      //Esse pega o nome de todos os artigos
      var_dump($articles[$submissionId]['articleTitle'] = $article->getLocalizedTitle());
      $artigos = $article->getLocalizedTitle();
      //var_dump($artigos);
      
      //Não entendi direito o que esse pega
      //var_dump($articles[$submissionId]['metric'] = $resultRecord[STATISTICS_METRIC]);

      //Aqui temos o número de vizualização de todos os arquivos
      //var_dump($articles[$submissionId]['articleViews'] = $article->getViews());

      //Esse não funciona pq o não descobri como fazer o getDownload
      //var_dump($articles[$submissionId]['articleViews'] = $article->getDownloadStats());
    }
    //$cache->setEntireCache($articles);
    //return $result;

    $artigo = 0;
    $controlador_A = 1;
    for($controler = 1; ;){
      $controlador_A = $submissionDao->getById($controler);
      if($controlador_A == NULL)
      {
        break;
      }
      else
      {
        $artigo++; 
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
    $templateMgr->assign('artigos', count($artigos));
    $templateMgr->assign('downloads', $numDownloads);
    $templateMgr->assign('acessos', $numAcessos);
    return parent::getContents($templateMgr, $request);
  }
}