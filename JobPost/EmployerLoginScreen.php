<html>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
</head>
<body>

<h1 align="center">JobPost</h1>
<?php 
$test = $_POST["EmployerLogin"];
if($test == "Login"){
  echo "You're login information appears to incorrect. Please try again";
} else{
  echo "Please Login:";
}?>
<form action="EmployerInterface.php" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit">
</form>

</body>
</html>