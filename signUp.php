<?php

$msg='required'; //universal for every field. 
if(isset($_POST['n'])){
  //validate the inputs , use regular expressions
  $n= test_input($_POST['n']); //validating the name
  $un= test_input($_POST['un']); //validating the Username
  $ps= test_input($_POST['ps']); //validating the Password
  $cps = $_POST['cps']; //confirm pass
  if(empty($n)||empty($un)||empty($ps)){
    echo $msg="invalid input";}
  if($ps !=$cps){
    echo "passwords do not match!";}
 
  else{
    try{
      require("connection.php"); 
      //PASSWORD_DEFAULT IS AN ALGORITHM, That is very powerful in encrypting the passwords. 
      $ps_hashed = password_hash("$ps",PASSWORD_DEFAULT);
      $sql = "insert into user value(null,'$un','$ps_hashed','$n')";//normal string
      $r = $db -> exec($sql); //number of rows inserted will be returned, when using the exec function
      if($r>= 1)
        echo "<h3 style='color:blue;'>you have registered successfully</h3>";
        //provide him with a link to the other page.
      else
      echo "something wrong happened"; // i dont think you will see this. because try & catch will do the job  
      unset($db); // making the $db null is a good practice. 
    }
    //object oriented programming
    catch(PDOException $e){
      die("Error: ".$e->getMessage());
    }
  }


  
}

//function that validates the input
function test_input($data){
  $data = trim($data); 
  $data = htmlspecialchars($data); 
  $data = stripslashes($data); 
  return $data;

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    span{
      color: red;
    }
  </style>
</head>
<body>


  <form method="post" 
  style="display:flex;
  flex-wrap:wrap;
  width:10%;
  row-gap:10px;

  " >
    name: <input name ='n' placeholder=""><span> * <?php echo $msg;?></span><br>
    Username: <input name = 'un' placeholder=""> <span> * <?php echo $msg;?></span><br>
    Password: <input type="password" name="ps" placeholder=""><span> * <?php echo $msg;?></span><br>
    Confirm Password: <input type="password" name="cps"><span> * <?php echo $msg;?></span><br>
    <button type="submit" style="color:blue">Sign Up</button>
  </form>

</body>
</html>