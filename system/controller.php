<?php
namespace system;
use application\models\Users;
use system\Router;

abstract class Controller {

	// si vrai la fonction peu être appelé par le type de request
	// ex: get_index(), post_index(), put_index() or delete_index()
	public $restful = false;

	protected $data = array();
	public $login;

	public function __construct()
	{
		$this->data =  Config::$application;
		$this->data['loged'] = false;
		$pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
		if(Users::isLoged())
		{
			$this->login = new Users(Session::get('user_id'));
			$this->data['loged'] = true;
			$this->data['member'] = $this->login;
		}elseif(!Users::isLoged() && $pathinfo != '/account/login' && $pathinfo != '/account/logout' && $pathinfo != '/account/register' && !preg_match("#account/register#", $pathinfo))
			Router::redirect($this->data['base_url'].'account/login');
	}
}