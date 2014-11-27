<?php
namespace system;
use \PDO;
use \PDOException;

abstract class Model
{
	protected $pdo;

	protected $primaryKey;
	protected $id;
	private $table = false;

	function __construct()
	{
		if($this->table === false)
		{
			$classname = explode("\\", get_class($this));
			$this->table = strtolower(array_pop($classname));
		}

		$this->pdo = Pdo2::getInstance();
		$this->primaryKey = $this->table."_id";
	}

	// $login->select("select * from login where id_login = :login", array(':login'=> 1))
	public function select($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ)
	{
		$stmt = $this->pdo->prepare($sql);
		foreach($array as $key => $value)
			$stmt->bindValue("$key", $value);

		$stmt->execute();
		return $stmt->fetchAll($fetchMode);
	}

	// $login->select("select * from login where id_login = :login", array(':login'=> 1))
	public function selectOne($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ)
	{
		$stmt = $this->pdo->prepare($sql);
		foreach($array as $key => $value)
			$stmt->bindValue("$key", $value);

		$stmt->execute();
		return $stmt->fetch($fetchMode);
	}

	// Permet de récupérer plusieurs enregistrements
	// $login->find(array('fields' => 'id_login, password','conditions'=> array('username'=> 'test')))
	public function find($req = array())
	{
		$sql = 'SELECT ';

		if(isset($req['fields'])){
			if(is_array($req['fields'])){
				$sql .= implode(', ',$req['fields']);
			}else{
				$sql .= $req['fields'];
			}
		}else{
			$sql.='*';
		}

		$sql .= " FROM {$this->table} ";

		// Liaison
		if(isset($req['join'])){
			foreach($req['join'] as $k=>$v){
				$sql .= " LEFT JOIN {$k} ON {$v}";
			}
		}

		// Construction de la condition
		if(isset($req['conditions'])){
			$sql .= 'WHERE ';
			if(!is_array($req['conditions'])){
				$sql .= $req['conditions'];
			}else{
				$cond = array();
				foreach($req['conditions'] as $k=>$v){
					if(!is_numeric($v)){
						$v = $this->pdo->quote($v);
					}

					$cond[] = "$k like $v";
				}
				$sql .= implode(' AND ',$cond);
			}

		}

		if(isset($req['order'])){
			$sql .= " ORDER BY {$req['order']}";
		}

		if(isset($req['limit'])){
			$sql .= " LIMIT {$req['limit']}";
		}

		//echo $sql;
		$pre = $this->pdo->prepare($sql);
		$pre->execute();
		return $pre->fetchAll(PDO::FETCH_OBJ);
	}

	// Alias permettant de retrouver le premier enregistrement
	// $login->findFirst(array('fields' => 'id_login, password','conditions'=> array('username'=> 'test')))
	public function findFirst($req){
		return current($this->find($req));
	}

	// $login->insert(array('username'=>'viller_m', 'password'=>'password_viller_ssm2', 'email'=>'villers@hotmail.com'), 'login');
	public function insert($data, $table = null)
	{
		ksort($data);

		if(is_null($table))
			$table = $this->table;

		$fieldNames = implode(',', array_keys($data));
		$fieldValues = ':'.implode(', :', array_keys($data));

		$stmt = $this->pdo->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

		foreach($data as $key => $value)
			$stmt->bindValue(":$key", $value);

		/*try {
			$stmt->execute();
		} catch (PDOException $e) {
			return false;
		}
		return true;*/

		return $stmt->execute();
	}

	// $login->update(array('username'=>'viller_m', 'password'=>'password_viller_ssm2', 'email'=>'villers@hotmail.com'), array('username'=>'viller_m'), 'login');
	public function update($data, $where, $table = null)
	{
		ksort($data);

		if(is_null($table))
			$table = $this->table;

		$fieldDetails = NULL;
		foreach($data as $key => $value)
			$fieldDetails .= "$key = :$key,";
		$fieldDetails = rtrim($fieldDetails, ',');

		$whereDetails = NULL;
		foreach($where as $key => $value)
			$whereDetails .= " AND $key = :$key";
		$whereDetails = ltrim($whereDetails, ' AND ');

		$stmt = $this->pdo->prepare("UPDATE $table SET $fieldDetails WHERE $whereDetails");

		foreach($data as $key => $value)
			$stmt->bindValue(":$key", $value);

		foreach($where as $key => $value)
			$stmt->bindValue(":$key", $value);

		return $stmt->execute();
	}

	// $login->delete(array('username'=>'viller_m'));
	public function delete($where, $table = null, $limit = 1)
	{
		ksort($where);

		if(is_null($table))
			$table = $this->table;

		$whereDetails = NULL;
		foreach($where as $key => $value)
			$whereDetails .= " AND $key = :$key";
		$whereDetails = ltrim($whereDetails, ' AND ');

		$stmt = $this->pdo->prepare("DELETE FROM $table WHERE $whereDetails LIMIT $limit");

		foreach($where as $key => $value)
			$stmt->bindValue(":$key", $value);

		$stmt->execute();

	}

	public function count($where = array(1=>1),$table = null)
	{
		if(is_null($table))
			$table = $this->table;

		$whereDetails = NULL;
		foreach($where as $key => $value)
			$whereDetails .= " AND $key like :$key";
		$whereDetails = ltrim($whereDetails, ' AND ');

		$stmt = $this->pdo->prepare("SELECT count(*) as 'count' from $table WHERE $whereDetails");

		foreach($where as $key => $value)
			$stmt->bindValue(":$key", $value);

		$stmt->execute();
		$donnees = $stmt->fetch();
		return (isset($donnees['count'])) ? $donnees['count'] : 0;
	}
}