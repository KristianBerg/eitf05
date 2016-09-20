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
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
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
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$rows = $stmt->rowCount();
		} catch(PDOException $e){
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $rows;
	}
	
	/**
	 * Check if a user with the specified user id exists in the database.
	 * Queries the Users database table.
	 *
	 * @param userId The user id 
	 * @return true if the user exists, false otherwise.
	 */
	public function userExists($userId) {
		$sql = "select userName from users where userName = ?";
		$result = $this->executeQuery($sql, array($userId));
		return count($result) == 1; 
	}

	/*
	 * *** Add functions ***
	 */
	 public function getMovieNames(){
		 $sql = "select movieName FROM movies";
		 $dbresult = $this->executeQuery($sql);
		 
		 $result = [];
		 foreach($dbresult as $row){
			 array_push($result, $row['movieName']);
		 }
		 return $result;
	 }
	 public function getMovieDates($movieName){
		 $sql = "select pDate FROM performances WHERE movieName = ?";
		 $dbresult = $this->executeQuery($sql, array($movieName));
		 
		 $result = [];
		 foreach($dbresult as $row){
			 array_push($result, $row['pDate']);
		 }
		 return $result;
	 }
	 public function getTheater($movieName, $pDate){
		 $sql = "select theaterName from performances WHERE movieName = ? and pDate = ?";
		 $dbresult = $this->executeQuery($sql, array($movieName, $pDate));
		 $result = [];
		 foreach($dbresult as $row){
			 array_push($result, $row['theaterName']);
		 }
		 return $result[0];
	 }
	 public function getAvailabelSeats($movieName, $pDate){
		 $sql = "select availabelSeats from performances WHERE movieName = ? and pDate = ?";
		 $dbresult = $this->executeQuery($sql, array($movieName, $pDate));
		 $result = [];
		 foreach($dbresult as $row){
			 array_push($result, $row['availabelSeats']);
		 }
		 return $result[0];
	 }
	 public function getBookingNum($movieName, $pDate, $userName){
		 $sql = "select reservedID from reservations WHERE movieName = ? and pDate = ? and userName = ?";
		 $dbresult = $this->executeQuery($sql, array($movieName, $pDate, $userName));
		 $result = [];
		 foreach($dbresult as $row){
			 array_push($result, $row['reservedID']);
		 }
		 $num = count($result);
		 return $result[$num-1];
	 }
	 public function reserveTicket($movieName, $pDate, $userId){
		try{
			$this->conn->beginTransaction();
			
			$sql = "INSERT INTO reservations values(NULL,?,?,?)";
			
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(array($movieName, $userId, $pDate));
			
		} catch(PDOException $e){
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		
		$sql = "UPDATE performances SET availabelSeats = availabelSeats - 1 where movieName = ? and pdate = ?";	
		$this->executeUpdate($sql, array($movieName, $pDate));
		$seatsLeft = $this->getAvailabelSeats($movieName, $pDate);
		if($seatsLeft < 0){	
				$this->conn->rollBack();
				return -1;
			}
			else{
				$this->conn->commit();
			}
		return $this->getBookingNum($movieName, $pDate, $userId);
	}
}
?>
