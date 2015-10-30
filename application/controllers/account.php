<?php
namespace application\controllers;
use application\models\Users;
use system\Controller;
use system\View;
use system\Session;
use \Exception;

class Account extends Controller {

	public $restful = true;


	public function get_index($arg)
	{
		$this->get_login($arg);
	}

	public function get_login($arg)
	{
		View::make('account.login', $this->data);
	}

	public function post_login($arg)
	{
		try {
			if (!isset($_POST["cemail"]) || !isset($_POST["cpassword"]))
				throw new Exception('Champ non complet');

			if(Users::connexion($_POST["cemail"], $_POST["cpassword"])){
				\system\Session::setFlash("<strong>Info:</strong> Vous vous êtes connecté avec succès!", "success");

				$this->login = new Users(Session::get('user_id'));
				$this->data['loged'] = true;
				$this->data['member'] = $this->login;
				echo json_encode(
					array(
						'success'=>addslashes('Vous vous êtes connecté avec succès!')
					)
				);
			}
		}
		catch(Exception $e){
			echo json_encode(
				array(
					'danger'=>$e->getMessage()
				)
			);
		}
	}

	public function post_register()
	{
		try {
			if (!isset($_POST["rpseudo"]) || !isset($_POST["rnom"]) || !isset($_POST["rprenom"]) || !isset($_POST["rbirthday"]) || !isset($_POST["rville"]) || !isset($_POST["rdep"]) || !isset($_POST["rregion"]) || !isset($_POST["rpays"]) || !isset($_POST["remail"]) || !isset($_POST["rsexe"]) || !isset($_POST["rpassword"]) || !isset($_POST["rpassword2"])
			|| empty($_POST["rpseudo"]) || empty($_POST["rnom"]) || empty($_POST["rprenom"]) || empty($_POST["rbirthday"]) || empty($_POST["rville"]) || empty($_POST["rdep"]) || empty($_POST["rregion"]) || empty($_POST["rpays"]) || empty($_POST["remail"]) || empty($_POST["rsexe"]) || empty($_POST["rpassword"]) || empty($_POST["rpassword2"]))
				throw new Exception('Tous les champs ne sont pas remplis');

			$random = '';

			if(!Users::inscription($_POST["rpseudo"], $_POST["rnom"], $_POST["rprenom"], $_POST["rbirthday"], $_POST["rville"], $_POST["rdep"], $_POST["rregion"], $_POST["rpays"], $_POST["remail"], $_POST["rsexe"], $_POST["rpassword"], $_POST["rpassword2"], $random))
				throw new Exception('Une erreur est survenue, veuillez rééssayer ultérieurement ou contacter un développeur sur le forum.');

			require 'system/vendor/PHPMailer/PHPMailerAutoload.php';

			//Create a new PHPMailer instance
			$mail = new \PHPMailer();

			$mail->isSMTP();

			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->Username = "villers.mickael@gmail.com";
			$mail->Password = "****";

			$mail->setFrom('villers.mickael@gmail.com', 'My Meetic');
			$mail->addAddress($_POST["remail"], $_POST["rpseudo"]);
			$mail->Subject = 'Validation de l\'inscription';

			//Replace the plain text body with one created manually
			$message =  "Bonjour {$_POST['rpseudo']},\n";
			$message .= "Ton inscription est prise en compte, merci de cliquer sur ce lien  suivant pour le valider:\n";
			$message .= "<a href=\"{$this->data['base_url']}account/register/{$_POST['rpseudo']}/".$random."\">Lien de validation</a>";
			$mail->MsgHTML($message);

			//send the message, check for errors
			if (!$mail->send()) {
			    echo json_encode(array('danger'=>'Le mail n\'a pas été envoyé', 'info' => $mail->ErrorInfo));
			} else {
			    echo json_encode(array('success'=>'Le compte '.$_POST["rpseudo"].' a bien été créé! <br/>Vous pouvez dès à présent vous connecter', 'info' => $message));
			}
		}
		catch(Exception $e){
			echo json_encode(array('danger'=>$e->getMessage()));
		}
	}

	public function get_register($arg)
	{
		try {
			if(count($arg) != 2)
				throw new Exception('Le lien est imcomplet');

			if(!Users::checkToken($arg))
				throw new Exception('Le lien est incorrect');

			Session::setFlash('Votre compte a bien été activé!', 'success');

		}
		catch(Exception $e){
			Session::setFlash($e->getMessage(), 'danger');
		}
		View::make('account.login', $this->data);
	}

	public function get_logout()
	{
		Users::deconnexion();
		\system\Router::redirect($this->data['base_url']);
	}
}
