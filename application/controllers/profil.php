<?php
namespace application\controllers;
use system\Controller;
use system\View;
use system\Router;
use system\Session;
use system\helper\Input;
use application\models\Users;
use application\models\Messages;

class Profil extends Controller {

	public $restful = true;

	public function get_index($arg)
	{
		$this->get_get($arg);
	}

	public function get_get($arg)
	{
		if(!isset($arg[0]))
			Router::redirect($this->data['base_url']);

		$users = new Users();
		$this->data['user'] = $users->findFirst(array('conditions'=> array('user_id'=> $arg[0])));
		$this->data['messages_received'] = $users->select("select a.messages_id, a.from_user_id, a.body, a.created, a.state, b.pseudo, b.user_id
															FROM messages AS a
															INNER JOIN users AS b
															ON a.from_user_id = b.user_id
															WHERE a.to_user_id = :to_user_id AND a.trash = 0
															", array(':to_user_id'=> $arg[0]));

		$this->data['messages_send'] = $users->select("select a.messages_id, a.from_user_id, a.body, a.created, a.state, b.pseudo, b.user_id
														FROM messages AS a
														INNER JOIN users AS b
														ON a.from_user_id = b.user_id
														WHERE a.from_user_id = :from_user_id AND a.trash = 0
														", array(':from_user_id'=> $this->login->user_id));

		$this->data['id_prifile'] = $arg[0];

		if(empty($this->data['user']))
			Router::redirect($this->data['base_url']);

		$users->update(array('state'=> 1), array('to_user_id' => $arg[0]), 'messages');

		View::make('profil.index', $this->data);
	}

	public function get_update($arg)
	{
		if(!isset($arg[0]))
			Router::redirect($this->data['base_url']);

		if($this->login->user_id != $arg[0])
		{
			Session::setFlash('Vous ne pouvez pas éditer ce compte!', 'danger');
			$this->get_get($arg);
			return ;
		}

		$users = new Users();
		$this->data['user'] = $users->findFirst(array('conditions'=> array('user_id'=> $arg[0])));

		if(empty($this->data['user']))
			Router::redirect($this->data['base_url']);

		View::make('profil.update', $this->data);
	}

	public function post_update($arg)
	{
		if(!isset($arg[0]))
			Router::redirect($this->data['base_url']);

		if(Input::inject(array($_POST['ville'], $_POST['departement'], 'region'=>$_POST['region'], $_POST['pays'], $_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['email'], $_POST['description']))){
			Session::setFlash('Vous avez saisi des carractères incorects', 'danger');
			Router::redirect($this->data['base_url']."profil/update/".$arg[0]);
		}


		if($this->login->user_id != $arg[0])
		{
			Session::setFlash('Vous ne pouvez pas éditer ce compte!', 'danger');
			$this->get_get($arg);
			return ;
		}

		if(!empty($_FILES['avatar']['name']))
		{
			$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
			$extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'),1));
			if (!in_array($extension_upload,$extensions_valides))
			{
				Session::setFlash('L\'extension de l\'image est incorect!', 'danger');
				Router::redirect($this->data['base_url']."profil/update/".$arg[0]);
			}

			$nom = $this->data['assets'].'upload/'.$arg[0].'.png';
			$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'],$nom);
			if (!$resultat)
			{
				Session::setFlash('Upload de l\'image ne fonctionne pas!', 'danger');
				Router::redirect($this->data['base_url']."profil/update/".$arg[0]);
			}
		}

		$users = new Users();
		$users->update(array('ville'=>$_POST['ville'], 'departement'=>$_POST['departement'], 'region'=>$_POST['region'], 'pays'=>$_POST['pays'], 'nom'=>$_POST['nom'], 'prenom'=>$_POST['prenom'], 'pseudo'=>$_POST['pseudo'], 'email'=>$_POST['email'], 'description'=> trim($_POST['description'])) ,array('user_id'=> $arg[0]));

		if(!empty($_POST['password']))
			$users->update(array('password'=>md5($_POST['password'])) ,array('user_id'=> $arg[0]));

		Session::setFlash('L\édition du compte a réussi!', 'info');
		Router::redirect($this->data['base_url']."profil/get/".$arg[0]);
	}

	public function get_delete($arg)
	{
		if(!isset($arg[0]))
			Router::redirect($this->data['base_url']);

		if($this->login->user_id != $arg[0])
		{
			Session::setFlash('Vous ne pouvez pas supprimer ce compte!', 'danger');
			$this->get_get($arg);
			return ;
		}

		$users = new Users();
		$users->update(array('state'=>2), array('user_id'=>$arg[0]));

		Router::redirect($this->data['base_url']."account/logout");
	}

	public function get_send_mail($arg)
	{
		if(!isset($arg[0]))
			Router::redirect($this->data['base_url']);

		$this->data['message_id'] = $arg[0];

		View::make('profil.send_mail', $this->data);
	}

	public function post_send_mail($arg)
	{
		if(!isset($arg[0]))
			Router::redirect($this->data['base_url']);

		if(empty($_POST['description']))
		{
			Session::setFlash('Vous ne pouvez pas envoyer de message vide!', 'danger');
			Router::redirect($this->data['base_url']."profil/send_mail/".$arg[0]);
		}

		$message = new Messages();
		$message->insert(array('body'=> htmlentities($_POST['description']), 'to_user_id'=>$arg[0], 'from_user_id' => $this->login->user_id));

		Session::setFlash('Votre message a bien été envoyé!', 'info');
		Router::redirect($this->data['base_url']."profil/get/".$this->login->user_id);
	}

	public function get_delete_mail($arg)
	{
		if(!isset($arg[0]) || !isset($arg[1]))
			Router::redirect($this->data['base_url']);

		if($this->login->user_id != $arg[0])
		{
			Session::setFlash('Vous ne pouvez pas supprimer ce message!', 'danger');
			$this->get_get($arg);
			return ;
		}

		$message = new Messages();
		$message->update(array('trash'=>2), array('to_user_id'=>$arg[0], 'messages_id' => $arg[1]), 'messages');

		Session::setFlash('La suppression du mail a réussi!', 'info');
		Router::redirect($this->data['base_url']."profil/get/".$arg[0]);
	}
}