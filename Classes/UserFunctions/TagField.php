<?php
namespace Blog\Golb\UserFunctions;

	/***************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2014 Björn Christopher Bresser  (bjoern.bresser@bjobre.de)
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
	 *  (at your option) any later version.
	 *
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *  A copy is found in the textfile GPL.txt and important notices to the license
	 *  from the author is found in LICENSE.txt distributed with these scripts.
	 *
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

/**
 * Class TagField
 * @package Blog\Golb\UserFunctions
 */
class TagField {


	/**
	 * @var array
	 */
	protected $parameter = array();

	public function suggestTag($parameter) {
		$keywords = $parameter['row']['keywords'];
		$pid = $parameter['row']['uid'];

		$sys_language = $parameter['row']['sys_language_uid'];
		$this->parameter = $parameter;


		$fluidTemplate = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Fluid\View\StandaloneView');
		$fluidTemplate->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:golb/Resources/Private/Templates/UserFields/TagsEditorField.html'));

		if ($keywords) {
			$fluidTemplate->assign('keywordsArr', explode(',', $keywords));
			$fluidTemplate->assign('keywords', $keywords);
		}

		$table = (!$sys_language) ? 'pages' : 'pages_language_overlay';
		$fluidTemplate->assign('pid', $pid);
		$fluidTemplate->assign('language', $sys_language);
		$fluidTemplate->assign('table', $table);

		$keywordArr = array();
		$language = $_GET['L'];

			$table = ' pages';
			$where = '  pages.deleted=0 AND pages.golb_tags!=""';

			$tags = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'DISTINCT tx_golb_domain_model_tag.title',
			$table .', tx_golb_domain_model_tag, tx_golb_tag_record_mm ',
			" pages.uid = ". $pid ."
			 AND pages.uid = tx_golb_tag_record_mm.uid_foreign
			 AND tx_golb_domain_model_tag.deleted = 0
			 AND tx_golb_tag_record_mm.uid_local = tx_golb_domain_model_tag.uid AND" .$where,
			'',
			'',
			'',
			'title'
		);

		$allTags  = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'tx_golb_domain_model_tag.title',
			' tx_golb_domain_model_tag',
			'deleted = 0',
			'',
			'',
			'',
			'title'
		);




		$allTags = json_encode(array_keys($allTags));

		/*

		echo json_encode(array(
			'status' => 'ok',
			'title' => json_encode($keywordArr)
		));
			*/

		$commaSeperatedTags = implode(',', array_keys($tags));


		$fluidTemplate->assign(
			'tags', $tags
			);
		$fluidTemplate->assign(
			'allTags',$allTags
			);

		$fluidTemplate->assign(
			'commaSeperatedTags',$commaSeperatedTags
		);
		$fluidTemplate->assign(
			'commaSeperatedTags',$commaSeperatedTags
		);

		return $fluidTemplate->render();
	}

}