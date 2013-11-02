Cakephp-Beauty-Paginator
========================

Cakephp pagination helper to remove action name from url and make them seo friendly

 * @version 1.0
 * @link http://www.hashmode.com
 * @demo http://cakepagination.hashmode.com/posts
 * @license MIT
 * 
 * Usage Example:
 * 1) Configure routes
 * 	Router::connect('/posts/:page', array('controller' => 'posts', 'action' => 'index'),
 * 									array('pass' => array('page'), 'page' => '[\d]+' ) );
 * 
 * 2) Add $page argument in pagination function and add it to pagination options
 * public function index($page = 1) {
 * 		$this->paginate['Post'] = array('page' => $page, 'limit' => 4);
 * 		$posts = $this->paginate('Post');
 * 		$this->set(compact('posts') );
 * }
 * 
 * 3) Add Helper in controller and call it in the view
 * 	public $helpers = array('BeautyPaginator'); // in controller
 * 
 *  // in view
 * 		<ul> // by default li tags are used for pagination cells(can be changed - see below)
 * 			<?php
 * 				echo $this->BeautyPaginator->prev(__('« Prev'), array());
 * 				echo $this->BeautyPaginator->numbers(array());
 * 				echo $this->BeautyPaginator->next(__('Next »'), array());
 * 			 ?>
 * 		</ul>
 * 
 * 	********* for prev, next and numbers options available arguments are ******
 *  disabledTag - tag, when the page is disabled(is the current page),
 *  disabledClass - the class(or classes) for disabled tag
 *  tag - the main tag name to wrap over page link
 *  class - class (or classes) for the tag
 *  
 *  
 *  
 *  @TODO - Add other options as for default Paginator helper
 * 
