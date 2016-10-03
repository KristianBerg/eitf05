<?php
/*
 * Class Database: interface to the movie database from PHP.
 *
 * You must:
 *
 * 1) Change the function userExists so the SQL query is appropriate for your tables.
 * 2) Write more functions.
 *
 */
class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;

	/**
	 * Constructs a database object for the specified user.
	 */
	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}

	/**
	 * Opens a connection to the database, using the earlier specified user
	 * name and password.
	 *
	 * @return true if the connection succeeded, false if the connection
	 * couldn't be opened or the supplied user name and password were not
	 * recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database",
					$this->userName,  $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error = "Connection error: " . $e->getMessage();
			print $error . "<p>";
			unset($this->conn);
			return false;
		}
		return true;
	}

	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset($this->conn);
	}

	/**
	 * Execute a database query (select).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->query($query);
			// $stmt = $this->conn->prepare($query);
			// $stmt->execute($param);
			$result = $stmt->fetchAll();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}

	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		$affectedRows = 0;
		try{
			$stmt = $this->conn->query($query);
			// $stmt = $this->conn->prepare($query);
			// $stmt->execute($param);
			$rows = $stmt->rowCount();
		} catch(PDOException $e){
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $rows;
	}

	/**
	 * Check if a user with the specified user id exists in the database.
	 * Get that users cool hashed password.
	 * Compares that cool hashed password against the inputed clear text one.
	 * (With the use of the standard PHP hash verify function, OFC).
	 * Queries the Users database table.
	 *
	 * @param userId The user id
	 * @param password The users inputed radical password
	 * @return true if the user exists, false otherwise.
	 */
	public function userExists($userId, $password) {
		$sqlgetpass = "SELECT Pass_hash FROM logins WHERE Username = '" . $userId . "'";
		$result1 = $this->executeQuery($sqlgetpass);
		$hashedPass;
		foreach ($result1 as $row){
			$hashedPass = $row['Pass_hash'];
		}
		if (password_verify($password, $hashedPass)) {
			return true;
		} else {
			return false;
		}
	}

	public function usernameExists($username) {
		$sql = "SELECT Username FROM logins WHERE Username = '" . $username . "'";
		$result = $this->executeQuery($sql);
		return count($result) == 1;
	}

	/*
		Vi hashar med PHP standard rekomenderade hash. Denna Autogenerar Salt men kan checkas genom en verify funktion
	*/
	public function registerUser($userId, $password, $address ){
		$hashedPass = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO logins VALUES('" . $userId . "', '" . $address . "', '" . $hashedPass . "')";
		$result = $this->executeUpdate($sql);
	}

	public function addToCart($userId, $item, $quantity) {
		$sql = "INSERT INTO carts VALUES((SELECT Username FROM logins WHERE Username = '" . $userId . "'), (SELECT Prod_id FROM products WHERE Prod_id = '" . $item . "'), '"
		. $quantity . "') ON DUPLICATE KEY UPDATE Quantity = '" . $quantity . "'";
		$this->executeUpdate($sql);
	}

	public function getCart($userId) {
		$sql = "SELECT Prod_id, Quantity FROM carts WHERE Username = '" . $userId . "'";
		$dbResult = $this->executeQuery($sql);
		$result = [];
		$index = 0;
		foreach($dbResult as $row) {
			$columns = array('Prod_id'=>$row['Prod_id'], 'Quantity'=>$row['Quantity']);
			$result[$index] = $columns;
			$index++;
		}
		return $result;
	}

	public function emptyCart($userId) {
		$sql = "DELETE FROM carts WHERE Username = '" . $userId . "'";
		$this->executeUpdate($sql);
	}

	public function getProducts() {
		$sql = "SELECT * FROM products";
		$dbResult = $this->executeQuery($sql);
		$result = [];
		foreach($dbResult as $row) {
			$columns = array('Prod_name'=>$row['Prod_name'], 'Price'=>$row['Price'], 'Description'=>$row['Description'], 'Image_src'=>$row['Image_src']);
			$result[$row['Prod_id']] = $columns;
		}
		return $result;
	}
}
?>
