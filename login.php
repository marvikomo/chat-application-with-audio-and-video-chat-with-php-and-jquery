<?php



include('./config/db.php');



session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
 header('location:views/index.php');
}

if(isset($_POST["login"]))
{
 $sql = "SELECT * FROM login  WHERE username = :username";
 $stmt =  $DB_con->prepare($sql);
 $stmt->bindParam(":username", $_POST['username']);
 $stmt->execute();
 
  $count = $stmt->rowCount();
  if($count > 0)
 {

   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    if(password_verify($_POST['password'], $row['password']))
    {
      $id = $row['user_id'];
      $_SESSION['user_id'] = $id;
      $_SESSION['username'] = $row['username'];

      $stmt2 =  $DB_con->prepare("INSERT INTO login_details (user_id) VALUES(:user_id)");
      $stmt2->bindParam(":user_id",$id);
      $stmt2->execute();
      $_SESSION['login_details_id'] = $DB_con->lastInsertId();
      header("location:views/index.php");
    }else{
          $message = "<label>Wrong Password</label>";
    }

   }  
     
 }
 else
 {
  $message = "<label>Wrong Username</labe>";
 }
}

?>

<html>  
    <head>  
        <title>Marvelous Chat Application</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
   <br />
   
   <h3 align="center">Marvikoko Chat Application</a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading"> Login</div>
    <div class="panel-body">
     <form method="post">
      <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Enter Username</label>
       <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Enter Password</label>
       <input type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
       <input type="submit" name="login" class="btn btn-info" value="Login" />
      </div>
     </form>
    </div>
   </div>
  </div>
    </body>  
</html>