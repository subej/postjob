<html>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
</head>

<h1 align="center">JobPost</h1>
<?php

// These variables are extracted from the text boxes each time this page is called 
$username = $_POST["username"];
$password = $_POST["password"];
$test = $_POST["StudentLogin"];

// Connect to database: You have to enter your own password and databasename
$con=mysqli_connect("localhost","root","PASSWORD","DATABASE");

// Results from University query
$result = mysqli_query($con,"SELECT * FROM UNIVERSITY;");

// Results from Student query
$result3 = mysqli_query($con,"SELECT * FROM STUDENT_STUDIES;");

// This is a tester to make sure that the query code is working
while($row = mysqli_fetch_array($result)) {
  echo $row['Name'] . " " . $row['Province'];
  echo "<br>";
}

// This generates all usernames and passwords stored in your DB
while($row = mysqli_fetch_array($result3)) {
  echo "These are a username and password for testing purposes.";
  echo "<br>";
  echo $row['Username'] . " " . $row['Password'];
  echo "<br>";
  echo "This is the password you entered: "; 
  echo "<br>";
  echo $password;
  echo "<br>";
}

// Produces error message if unable to connect to DB
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Query for username and password entered
$result2 = mysqli_query($con, "SELECT Username, Password FROM STUDENT_STUDIES WHERE Username='$username' AND Password='$password';");

// Primative Boolean to see if there is a match in the DB for username and password
$unamepasswordmatch = 1;

// This button will pass the username to the interface page in a post request
while($row = mysqli_fetch_array($result2)) {
 if($row2['Username'] == $username2){
   $unamepasswordmatch = 0;
   echo 'Success! Click the button below to be directed to your home page.';
   echo '<form action="StudentInterface.php" method="post">';
   echo '<input type="submit" value=' . $username . ' name="username">';
   echo '</form>';
 }
}

// If username and password not found, load login buttons and text fields
if($unamepasswordmatch > 0){

if($test == "Login as Student"){
  echo "Please Login:";
} else{
  echo "You're login information appears to incorrect. Please try again"; 
}
echo '<form action="StudentLoginScreen.php" method="post">';
echo 'Username: <input type="text" name="username"><br>';
echo 'Password: <input type="password" name="password"><br>';
echo '<input type="submit" value="Login">';
echo '</form>';
}

?>
</body>
</html>