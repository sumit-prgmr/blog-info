<?php
 $dbhost     = "localhost";
 $dbname     = "blog";
 $dbuser     = "root";
 $dbpass     = "";
	

try {
 $databaseConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
 echo 'ERROR: ' . $e->getMessage();
}
?>