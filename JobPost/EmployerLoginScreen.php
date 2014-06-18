<html>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
</head>

<h1 align="center">JobPost</h1>
<?php

// These variables are extracted from the text boxes each time this page is called 
if(isset($_POST["username"])){$username = $_POST["username"];}
if(isset($_POST["password"])){$password = $_POST["password"];}
if(isset($_POST["StudentLogin"])) {$test = $_POST["StudentLogin"];}

// Connect to database: You have to enter your own password and databasename
$con=mysqli_connect("127.0.0.1","admin","pass", "JobPost", 3306);

//Query for username and password entered
if(isset($_POST["username"])){$result2 = mysqli_query($con, "SELECT Username, Password FROM COMPANY WHERE Username='$username' AND Password='$password';");
// This button will pass the username to the interface page in a post request
while($row = mysqli_fetch_array($result2)) {
 if($row2['Username'] == $username2){
   $unamepasswordmatch = 0;
   echo 'Success! Click the button below to be directed to your home page.';
   echo '<form action="EmployerInterface.php" method="post">';
   echo '<input type="submit" value=' . $username . ' name="username">';
   echo '</form>';
 }
}
}

// Primative Boolean to see if there is a match in the DB for username and password
$unamepasswordmatch = 1;



// If username and password not found, load login buttons and text fields
if($unamepasswordmatch > 0){

if(isset($test) && ($test == "Login as Employer")){
  echo "Please Login:";
} else{
  echo "You're login information appears to incorrect. Please try again"; 
}

echo '<div> <form id="employerlogin" action="EmployerLoginScreen.php" method="post">';
echo ' <h3> Username: </h3> <input type="text" name="username"><br>';
echo '<h3> Password: </h3> <input type="password" name="password"><br>';
echo '<br> <input type="submit" value="Login">';
echo '</form> </div>';
echo "This your first time using JobPost?";
echo "<br>";
echo '<div><form id="register" action="RegisterEmployer.php" method="get">';
echo '<input id="subregis" type="submit" value="Register">';
echo '</form> </div>';
}

?>
</body>
</html>
