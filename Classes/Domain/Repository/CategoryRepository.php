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
 * The repository for categories
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository {

	/**
	 * @param $id
	 * @param string $tableName
	 * @param string $fieldName
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
	 */
	public function findByRelation($id, $tableName = 'tt_content', $fieldName = 'categories') {
		$query = $this->createQuery();
		$query->statement(
			'SELECT * '.
			'FROM sys_category as cat, sys_category_record_mm as mm ' .
			'WHERE mm.tablenames = "'.$tableName.'" ' .
			'AND mm.uid_foreign = '.(int)$id.' ' .
			'AND mm.fieldname = "'.$fieldName.'" ' .
			'AND cat.uid = mm.uid_local '.
			'AND hidden != 1 AND deleted != 1'
		);

		return $query->execute();
	}
}