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
	 *         couldn't be opened or the supplied user name and password were not
	 *         recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO ( "mysql:host=$this->host;dbname=$this->database", $this->userName, $this->password );
			$this->conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch ( PDOException $e ) {
			$error = "Connection error: " . $e->getMessage ();
			print $error . "<p>";
			unset ( $this->conn );
			return false;
		}
		return true;
	}
	
	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset ( $this->conn );
	}
	
	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset ( $this->conn );
	}
	
	/**
	 * Execute a database query (select).
	 *
	 * @param $query The
	 *        	query string (SQL), with ? placeholders for parameters
	 * @param $param Array
	 *        	with parameters
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->prepare ( $query );
			$stmt->execute ( $param );
			$result = $stmt->fetchAll ();
		} catch ( PDOException $e ) {
			$error = "*** Internal error: " . $e->getMessage () . "<p>" . $query;
			die ( $error );
		}
		return $result;
	}
	
	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The
	 *        	query string (SQL), with ? placeholders for parameters
	 * @param $param Array
	 *        	with parameters
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		try {
			$stmt = $this->conn->prepare ( $query );
			$stmt->execute ( $param );
			$affected_rows = $stmt->rowCount ();
			// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch ( PDOException $e ) {
			$error = "*** Internal error: " . $e->getMessage () . "<p>" . $query;
			return 0;
			// die ( $error );
		}
		
		return $affected_rows;
	}
	
	/**
	 * Check if a user with the specified user id exists in the database.
	 * Queries the Users database table.
	 *
	 * @param
	 *        	userId The user id
	 * @return true if the user exists, false otherwise.
	 */
	public function userExists($userId) {
		$sql = "SELECT username FROM users WHERE username = ?";
		$result = $this->executeQuery ( $sql, array (
				$userId 
		) );
		return count ( $result ) == 1;
	}
	public function createPallets($cookie, $amount) {
		$sql = "INSERT INTO pallets values(0,?,NULL,FALSE,'in production')";
		$param = array ();
		array_push ( $param, $cookie );
		
		$count = 0;
		
		for($i = 0; $i < $amount; $i ++) {
			try {
				// transaction
				$this->conn->beginTransaction ();
				if ($this->enoughIngredientsForOnePallet ( $cookie )) {
					$count = $count + $this->executeUpdate ( $sql, $param );
				}
				$this->conn->commit ();
			} catch ( PDOException $e ) {
				// echo $e->getMessage ();
			}
		}
		
		return $count;
	}
	public function enoughIngredientsForOnePallet($cookie) {
		$sql = "SELECT amount_in_storage, amount, ingredient FROM Recipes natural join ingredients WHERE cookie = ?";
		$param = array ();
		array_push ( $param, $cookie );
		$result = $this->executeQuery ( $sql, $param );
		
		foreach ( $result as $row ) {
			
			if ($row [0] < ($row [1] * 54)) {
				$this->conn->rollBack ();
				return false;
			} else {
				// ta bort ingredients-amount
				$sql = "UPDATE ingredients SET amount_in_storage = amount_in_storage - ? WHERE ingredient = ?";
				$param = array (
						$row [1] * 54,
						$row [2] 
				);
				$this->executeUpdate ( $sql, $param );
			}
		}
		return true;
	}
	public function block($result) {
		$sql = "UPDATE pallets SET is_blocked = true WHERE pallet_id = ?";
		
		foreach ( $result as $row ) {
			
			if (!$row [3]) {
				
				$param = array (
						$row [0] 
				);
				$this->executeUpdate ( $sql, $param );
			}
		}
	}
	public function unBlock($result) {
		$sql = "UPDATE pallets SET is_blocked = false WHERE pallet_id = ?";
		
		foreach ( $result as $row ) {
			
			if ($row [3]) {
				
				$param = array (
						$row [0] 
				);
				$this->executeUpdate ( $sql, $param );
			}
		}
	}
	
	// public function getProductionSearchResult($cookie = null, $start_date = null, $end_date = null,$pallet_id = null,$block = null){
	public function getProductionSearchResult($cookie, $start_date, $end_date, $pallet_id, $block) {
		$param = array ();
		
		$first = true;
		
		$results = null;
		
		if ($block != null) {
			
			$sql = "SELECT * FROM PALLETS WHERE 1 = 1 ";
			
			if ($cookie != null) {
				$sql .= "AND cookie = ? ";
				array_push ( $param, $cookie );
			}
			if ($start_date != null) {
				$sql .= "AND date_produced > ? ";
				array_push ( $param, $start_date );
			}
			if ($end_date != null) {
				$sql .= "AND date_produced < ? ";
				array_push ( $param, $end_date );
			}
			if ($pallet_id != null) {
				$sql .= "AND pallet_id = ? ";
				array_push ( $param, $pallet_id );
			}
			
			if ($block == "not_blocked") {
				$block = false;
				$sql .= "AND is_blocked = ? ";
				array_push ( $param, $block );
			}
			
			if ($block == "blocked") {
				$block = true;
				$sql .= "AND is_blocked = ? ";
				array_push ( $param, $block );
			}
			
			$result = $this->executeQuery ( $sql, $param );
		}
		
		return $result;
	}
}
?>
