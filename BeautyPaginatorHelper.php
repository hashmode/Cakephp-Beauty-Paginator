<?php
/**
 * Cakephp Beauty Paginator Helper - for making cakephp pagination links from /posts/index/page:2 to /posts/2
 * tested with cakephp 2.x
 *
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
 */

class BeautyPaginatorHelper extends AppHelper {
	public $helpers = array('Html');
	public $model = false;
	public $currentPage = 0;
	
/**
 *  Generate Prev Link
 *  
 *  @param string $title - the name to be displayed as "Prev"
 *  @param array $options - list of options 
 *  @return string - returns Prev pagination link
 */	
	public function prev($title = null, $options = array()) {
		$defaults = array(
			'disabledTag' => 'a', 'disabledClass' => 'disabled', 'tag' => 'li',
			'class' => ''
		);
		$options += $defaults;
		
		$disabledTag = $options['disabledTag'];
		$disabledClass = $options['disabledClass'];
		$tag = $options['tag'];
		$tagClass = $options['class'];
		$out = "";

		$pagingArr = $this->params['paging'];
		reset($pagingArr);
		$this->model = key($pagingArr);
		$pagingData = $this->params['paging'][$this->model];

		$this->currentPage = $pagingData['page'];
		$paginationLink = $this->getPaginationLink();

		if ($pagingData['prevPage']) {
			$page = $this->currentPage-1;
			$page = $page != 1 ? '/'.$page : "";
			
			$out = $this->Html->link($title, $paginationLink.$page, array('class' => $tagClass));
			$out = $this->Html->tag($tag, $out, array('class' => $tagClass));
		} else {
			$out = $this->Html->tag($disabledTag, $title);
			$out = $this->Html->tag($tag, $out, array('class' => $disabledClass));
		}
		return $out;
	}
	
/**
 *  Generate Next Link
 *
 *  @param string $title - the name to be displayed as "Next"
 *  @param array $options - list of options
 *  @return string - returns Next pagination link
 */
	public function next($title = null, $options = array()) {
		$defaults = array(
			'disabledTag' => 'a', 'disabledClass' => 'disabled', 'tag' => 'li',
			'class' => ''
		);
		$options += $defaults;
		
		$disabledTag = $options['disabledTag'];
		$disabledClass = $options['disabledClass'];
		$tag = $options['tag'];
		$tagClass = $options['class'];
		$out = "";

		$pagingArr = $this->params['paging'];
		reset($pagingArr);
		$this->model = key($pagingArr);
		$pagingData = $this->params['paging'][$this->model];
		$this->currentPage = $pagingData['page'];
		
		$paginationLink = $this->getPaginationLink();
		if ($pagingData['nextPage']) {
			$page = $this->currentPage+1;
			
			$out = $this->Html->link($title, $paginationLink.'/'.$page, array('class' => $tagClass));
			$out = $this->Html->tag($tag, $out, array('class' => $tagClass));
		} else {
			$out = $this->Html->tag($disabledTag, $title);
			$out = $this->Html->tag($tag, $out, array('class' => $disabledClass));
		}
		return $out;
	}
	
/**
 *  Generate Pagination Numbers
 *
 *  @param array $options - list of options
 *  @return string - returns pagination numbers
 */
	public function numbers($options = array()) {
		$defaults = array(
			'disabledTag' => 'a', 'disabledClass' => 'disabled', 'tag' => 'li',
			'class' => ''
		);
		$options += $defaults;
		
		$disabledTag = $options['disabledTag'];
		$disabledClass = $options['disabledClass'];
		$tag = $options['tag'];
		$tagClass = $options['class'];
		$out = "";

		$pagingArr = $this->params['paging'];
		reset($pagingArr);
		$this->model = key($pagingArr);
		$pagingData = $this->params['paging'][$this->model];

		$pageCount = $pagingData['pageCount'];
		$this->currentPage = $pagingData['page'];
		
		$paginationLink = $this->getPaginationLink();
		for ($i = 1; $i <= $pageCount; $i++) {
			$page = $i;
			
			if ($this->currentPage == $page) {
				$outItem = $this->Html->tag($disabledTag, $page);
				$out .= $this->Html->tag($tag, $outItem, array('class' => $disabledClass));
			} else {
				$page = $i == 1 ? "" : '/'.$i;
				$outItem = $this->Html->link($i, $paginationLink.$page, array('class' => $tagClass));
				$out .= $this->Html->tag($tag, $outItem, array('class' => $tagClass));
			}
			
		}
		
		return $out;
	}
	
	
/**
 * 	@return - pagination link based on current page
 *  	
 */	
	private function getPaginationLink() {
		$paginationLink = $this->here;
		if ($this->currentPage != 1) {
			return mb_substr($paginationLink, 0, mb_strlen($paginationLink, 'UTF-8')-strlen($this->currentPage)-1);
		}
		
		return $paginationLink;
	}
	
}
