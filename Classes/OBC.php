<?php
class OBC {

	function PDODBConnection($sql) {
		$upom = parse_ini_file('upom.ini');
		try {
			$conn = new PDO("mysql:host=" . $upom['host'] . ";dbname=" . $upom['dbname'], $upom['username'], $upom['password']);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$ret = $conn->query($sql);
			//echo "Connected successfully<br/>";
			$conn = null;
			return $ret;
		} catch(PDOException $e) {
			error_log("Connection failed: " . $e->getMessage());
		}
	}

	function DBQuote($value) {
		$upom = parse_ini_file('upom.ini');
		$conn = mysqli_connect($upom['host'], $upom['username'], $upom['password']);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$ret = "'" . mysqli_real_escape_string($conn,$value) . "'";
		//echo "Connected successfully<br/>";
		$conn = null;
		return $ret;
	}
}
?>