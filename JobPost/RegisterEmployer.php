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
  $companyname = $_POST["companyname"];
  if(strlen($companyname) > 0){
    $totaltrue++;
  }
  $streetnumber = $_POST["streetnumber"];
  if($streetnumber > 0){
    $totaltrue++;
  }
  $streetname = $_POST["streetname"];
  if(strlen($streetname) > 0){
    $totaltrue++;
  }
  $city = $_POST["city"];
  if(strlen($city) > 0){
    $totaltrue++;
  }
  $province = $_POST["province"];
  if(strlen($province) > 0){
    $totaltrue++;
  }
  $postalcode = $_POST["postalcode"];
  if(strlen($postalcode) > 0){
    $totaltrue++;
  }
  $username = $_POST["username"];
  if(strlen($username) > 0){
    $totaltrue++;
  }
  $password1 = $_POST["password1"];
  if(strlen($password1) > 0){
    $totaltrue++;
  }
  $password2 = $_POST["password2"];
  if(strlen($password2) > 0){
    $totaltrue++;
  }
  // No bugs above this line
  // If all 9 fields are filled in, the form was completed
  if($totaltrue == 9){ $registered = True; }

  // Variable for which site delievered post request
  $fromwhere = $_POST["StudentLogin"];

  echo "Welcome to JobPost!";

  // If the passwords submitted match and the form was completed, create the new user
  // bug contained in statement
  if($registered && $password1 == $password2){
   $con=mysqli_connect("localhost","root","Compouter25624!","cpsc304");
   
   // Generate a new id for company input by incrementing old highest id value
   $newcoid = null; 
   $newcoidresult = mysqli_query($con, "SELECT MAX(co_id) as max FROM COMPANY");
   while($row = mysqli_fetch_array($newcoidresult)) {
     $newcoid = $row[0] + 1;
   }

   // Insert user data into database   

   $insertion = mysqli_query($con,"INSERT INTO COMPANY (co_id, Name, StreetNumber, StreetName, City, Province, PostalCode, Username, Password)
VALUES ('$newcoid', '$companyname', '$streetnumber', '$streetname', '$city', '$province', '$postalcode', '$username', '$password1')");

   // If data is not inserted, print out the error

   if(!$insertion){
     die('Error: ' . mysqli_error($con));
   }
   echo 'Success! <br> Click the button below to be directed to your home page!';

  // Leads to the interface

   echo '<form action="EmployerInterface.php" method="post">';
   echo '<input type="submit" value=' . $username . ' name="username">';
   echo '</form>';
  } else{
  echo "<br>";
  echo "Please fill out the form below and we'll get you started!";
  echo '<form action="RegisterEmployer.php" method="post">';
  echo 'Company Name: <br><input type="text" name="companyname"><br><br>';
  echo 'Address<br><br>';
  echo 'Street Number:<br> <input type="text" name="streetnumber"><br>';
  echo 'Street Name:<br> <input type="text" name="streetname"><br>';
  echo 'City:<br> <input type="text" name="city"><br>';
  echo 'Province:<br> <input type="text" name="province"><br>';
  echo 'Postal Code:<br> <input type="text" name="postalcode"><br>';
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