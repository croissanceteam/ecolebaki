<?php
function getDB() {
	$dbhost="127.0.0.1";
	$dbuser="root";
	$dbpass="";
	$dbname="db_baki";
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass,array(1002=> 'SET NAMES utf8'));
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	return $pdo;
}

function queryDB($sql, $parameters = NULL) {

	if ($parameters) {
		$req = getDB()->prepare($sql);
		$req->execute($parameters);
	} else
		$req = getDB()->query($sql);

	return $req;
}

?>
<?php
       define("__DATE__", "");
       define("__TIME__", "");
	 	//  define("__COUNTRIES__", file_get_contents("js/countries.json"));
	 	getDB();

?>
