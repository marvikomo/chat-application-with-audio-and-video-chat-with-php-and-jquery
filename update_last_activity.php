<?php



include('./config/db.php');

session_start();

$sql = "UPDATE login_details SET last_activity = now() WHERE id =:login_details_id";

$stmt = $DB_con->prepare($sql);
$stmt->bindParam(":login_details_id", $_SESSION["login_details_id"]);


 $stmt->execute();



?>