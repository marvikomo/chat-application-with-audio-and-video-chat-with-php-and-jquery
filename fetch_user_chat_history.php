<?php

//fetch_user_chat_history.php

include('database_connection.php');

session_start();
echo $_SESSION['user_id'];
//echo user->fetch_user_chat_history($_SESSION['user_id'], $_GET['to_user_id']);

?>