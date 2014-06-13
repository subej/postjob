<html>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
</head>

<h1 align="center">JobPost</h1>
<?php 
$test = $_POST["StudentLogin"];
if($test == "Login"){
  echo "You're login information appears to incorrect. Please try again";
} else{
  echo "Please Login:";
}?>
<form action="StudentInterface.php" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit" value="Login">
</form>

</body>
</html>