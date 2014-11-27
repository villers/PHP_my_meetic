<?php
namespace application\models;
use system\Model;
use system\helper\Input;
use system\Session;
use \Exception;

class Users extends Model
{
	public $user_id;
	public $pseudo;
	public $password;
	public $nom;
	public $prenom;
	public $email;
	public $anniversaire;
	public $ville;
	public $departement;
	public $region;
	public $pays;
	public $created;
	public $token;
	public $validation;
	static $salt = 'H76]]-%6]-TmB-p';

	function __construct($user_id = null)
	{
		parent::__construct();

		if(!is_null($user_id))
		{
			$ligne = $this->select("SELECT * FROM users where user_id = :user_id", array(':user_id' =>$user_id));
			$ligne = current($ligne);
			// Si ligne !== false le membre existe
			if($ligne !== FALSE)
			{
				$this->user_id = $ligne->user_id;
				$this->pseudo = $ligne->pseudo;
				$this->password = $ligne->password;
				$this->nom = $ligne->nom;
				$this->prenom = $ligne->prenom;
				$this->email = $ligne->email;
				$this->anniversaire = $ligne->anniversaire;
				$this->ville = $ligne->ville;
				$this->departement = $ligne->departement;
				$this->region = $ligne->region;
				$this->pays = $ligne->pays;
				$this->created = $ligne->created;
				$this->token = $ligne->token;
				$this->validation = $ligne->validation;
			}
		}
	}

	public static function inscription($rpseudo, $rnom, $rprenom, $rbirthday, $rville, $rdep, $rregion, $rpays, $remail, $rsexe, $rpassword, $rpassword2, &$random)
	{
		// Connexion sql
		$pdo = new Users();

		if(Input::inject(array($rpseudo, $rnom, $rprenom, $rbirthday, $rville, $rdep, $rregion, $rpays, $remail, $rsexe, $rpassword)))
			throw new Exception('Vous avez saisi des carractères incorects');

		if (strlen(trim($rpseudo)) < 4 || strlen(trim($rpseudo)) > 23)
			throw new Exception('Le nom d\'utilisateur choisi est trop court');

		if (preg_match('/[^a-zA-Z0-9_]/', $rpseudo))
			throw new Exception('Les caractères autorisés pour le nom de compte sont: a-Z_0-9');

		if(strlen(trim($rpassword)) < 4 || strlen(trim($rpassword)) > 23)
			throw new Exception('Le mot de passe choisi est trop court');

		if (!strcmp($rpassword, $rpseudo))
			throw new Exception('Désolé, votre pseudo et votre mot de passe ne peuvent être identiques.');

		if (strcmp($rpassword, $rpassword2))
			throw new Exception('Désolé, vous n\'avez pas entré deux fois le même mot de passe.');

		if(!filter_var($remail, FILTER_VALIDATE_EMAIL))
			throw new Exception('L\'adresse email est invalide.');

		if(static::pseudoDejaUtilise($rpseudo))
			throw new Exception('Ce nom d\'utilisateur est déjà utilisé par un autre compte.');

		if(static::emailDejaUtilise($remail))
			throw new Exception('Cette adresse email est déjà utilisé par un autre compte.');

		if(input::getAge($rbirthday) < 18)
			throw new Exception('Désolé tu es trop jeune.');

		if($rsexe == 'F')
			$rsexe = 'F';
		elseif($rsexe == 'M')
			$rsexe = 'M';
		else
			$rsexe = 'A';

		$random = $pdo->random();
		return $pdo->insert(array('pseudo' => $rpseudo, 'password' => md5($rpassword), 'nom' => $rnom, 'prenom' => $rprenom, 'email' => $remail, 'sexe' => $rsexe, 'anniversaire' => $rbirthday, 'ville' => $rville, 'departement' => $rdep, 'region' => $rregion, 'pays' => $rpays, 'token' => $random, 'validation' => 0, 'state' => 0));
	}

	public static function checkToken($arg) // array(login, token)
	{
		if(Input::inject($arg))
			throw new Exception('Carractères incorectes');

		// Connexion sql
		$pdo = new Users();

		if($account = $pdo->findFirst(array('fields' => 'user_id', 'conditions'=>array('pseudo'=> $arg[0], 'token' => $arg[1]))))
			return $pdo->update(array('validation' => '1', 'token' => NULL), array('user_id' => $account->user_id));

		return false;
	}

	public static function emailDejaUtilise($email)
	{
		// Connexion sql
		$pdo = new Users();
		$ligne = $pdo->findFirst(array('fields' => 'user_id', 'conditions'=> array('email' => $email)));

		//Si il y a un résultat c'est que l'email est déjà utilisée
		//print_r($ligne);
		return ($ligne !== FALSE)? true: false;
	}

	public static function pseudoDejaUtilise($pseudo)
	{
		// Connexion sql
		$pdo = new Users();
		$ligne = $pdo->findFirst(array('fields' => 'user_id', 'conditions'=> array('pseudo' => $pseudo)));

		//Si il y a un résultat c'est que l'email est déjà utilisée
		//print_r($ligne);
		return ($ligne !== FALSE)? true: false;
	}

	public static function connexion($pseudo, $password)
	{
		$retour = false;

		// Connexion sql
		$pdo = new Users();

		// Anti injection
		if(Input::inject(array($pseudo, $password)))
			throw new Exception('Les caractères saisis sont incorrects');

		//Si il y a un résultat c'est que l'utilisateur c'est bien connecté
		if(($ligne = $pdo->findFirst(array('fields' => 'user_id', 'conditions'=> array('pseudo' => $pseudo, 'password' => md5($password), 'validation' => 1, 'state' => 0)))) !== FALSE)
		{
			Session::set('user_id', $ligne->user_id);
			$retour = true; //On retourne true pour dire que tout c'est bien passé
		}
		elseif(($ligne = $pdo->findFirst(array('fields' => 'user_id', 'conditions'=> array('email' => $pseudo, 'password' => md5($password), 'validation' => 1, 'state' => 0)))) !== FALSE)
		{
			Session::set('user_id', $ligne->user_id);
			$retour = true; //On retourne true pour dire que tout c'est bien passé
		}
		//Sinon c'est que le mot de passe ou le nom d'utilisateur n'est pas bon
		else
		{
			if($pdo->count(array('pseudo'=>$pseudo, 'validation' => 0)) || $pdo->count(array('email'=>$pseudo, 'validation' => 0)))
				throw new Exception('Votre compte n\'est pas encore activé');
			elseif($pdo->count(array('pseudo'=>$pseudo, 'state' => 1)) || $pdo->count(array('email'=>$pseudo, 'state' => 1)))
				throw new Exception('Votre compte a été banni');
			elseif($pdo->count(array('pseudo'=>$pseudo, 'state' => 2)) || $pdo->count(array('email'=>$pseudo, 'state' => 2)))
				throw new Exception('Votre compte a été supprimé');
			else
				throw new Exception('Le nom d\'utilisateur ou le mot de passe ne correspond pas');
		}
		return $retour;
	}

	public static function deconnexion(){
		Session::destroy();
		return (Session::get('user_id') == false) ?  false : true;
	}

	public function sauvegarderLUtilisateur()
	{
		return $this->update(array('nom' => $this->nom, 'prenom' => $this->prenom, 'date_naissance' => $this->date_naissance, 'email' => $this->email, 'password' => $this->password, 'adresse' => $this->adresse, 'cpostal' => $this->cpostal, 'ville' => $this->ville, 'pays' => $this->pays, 'statut' => $this->statut), array('user_id'=>$this->user_id));
	}

	public static function supprimerLUtilisateur($user_id)
	{
		$pdo = new Users();
		return $pdo->delete(array('user_id'=>$user_id));
	}

	public static function isLoged()
	{
		return isset($_SESSION['user_id']);
	}

	private function random()
	{
		srand();
		return md5(rand());
	}
}