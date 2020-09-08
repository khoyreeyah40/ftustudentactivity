<?php

require_once('../../db/dbconfig1.php');

class ORGANIZER
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

	public function doLogin($orgzerID, $orgzerPassword)
	{
		try {
			$stmt = $this->conn->prepare("SELECT orgzerID, orgzerPassword FROM organizer WHERE orgzerID=:orgzerID ");
			$stmt->execute(array(':orgzerID' => $orgzerID));
			$orgzerRow = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() == 1) {
				if ($orgzerPassword == $orgzerRow['orgzerPassword']) {
					$_SESSION['orgzer_session'] = $orgzerRow['orgzerID'];
					return true;
				} else {
					return false;
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function is_loggedin()
	{
		if (isset($_SESSION['orgzer_session'])) {
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
		unset($_SESSION['orgzer_session']);
		return true;
	}
}
