<?php
include('./config/db.php');
session_start();

$sql = "SELECT * FROM login WHERE user_id != :user_id";


$stmt = $DB_con->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id']);

$stmt->execute();



$result = $stmt->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <td>Username</td>
  <td>Status</td>
  <td>Action</td>
 </tr>
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
    $user_last_activity = $user->fetch_user_last_activity($row['user_id']);
    if($user_last_activity > $current_timestamp)
	 {
	  $status = '<span class="label label-success">Online</span>';
	 }
	 else
	 {
	  $status = '<span class="label label-danger">Offline</span>';
	 }
    $output .= '
 <tr>
  <td>'.$row['username'].' '.$user->count_unseen_message($row['user_id'], $_SESSION['user_id']).'</td> 
  <td>'.$status.'</td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;
?>