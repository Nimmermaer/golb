<?php
namespace Blog\Golb\Controller;


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
 * Class TagCloudController
 *
 * @package Blog\Golb\Domain\Controller
 */
class TagCloudController extends BaseController {

	/**
	 * @var \Blog\Golb\Domain\Repository\TagRepository
	 * @inject
	 */
	protected $tagRepository;



	/**
	 * Find all Tags for cloud with uid for link
	 *
	 * @return void
	 */
	public function showAction() {

		$tags = $this->tagRepository->findAll();

		$this->view->assign('tags', $tags);
	}

	/**
	 * Lists blog posts
	 *
	 * @return void
	 */
	public function listAction() {
		$posts = $this->pageRepository->findPosts(
			$this->pages,
			$this->contentObject->data['golb_limit'],
			$this->contentObject->data['golb_offset'],
			$this->categories
		);

		$this->view->assign('posts', $posts);
	}

}