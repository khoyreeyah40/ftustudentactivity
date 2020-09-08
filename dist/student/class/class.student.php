<?php

require_once('../../db/dbconfig1.php');

class STUDENT
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function doLogin($stdID,$stdPassword)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT stdID, stdPassword FROM student WHERE stdID=:stdID ");
			$stmt->execute(array(':stdID'=>$stdID));
			$stdRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($stdPassword == $stdRow['stdPassword'])
				{
					$_SESSION['std_session'] = $stdRow['stdID'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['std_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['std_session']);
		return true;
	}
}
?>