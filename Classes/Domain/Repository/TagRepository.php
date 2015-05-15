<?php
namespace Blog\Golb\Domain\Repository;


	/***************************************************************
	 *
	 *  Copyright notice
	 *
	 *  (c) 2015 Marcel Wieser <typo3dev@marcel-wieser.de>
	 *           Philipp Thiele <philipp.thiele@phth.de>
	 *
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 3 of the License, or
	 *  (at your option) any later version.
	 *
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

/**
 * The repository for pages
 */
class TagRepository extends Repository {

	public function initializeObject() {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($querySettings);
	}

	public function countByUid($uid) {
		$tagsCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows (
			'*',
			'tx_golb_domain_model_tag'
		);
		$tagCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows (
			'*',
			'tx_golb_tag_record_mm',
			' uid_local = ' . $uid
		);

		if($tagCount){
			$tagPercent = $this->GetTagSizeLogarithmic($tagCount,0,$tagsCount,5, 40, '' );
			}

		return $tagPercent;
	}

	public function GetTagSizeLogarithmic( $count, $mincount, $maxcount, $minsize, $maxsize, $tresholds ) {
		if( empty($tresholds) ) :
			$tresholds = $maxsize-$minsize;
			$treshold = 1;
		else :
			$treshold = ($maxsize-$minsize)/($tresholds-1);
		endif;
		$a = $tresholds*log($count - $mincount+2)/log($maxcount - $mincount+2)-1;
		return round($minsize+round($a)*$treshold);
	}

}