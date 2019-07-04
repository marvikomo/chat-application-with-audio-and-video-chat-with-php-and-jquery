<?php

date_default_timezone_set("Africa/Lagos");
error_reporting(0);
require_once dirname(__FILE__).'/../config/db.php';
class User{

	private $db;
	function __construct($conn)
	{
        $this->db = $conn;

	}


	public function fetch_user_last_activity($user_id)
	{

		$stmt = $this->db->prepare("SELECT * FROM login_details WHERE user_id = :user_id ORDER BY last_activity DESC LIMIT 1");

		  $stmt->bindParam(":user_id", $user_id);
		  $stmt->execute();

		  while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		  {
		    return $row['last_activity'];
		  }

	}

function fetch_user_chat_history($from_user_id, $to_user_id)
{

echo $from_user_id;
echo $to_user_id;
try{
 $query = "
  SELECT * FROM messages 
 WHERE (from_user_id = '".$from_user_id."' 
 AND to_user_id = '".$to_user_id."') 
 OR (from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."') 
 ORDER BY time ASC
 ";
 $statement = $this->db->prepare($query);
 
 $statement->execute();

 $output = '<ul class="list-unstyled">';
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  //echo $row['to_user_id'];
 	$user_name = '';
 	if($row["from_user_id"] == $from_user_id)
  {
   $user_name = '<b class="text-success">You'.$row['from_user_id'].'</b>';
  }
  else
  {
   $user_name = '<b class="text-danger">'.$this->get_user_name($row['from_user_id']).'</b>';
    //$user_name = '<b class="text-danger">heyyy</b>';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc">
   <p>'.$user_name.' - '.$row["chat_message"].'
    <div align="right">
     - <small><em>'.$row['time'].'</em></small>
    </div>
   </p>
  </li>
  ';


 }
  $output .= '</ul>';
   $query1 = "UPDATE messages SET status = '0' WHERE from_user_id = '".$to_user_id."' 
   AND to_user_id = '".$from_user_id."' 
    AND status = '1'
 ";
 $statement1 = $connect->prepare($query1);
 $statement1->execute();
 return $output;
}catch(PDOException $e)
{
	echo $e->getMessage();
}
}

function get_user_name($user_id)
{
 $query = "SELECT username FROM login WHERE user_id = '$user_id'";
 $statement = $this->db->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['username'];
 }
}
function count_unseen_message($from_user_id, $to_user_id)
{
  try{
 $sql = "
 SELECT * FROM messages WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id 
 AND status =:stat
 ";
 $stat = 1;
 $stmt = $this->db->prepare($sql);
 $stmt->bindValue(":from_user_id",$from_user_id);
 $stmt->bindValue(":to_user_id", $to_user_id);
  $stmt->bindValue(":stat", $stat);
 $stmt->execute();
 $count = $stmt->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
 }
 return $output;
}catch(PDOException $e)
{
  echo $e->getMessage();
}
}


}
?>