<?php

namespace system\helper;

class Pagination{
	public $nbhide = 999;
	public $showlimit = false;
	public $endurl = "";

	public function __construct( $num_results=null, $limit=null, $page=null )
	{
		if( !is_null( $num_results ) && !is_null( $limit ) && !is_null( $page ) )
		{
			$this->num_results = $num_results;
			$this->limit = $limit;
			$this->page = $page;
			$this->run();
		}
	}

	public function __set( $name, $value )
	{
		switch( $name )
		{
			case 'menu_link_suffix':
			case 'num_results':
			case 'menu_link':
			case 'css_class':
			case 'num_pages':
			case 'offset':
			case 'limit':
			case 'page':
			case 'nbhide':
			case 'endurl':
			$this->$name = $value;
			break;

			default: throw new \Exception( "Unable to set $name" );
		}
	}

	public function __get( $name )
	{
		switch( $name )
		{
			case 'menu_link_suffix':
			case 'num_results':
			case 'menu_link':
			case 'css_class':
			case 'num_pages':
			case 'offset':
			case 'limit':
			case 'page':
			case 'nbhide':
			case 'endurl':
			return $this->$name;
			break;

			default: throw new \Exception( "Unable to get $name" );
		}
	}

	public function run()
	{

		$this->num_pages = ceil( $this->num_results / $this->limit );
		$this->page = max( $this->page, 1 );
		$this->page = min( $this->page, $this->num_pages );
		$this->offset = ( $this->page - 1 ) * $this->limit;
		if($this->num_pages < 0) $this->num_pages = 0;
		if($this->offset < 0) $this->offset = 0;
	}

	public function __toString()
	{
		if($this->offset == 0 && $this->num_pages == 0)
			return "";


		$menu = '<ul';
		$menu .= isset( $this->css_class ) ? ' class="'.$this->css_class.'"' : '';
		$menu .= '>';

		// si ce n'est pas la 1er page
		if($this->page != 1)
		{
			$menu .= '<li><a href="'.$this->menu_link;
			$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
			$menu .= '/page/' . 1 .'/' . $this->endurl;
			$menu .= '">First: 1</a></li>';

			$menu .= '<li><a href="'.$this->menu_link;
			$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
			$menu .=  '/page/' . ( $this->page - 1 ) .'/' . $this->endurl;
			$menu .= '">&laquo;</a></li>';
		}

		/// affichage des pages
		for( $i = 1; $i <= $this->num_pages; $i++ )
		{
			if( $i == $this->page )
			{
				$menu .= '<li class="active"><a href="'.$this->menu_link;
				$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
				$menu .= '/page/'.$i .'/' . $this->endurl;
				$menu .= '">'.$i.'</a></li>';
			}
			elseif($i >= $this->page - $this->nbhide && $i <= $this->page + $this->nbhide)
			{
				$menu .= '<li><a href="'.$this->menu_link;
				$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
				$menu .= '/page/'.$i .'/' . $this->endurl;
				$menu .= '">'.$i.'</a></li>';
			}
		}

		// Si ce n'est pas la derniere page
		if( $this->page < $this->num_pages )
		{
			$menu .= '<li><a href="'.$this->menu_link;
			$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
			$menu .= '/page/' . ( $this->page + 1 ) .'/' . $this->endurl;
			$menu .= '">&raquo;</a></li>';

			$menu .= '<li><a href="'.$this->menu_link;
			$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
			$menu .= '/page/' . ( $this->num_pages ) .'/' . $this->endurl;
			$menu .= '">Last: <em>' . ( $this->num_pages ) . '</em></a></li>';
		}

		$menu .= '</ul>';
		return $menu;
	}

}
?>
