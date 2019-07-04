<?php


	$DB_host = "localhost";

	$DB_user = "root";

	$DB_pass = "";

	$DB_name = "chat";


try {

    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);

    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $DB_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {

    die($e->getMessage());

}

require_once dirname(__FILE__).'/../app/user.php';


   $user = new User($DB_con);




?>