<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$boot = function($packageKey) {
	$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Blog.' . $packageKey,
		'Blog',
		'Blog'
	);
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Blog.' . $packageKey,
		'ViewCount',
		'ViewCount'
	);
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Blog.' . $packageKey,
		'Sorting',
		'Sorting'
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Blog.' . $packageKey,
		'TagCloud',
		'TagCloud'
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Blog.' . $packageKey,
		'MenuBar',
		'MenuBar'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($packageKey, 'Configuration/TypoScript', 'Golb');

	//New fields
	$GLOBALS['TCA']['tt_content']['columns']['golb_sorting'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:ttcontent.sorting',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'varchar'
		),
	);
	$GLOBALS['TCA']['tt_content']['columns']['golb_sorting_direction'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:ttcontent.sortingdirection',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'varchar'
		),
	);
	$GLOBALS['TCA']['tt_content']['columns']['golb_limit'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:ttcontent.limit',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'int'
		),
	);
	$GLOBALS['TCA']['tt_content']['columns']['golb_offset'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:ttcontent.offset',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'int'
		),
	);

	$GLOBALS['TCA']['tt_content']['columns']['golb_action'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:ttcontent.action',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('Latest', ''),
				array('List', 'list')
			)
		),
	);
	$GLOBALS['TCA']['pages']['columns']['golb_related'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:pages.related',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'pages',
			'foreign_table_where' => 'AND doktype = 41 ORDER BY crdate ASC',
			'size' => 5,
			'minitems' => 0,
			'maxitems' => 4,
			'enableMultiSelectFilterTextfield' => TRUE,
		),
	);
	$GLOBALS['TCA']['pages']['columns']['golb_tags'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:pages.golb_tags',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_golb_domain_model_tag',
			'MM' => 'tx_golb_tag_record_mm',
			'MM_opposite_field' => 'records',
			'MM_match_fields' => array(
				'tablenames' => 'pages',
				'fieldname' => 'golb_tags'
			),
			'size' => 5,
			'minitems' => 0,
			'maxitems' => 999,
			'wizards' => array(
				'_PADDING' => 4,
				'_VERTICAL' => 1,
				'suggest' => array(
					'type' => 'suggest'
				),
				'edit' => array(
					'type' => 'popup',
					'title' => 'Edit',
					'module' => array(
						'name' => 'wizard_edit',
					),
					'popup_onlyOpenIfSelected' => 1,
					'icon' => 'edit2.gif',
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
				),
				'add' => array(
					'type' => 'script',
					'title' => 'LLL:EXT:cms/locallang_tca.xlf:sys_template.basedOn_add',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'tx_golb_domain_model_tag',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
					),
					'module' => array(
						'name' => 'wizard_add'
					)
				)
			)
		)
	);
	$GLOBALS['TCA']['pages']['columns']['tt_content'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:pages.tt_content',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tt_content',
			'foreign_field' => 'pid',
			'foreign_sortby' => 'sorting',
			'maxitems' => 9999,
		),
	);

	//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','--div--;Golb, golb_related');

	$GLOBALS['TCA']['pages']['columns']['author_image'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:pages.authorImage',
		'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('authorImage', array(
				'appearance' => array(
					'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
				),
				'minitems' => 0,
				'maxitems' => 1,
			)
		)
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
		'pages', // table
		'author_image', // your field definition
		'', // at which types it should appear (f.e. in table tt_content 'textpic' or 'image')
		'after:author_email' // before: or after: the field in the TCA
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','--div--;Golb, golb_related, golb_tags');
	$GLOBALS['TCA']['pages']['columns']['subpages'] = array(
		'exclude' => 0,
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'pages',
			'foreign_field' => 'pid',
			'maxitems'      => 9999,
		),
	);

	$GLOBALS['TCA']['sys_category']['columns']['sub_categories'] = array(
		'exclude' => 0,
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'sys_category',
			'foreign_field' => 'parent',
			'maxitems'      => 9999,
		),
	);

	$GLOBALS['TCA']['tt_content']['columns']['golb_exclude'] = array(
		'exclude' => 0,
		'label' => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:pages.excludepages',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'pages',
			'foreign_table_where' => 'AND doktype = 41 ORDER BY crdate ASC',
			'size' => 5,
			'minitems' => 0,
			'maxitems' => 9999,
			'enableMultiSelectFilterTextfield' => TRUE,
		),
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array('Blog', 'golb'), 'CType');
	$GLOBALS['TCA']['tt_content']['types']['golb']['showitem'] =
		'CType;;4;button;1-1-1, golb_action, golb_sorting, golb_sorting_direction, golb_limit, golb_offset, golb_related, pages, golb_exclude, categories,
		--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,starttime, endtime, fe_group';

	//Set new page types
	$GLOBALS['TCA']['pages']['types']['41'] = $GLOBALS['TCA']['pages']['types']['1'];

	$pageItems = &$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'];
	array_push($pageItems, array('Golb', '--div--'));
	array_push($pageItems, array('Blog post', '41', 'EXT:golb/Resources/Public/Icons/doktype_blogpost.gif'));

	$pageOverlayItems = &$GLOBALS['TCA']['pages_language_overlay']['columns']['doktype']['config']['items'];
	array_push($pageOverlayItems, array('Golb', '--div--'));
	array_push($pageOverlayItems, array('Blog post', '41', 'EXT:golb/Resources/Public/Icons/doktype_blogpost.gif'));


	$GLOBALS['TCA']['pages_language_overlay']['columns']['doktype']['config']['items'][] = array(
		'Blog post',
		'41',
		'EXT:golb/Resources/Public/Icons/doktype_blogpost.gif'
	);

	\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon(
		'pages',
		'41',
		$extPath . 'Resources/Public/Icons/doktype_blogpost.gif'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
		'options.pageTree.doktypesToShowInNewPageDragArea := addToList(41)'
	);


	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_golb_domain_model_tag', 'EXT:golb/Resources/Private/Language/locallang_csh_tx_golb_domain_model_tag.xlf');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_golb_domain_model_tag');
	$GLOBALS['TCA']['tx_golb_domain_model_tag'] = array(
		'ctrl' => array(
			'title'	=> 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:tx_golb_domain_model_tag',
			'label' => 'title',
			'tstamp' => 'tstamp',
			'crdate' => 'crdate',
			'cruser_id' => 'cruser_id',
			'dividers2tabs' => TRUE,
			'sortby' => 'sorting',
			'versioningWS' => 2,
			'versioning_followPages' => TRUE,
			'origUid' => 't3_origuid',
			'languageField' => 'sys_language_uid',
			'transOrigPointerField' => 'l10n_parent',
			'transOrigDiffSourceField' => 'l10n_diffsource',
			'delete' => 'deleted',
			'enablecolumns' => array(
				'disabled' => 'hidden',
				'starttime' => 'starttime',
				'endtime' => 'endtime',
			),
			'searchFields' => 'title,',
			'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($packageKey) . 'Configuration/TCA/Tag.php',
			'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey) . 'Resources/Public/Icons/tx_golb_domain_model_tag.gif'
		),
	);


	// Add new properties to pages
	$extPageKeyword = array (
		'tx_golb_tags_editor' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:ext_page_keywords/Resources/Private/Language/locallang_db.xlf:tx_golb_tags_editor',
			'config' => array (
				'type' => 'user',
				'userFunc' => 'Blog\Golb\UserFunctions\TagField->suggestTag'
			),
		),
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay', $extPageKeyword, 1);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $extPageKeyword, 1);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_golb_tags_editor','','before:keywords');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages_language_overlay', 'tx_golb_tags_editor','','before:keywords');



};

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler (
	'Golb::golb_tags',
	'Blog\\Golb\\Ajax\\SuggestField->getTags',
	FALSE
);

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName =  strtolower('MenuBar');
$pluginSignature = $extensionName.'_'.$pluginName;
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForm/Flexform.xml');

$pluginNameBlog =  strtolower('Blog');
$pluginSignatureBlog = $extensionName.'_'.$pluginNameBlog;
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignatureBlog] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignatureBlog] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignatureBlog, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForm/Blog.xml');

/** @var string $_EXTKEY */
$boot($_EXTKEY);
unset($boot);