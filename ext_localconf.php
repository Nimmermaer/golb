<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['AJAX']['Golb::getKeywords']
		= 'EXT:golb/Classes/UserFunctions/TagField.php:Blog\Golb\UserFunctions\TagField->suggestTag';
}

$boot = function($packageKey) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'Sorting',
		array(
			'Sorting' => 'sortBy'
		),
		array(
			'Sorting' => 'sortBy'
		)
	);
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'Blog',
		array(
			'Blog' => 'latest, list'
		),
		array(
			'Blog' => 'list'
		)
	);
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'Blog.' . $packageKey,
			'BlogDetails',
			array(
					'Blog' => 'details'
			),
			array(
					'Blog' => 'details'
			)
	);
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'ViewCount',
		array(
			'ViewCount' => 'countView'
		),
		array(
			'ViewCount' => 'countView'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'TagCloud',
		array(
			'Tag' => 'list, show'
		),
		array(
			'Tag' => 'list, show'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'Filter',
		array(
			'Blog' => 'filter'
		),
		array(
			'Blog' => 'filter'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'ListReleaseDate',
		array(
			'Blog' => 'listReleaseDate',
		),
		array(
			'Blog' => 'listReleaseDate',
			)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Blog.' . $packageKey,
		'ListCategory',
		array(
			'Blog' => 'listCategory'
		),
		array(
			'Blog' => 'listCategory'
		)
	);

	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
		'EXT:golb/Classes/Hook/SetBackendLayout.php:Blog\Golb\Hook\SetBackendLayout';

	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Domain\\Model\\Category'] = array(
		'className' => 'Blog\\Golb\\Domain\\Model\\Category',
	);

	$GLOBALS["TYPO3_CONF_VARS"]["SC_OPTIONS"]["t3lib/class.t3lib_tcemain.php"]["processDatamapClass"][] =
		'EXT:golb/Classes/Hook/Tx_golb_tcemainprocdm.php:Blog\Golb\Hook\Tx_golb_tcemainprocdm';


};

/** @var string $_EXTKEY */
$boot($_EXTKEY);
unset($boot);