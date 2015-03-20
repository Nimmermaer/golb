<?php

if ( ! defined( 'TYPO3_MODE' ) ) {
	die( 'Access denied.' );
}

$TCA['tx_golb_domain_model_tag'] = array(
	'ctrl'      => $TCA['tx_golb_domain_model_tag']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, records',
	),
	'types'     => array(
		'1' => array( 'showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, records, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime' ),
	),
	'palettes'  => array(
		'1' => array( 'showitem' => '' ),
	),
	'columns'   => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config'  => array(
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items'               => array(
					array( 'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', - 1 ),
					array( 'LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0 )
				),
			),
		),
		'l10n_parent'      => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config'      => array(
				'type'                => 'select',
				'items'               => array(
					array( '', 0 ),
				),
				'foreign_table'       => 'tx_golb_domain_model_tag',
				'foreign_table_where' => 'AND tx_golb_domain_model_tag.pid=###CURRENT_PID### AND tx_golb_domain_model_tag.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource'  => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label'      => array(
			'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max'  => 255,
			)
		),
		'hidden'           => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config'  => array(
				'type' => 'check',
			),
		),
		'starttime'        => array(
			'exclude'   => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label'     => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config'    => array(
				'type'     => 'input',
				'size'     => 13,
				'max'      => 20,
				'eval'     => 'datetime',
				'checkbox' => 0,
				'default'  => 0,
				'range'    => array(
					'lower' => mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y' ) )
				),
			),
		),
		'endtime'          => array(
			'exclude'   => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label'     => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config'    => array(
				'type'     => 'input',
				'size'     => 13,
				'max'      => 20,
				'eval'     => 'datetime',
				'checkbox' => 0,
				'default'  => 0,
				'range'    => array(
					'lower' => mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y' ) )
				),
			),
		),
		'title'          => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:tx_golb_domain_model_tag.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'records'          => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:golb/Resources/Private/Language/locallang_db.xlf:tx_golb_domain_model_tag.records',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => '*',
				'MM' => 'tx_golb_tag_record_mm',
				'MM_oppositeUsage' => array(
					'pages' => array(
						'golb_tags'
					)
				),
				'size' => 10
			),
		),
	)
);
?>