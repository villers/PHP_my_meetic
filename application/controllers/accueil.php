<?php
namespace application\controllers;
use system\Controller;
use system\View;
use application\models\Users;

class Accueil extends Controller {

	public $restful = true;

	public function get_index($arg)
	{

        $users = new Users();
        $this->data['users'] = $users->find(array('conditions'=> array('validation'=> '1', '
            state'=>'0')));

		View::make('accueil.index', $this->data);
	}
}