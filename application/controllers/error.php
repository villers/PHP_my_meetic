<?php
namespace application\controllers;
use system\Controller;
use system\View;

class Error extends Controller {

	public function index() {
		View::make('error.404', $this->data);
	}

	public function action_401() {
		View::make('error.401', $this->data);
	}

}