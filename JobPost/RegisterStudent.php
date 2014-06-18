<html>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
</head>

<h1 align="center">JobPost</h1>
<body>
<?php 
  // Load variables from previous form. If they are all valid, proceed to interface
  // Determines if all fields are filled in appropriately
  $registered = False;
  $totaltrue = 0;
  // Variables from user submission
  if(isset($_POST["universityid"])) {
  	$universityid = $_POST["universityid"];
  	  if($universityid > 0){
    		$totaltrue++;
  	}
  }
  
  if(isset($_POST["studentid"])) {
  $studentid = $_POST["studentid"];
  if($studentid > 0){
    $totaltrue++;
  }
  }
  
  if(isset($_POST["firstname"])) {
  $firstname = $_POST["firstname"];
    if(strlen($firstname) > 0){
    		$totaltrue++;
  }
  }
  
  if(isset($_POST["lastname"])) {
  $lastname = $_POST["lastname"];
  if(strlen($lastname) > 0){
    $totaltrue++;
  }
  } 
  
  if(isset($_POST["faculty"])){
  $faculty = $_POST["faculty"];
  if(strlen($faculty) > 0){
    $totaltrue++;
  }
  }
  
  if(isset($_POST["year"])) {
  $year = $_POST["year"];
  if($year > 0){
    $totaltrue++;
  }
  }
  
  if(isset($_POST["major"])) {
  $major = $_POST["major"];
  if(strlen($major) > 0){
    $totaltrue++;
  }
  }
  
  if(isset($_POST["username"])) {
  $username = $_POST["username"];
  if(strlen($username) > 0){
    $totaltrue++;
  }
  }
  
  if(isset($_POST["password1"])) {
  $password1 = $_POST["password1"];
  if(strlen($password1) > 0){
    $totaltrue++;
  }
  }
  
  if(isset($_POST["password2"])) {
  $password2 = $_POST["password2"];
  if(strlen($password2) > 0){
    $totaltrue++;
  }
  }
  
  // If all 10 fields are filled in, the form was completed
  if($totaltrue == 10){ $registered = True; }

  // Variable for which site delievered post request
  if(isset($_POST["StudentLogin"])) {
  $fromwhere = $_POST["StudentLogin"];
  }

  echo "Welcome to JobPost!";

  // If the passwords submitted match and the form was completed, create the new user
  if($registered && $password1 == $password2){

   // Insert user data into database
   
   $con=mysqli_connect("127.0.0.1","admin","pass", "JobPost", 3306);
   $insertion = mysqli_query($con,"INSERT INTO STUDENT_STUDIES (s_id, u_id, FirstName, LastName, Faculty, Year, Major, Username, Password)
VALUES ('$studentid', '$universityid', '$firstname', '$lastname', '$faculty', '$year', '$major', '$username', '$password1')");

   // If data is not inserted, print out the error

   if(!$insertion){
     die('Error: ' . mysqli_error($con));
   }
   echo 'Success! Click the button below to be directed to your home page!';

  // Leads to the interface

   echo '<form action="StudentInterface.php" method="post">';
   echo '<input type="submit" value=' . $username . ' name="username">';
   echo '</form>';
  } else{
  echo "<br>";
  echo "Please fill out the form below and we'll get you started!";

  // This will generate the list of Universities for a user to select from

  $con=mysqli_connect("127.0.0.1","admin","pass", "JobPost", 3306);
  $universityquery = mysqli_query($con,"SELECT u_id, Name FROM UNIVERSITY;");
  // This will appear if the user is not registered, or not information was entered incorrectly
  echo '<form action="RegisterStudent.php" method="post">';
  echo 'Please Select Your University: <br><select name="universityid"><br>';

  // Place appropriate university information in drop-down menu and submit data with form

  while($row = mysqli_fetch_array($universityquery)) {
    echo '<option value=' . $row['u_id'] . '>' . $row['Name'] . '</option>';
  }
  echo '<br></select><br>';
  //echo 'University ID: <br><input type="text" name="universityid"><br>';
  echo 'Student ID: <br><input type="text" name="studentid"><br>';
  echo 'First Name:<br> <input type="text" name="firstname"><br>';
  echo 'Last Name:<br> <input type="text" name="lastname"><br>';
  echo 'Faculty:<br> <input type="text" name="faculty"><br>';
  echo 'Year:<br> <input type="text" name="year"><br>';
  echo 'Major:<br> <input type="text" name="major"><br>';
  echo 'Username:<br> <input type="text" name="username"><br>';
  echo 'Password:<br> <input type="password" name="password1"><br>';
  echo 'Re-Enter Password:<br> <input type="password" name="password2"><br>';
  echo '<input type="submit" value="Submit Info">';
  echo '</form>';
  echo "<br>";
  }


?>  


</body>

</html>
