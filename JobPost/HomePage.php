<!DOCTYPE html>
<html>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="none.css">
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