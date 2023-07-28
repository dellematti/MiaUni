<?php
// le tre righe sotto funzionano

// $dbconn3 = pg_connect("host=127.0.0.1 port=5432 dbname=unimia user=postgres password=pangolino");
// if ($dbconn3) echo "mi sono collegato al db"; 
// else echo "NON mi sono collegato al db"; 

// $host= 'localhost';
// $db = 'unimia';
// $user = 'postgres';
// $password = 'pangolino'; 
// 
// try {
// 	$dsn = "pgsql:host=$host;port=5432;dbname=$db;";
// 	$pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// 	if ($pdo) {
// 		echo "Connected to the $db database successfully!";
// 	}
// } catch (PDOException $e) {
// 	die($e->getMessage());
// } finally {
// 	if ($pdo) {
// 		$pdo = null;
// 	}
// }


$host= 'localhost';
$db = 'unimia';
$user = 'postgres';
$password = 'pangolino'; 

function connect(string $host, string $db, string $user, string $password): PDO
{
	try {
		$dsn = "pgsql:host=$host;port=5432;dbname=$db;";

		return new PDO(
			$dsn,
			$user,
			$password,
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
}

return connect($host, $db, $user, $password);