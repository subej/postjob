<!DOCTYPE html>
<html>
<?php
	$con = mysqli_connect("localhost", "root", "123456", "newdb");
	
	if(isset($_POST['deleteconfirm'])){
		if($_POST['deletcheck'] != 'no'){
			mysqli_query($con, "DELETE FROM STUDENT_STUDIES WHERE STUDENT_STUDIES.s_id =" . $_POST['deleteconfirm'] );
			echo "I ran the query";
		}
	}
?>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
</head>

<h1 align="center">JobPost</h1>

<p>Welcome to JobPost! <br>
Please login as either an employer or student:</p>

<div class="loginbuttons">
<form action="EmployerLoginScreen.php" method="post">
<input class="input" type="submit" value ="Login as Employer">
</form>

<form action="StudentLoginScreen.php" method="post">
<input class="input" type="submit" value="Login as Student" name="StudentLogin">
</form>
</div>
</body>
</html>