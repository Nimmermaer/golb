<?php
namespace Blog\Golb\Domain\Repository;
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 20.03.2015
 * Time: 17:17
 */




class Repository extends \TYPO3\CMS\Extbase\Persistence\Repository{

	/**
	 * configurationManager
	 *
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * cObj
	 *
	 */
	protected $cObj;

	/**
	 * initialize
	 *
	 * @return void
	 */
	public function initializeObject() {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($querySettings);
		$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$this->settings = $frameworkConfiguration['settings'];
		if (TYPO3_MODE === 'BE') {
			$this->buildTSFE();
			$this->cObj = $GLOBALS['TSFE']->cObj;
		} else {
			$this->cObj = $this->configurationManager->getContentObject();
		}
	}



}