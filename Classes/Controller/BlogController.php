<?php

namespace Blog\Golb\Controller;

/**
 * *************************************************************
 *
 * Copyright notice
 *
 * (c) 2015 Marcel Wieser <typo3dev@marcel-wieser.de>
 * Philipp Thiele <philipp.thiele@phth.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * *************************************************************
 */

/**
 * Class TestController
 *
 * @package Blog\Golb\Domain\Controller
 */
class BlogController extends BaseController {
	
	/**
	 *
	 * @var \Blog\Golb\Domain\Repository\PageRepository 
	 * @inject
	 */
	protected $pageRepository;
	
	/**
	 *
	 * @var \Blog\Golb\Domain\Repository\TagRepository 
	 * @inject
	 */
	protected $tagRepository;
	
	/**
	 *
	 * @var \Blog\Golb\Domain\Repository\CategoryRepository 
	 * @inject
	 */
	protected $categoryRepository;
	
	/**
	 * Contains array with pages to load blog posts from
	 *
	 * @var array $pages
	 */
	protected $pages;
	
	/**
	 * Contains categories to filter posts
	 *
	 * @var array $categories
	 */
	protected $categories;
	
	/**
	 * Sets pages and categories properties
	 *
	 * @return void
	 */
	public function initializeAction() {
		parent::initializeAction ();
		
		$this->pages = array_map ( 'trim', explode ( ',', $this->contentObject->data ['pages'] ) );
		$this->categories = $this->categoryRepository->findByRelation ( $this->contentObject->data ['uid'] )->toArray ();
		
		/**
		 * @ToDo: Find another solution?!
		 */
		if ($this->contentObject->data ['golb_action'] !== '' && $this->reflectionService->hasMethod ( get_class ( $this ), $this->contentObject->data ['golb_action'] . 'Action' )) {
			/**
			 * @ToDo Find a better solution.
			 */
			$action = $this->contentObject->data ['golb_action'];
			$this->contentObject->data ['golb_action'] = '';
			$this->forward ( $action );
		}
	}
	
	/**
	 * Lists latest blog posts
	 *
	 * @return void
	 */
	public function latestAction() {
		$posts = $this->pageRepository->findPosts ( $this->pages, $this->contentObject->data ['golb_limit'], $this->contentObject->data ['golb_offset'], $this->categories, $this->contentObject->data ['golb_tags'], $this->contentObject->data ['golb_exclude'], 'date' );
		
		$this->view->assign ( 'posts', $posts );
	}
	
	/**
	 * Lists blog posts
	 *
	 * @return void
	 */
	public function listAction() {
		$posts = $this->pageRepository->findPosts ( $this->pages, $this->contentObject->data ['golb_limit'], $this->contentObject->data ['golb_offset'], $this->categories, $this->contentObject->data ['golb_exclude'], $GLOBALS ['TSFE']->fe_user->getKey ( 'ses', 'blogSorting' ) );
		
		$this->view->assign ( 'posts', $posts );
	}
	
	/**
	 * filter for Pages
	 * 
	 * @return array
	 */
	public function filterAction() {
		$filter = $_GET;
		
		if (array_key_exists ( 'tagUid', $filter ) && array_key_exists ( 'tagTitle', $filter )) {
			$showFilter = $filter ['tagTitle'];
			$posts = $this->pageRepository->findPostsByFilter ( $filter );
		}
		if (array_key_exists ( 'categoryUid', $filter ) && array_key_exists ( 'categoryTitle', $filter )) {
			$showFilter = $filter ['categoryTitle'];
			$posts = $this->pageRepository->findPostsByFilter ( $filter );
		}
		if (array_key_exists ( 'year', $filter )) {
			$showFilter = date ( o, $filter ['year'] );
			$posts = $this->pageRepository->findPostsByFilter ( $filter );
		}
		if (array_key_exists ( 'month', $filter )) {
			$showFilter = strftime ( "%B", $filter ['month'] );
			$posts = $this->pageRepository->findPostsByFilter ( $filter );
		}
		$this->view->assign ( 'filter', $showFilter );
		$this->view->assign ( 'posts', $posts );
	}
	
	/**
	 *list categories
	 *
	 * @return void
	 */
	public function listCategoryAction() {
		$categories = $this->categoryRepository->findAll ();
		
		$this->view->assign ( 'categories', $categories );
	}
	
	/**
	 * list ReleaseDates
	 *
	 * @return void
	 */
	public function listReleaseDateAction() {
		$dates = $this->pageRepository->findDatesFromPosts ();
		$this->view->assign ( 'dates', $dates );
	}
	
	/**
	 * show Details for post
	 *
	 * @return void
	 */
	public function detailsAction() {
		$pid = $GLOBALS ['TSFE']->id;
		
		$categories = $this->categoryRepository->findByRelation ( $pid, 'pages' );
		$tags = $this->tagRepository->findByPid ( $pid );
		$page = $this->pageRepository->findByUid ( $pid );
		
		$this->view->assign ( 'categories', $categories );
		$this->view->assign ( 'tags', $tags );
		$this->view->assign ( 'pages', $page );
	}
}