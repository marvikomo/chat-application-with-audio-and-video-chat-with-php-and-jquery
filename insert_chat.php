<?php

//insert_chat.php

include('./config/db.php');

session_start();

//echo  $_GET['to_user_id'];
//echo $_GET['chat_message'];
//echo $_SESSION['user_id'];
/*$data = array(
 ':to_user_id'  => $_GET['to_user_id'],
 ':from_user_id'  => $_SESSION['user_id'],
 ':chat_message'  => $_GET['chat_message'],
 ':status'   => '1'
);*/

$sql = "
INSERT INTO messages (to_user_id, from_user_id, chat_message, status) VALUES (:to_user_id, :from_user_id, :chat_message, :status)
";
$stat = 1;
$statement = $DB_con->prepare($sql);
$statement->bindParam(':to_user_id', $_GET['to_user_id']);
$statement->bindParam(':from_user_id', $_SESSION['user_id']);
$statement->bindParam(':chat_message',$_GET['chat_message']);
$statement->bindParam(':status',$stat);
if($statement->execute())
{
 echo $user->fetch_user_chat_history($_SESSION['user_id'], $_GET['to_user_id']);
}

?>