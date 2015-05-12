<?php
namespace Blog\Golb\ViewHelpers\Page;

	/***************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2010 Georg Ringer <typo3@ringerge.org>
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
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

/**
 * ViewHelper to include a css/js file
 *
 * # Example: Basic example
 * <code>
 * <n:includeFile path="{settings.cssFile}" />
 * </code>
 * <output>
 * This will include the file provided by {settings} in the header
 * </output>
 *
 * @package TYPO3
 * @subpackage tx_news
 */
class KeywordsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \Blog\Golb\Domain\Repository\PageRepository
	 * @inject
	 */
	protected $pageRepository;

	/**
	 * @param int $pagePid
	 * @return keywords
	 */
	public function render($pagePid = '') {

		$content = $this->pageRepository->findByIdentifier($pagePid);
	//	var_dump($content->getGolbTags());


	}

}
