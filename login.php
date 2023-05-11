<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login page</title>
</head>
<body>
  <form method="post"action=""><!--error shows in the same form-->
    username <input name="un"><br>
    Password <input type="password" name="ps"><br>
    <button type="submit" name='sb'><b style="color:red">Login</b></button> 
  </form>
</body>
</html>


<?php
try{
  require('connection.php');//connect to the database
  $un = $_POST['un'];
  $sql ="select * from user where username = '".$un."'";
  //echo $sql;

  //used select? use query() with it.
  //this is a record set, we know for sure the username will not be repeated twice
  $rs = $db->query($sql); 
    //--> you get the name, if it exists it is saved inside here. 
  $db = null;//good practice to empty the server ? 
  
}

catch(PDOException $e){
  die("Error: ".$e->getMessage()); //IMAGINE THE $e an object that many things to do and get. 
}

//FETCH = it will return an array of the columns , it can be associative or numerical as you like 
// Fectch means read the row if it exists return an array including everthing related to the user
//if the user do not exits, it will return null which = false to the if statment. 

if($row = $rs->fetch() ){
  //valid username...
  //check password
  //$row['Password'] = password inside the $db
  $pass = $_POST['ps'];
  if(password_verify("$pass",$row['Password'])){
    //echo "welcome ".$row[1];
    //creating a session array, so that we store the user ip address and tell the server,that is a logged in user. 
    $_SESSION['activeUser']= $un;
    echo "welcome dear, ".$row['3'];
    //header("location:page.php"); go to a certain page since you are logged in.
  }

  else{
    echo "your password or username is invalid";
  }
}
else{
  echo "Invaild user!";
}
?>