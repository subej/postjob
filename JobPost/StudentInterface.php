<html>
<!--------------------------css--------------------------------->

<link rel="stylesheet" media="all" type="text/css" href="tester.css" />

<body>

<head>
<title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
    <script type="text/javascript">
      
      function showPort(x) {
	   		document.getElementById(x).style.display = "block";
	   		if (x != 'profileDiv') {
	   			document.getElementById('profileDiv').style.display = "none";
	   		}
	   		if (x != 'postingsDiv') {
	   			document.getElementById('postingsDiv').style.display = "none";
	   		}
			if (x != 'offerspending') {
	   			document.getElementById('offerspending').style.display = "none";
	   		}
			if (x != 'offersaccepted') {
	   			document.getElementById('offersaccepted').style.display = "none";
	   		}
			if (x != 'editinfo') {
	   			document.getElementById('editinfo').style.display = "none";
	   		}
			if (x != 'editprofile') {
	   			document.getElementById('editprofile').style.display = "none";
	   		}
	  }

    </script>
</head>
  

<!------------------------------function setup area--------------------------------------->

    <?php

	// These variables are extracted from the text boxes each time this page is called 
	  if(isset($_POST['username']))
       $username = $_POST["username"];
	$username= "anna";
	  
	   global $con, $sid;
	   $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
	   if(!$con){ 
		echo "Connection failed"; 
				}
				
	// Check connection
	   if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
									}

        
        $sidresult = mysqli_query($con,"SELECT s_id FROM STUDENT_STUDIES  WHERE username = '$username' ");
		while($row = mysqli_fetch_array($sidresult))
		$sid = $row['s_id'];
	//delete it after finished    
		echo $username;
		echo $sid;

  		function sendApplication($sid)
		        {//to apply a posted job
				$con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
				$jid=$_POST["Apply"];
				unset($_POST['Apply']);
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING WHERE j_id = $jid");
				$row = mysqli_fetch_array($result);
				$coid = $row['co_id'];
				$maxAliNum = mysqli_query($con, "SELECT DISTINCT MAX(ApplicationN) AS AppliN FROM APPLIES");
				$rowA = mysqli_fetch_array($maxAliNum);
				$apliN = (int)$rowA['AppliN'] + 1 ;
				$status = '-/-';
        
				if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				//for test, delete it later---
				echo $sid;
				echo $jid;
				echo $coid;
				echo $apliN;
				//----------------------------
				$query = "insert into applies (s_id,co_id,j_id,ApplicationN,Status) VALUES ($sid,$coid,$jid,$apliN,'$status')";
				mysqli_query($con,$query);
				mysqli_close($con);
				
				}
		 function Accept($sid){
			 $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
			 $aid = $_POST['Accept'];
			 $cid ='';
			 $cquery = "Select c.c_id FROM APPLIES a, JOB_POSTING j, CONTRACT c WHERE a.ApplicationN = $aid AND a.j_id =j.j_id AND j.c_id = c.c_id";
			 while($row = mysqli_fetch_array($cquery)){
				 $cid = $row['c_id'];
			 }
			 $query = "UPDATE APPLIES
				            SET Status = 'O/A' WHERE ApplicationN = $aid"; 
			 date_default_timezone_set('America/Los_Angeles');
             $sdate = date('Y-m-d', time());
			 $query2 = "insert into STUDENT_SIGNS (s_id,c_id,s_date) VALUES ($sid,$cid,'$sdate')";
			 mysqli_query($con,$query);
			 mysqli_query($con,$query2);
			 
		 }
		 function CancelAccept($sid){
			  $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
			 $aid = $_POST['CancelA'];
			 $cid ='';
			 $cquery = "Select c.c_id FROM APPLIES a, JOB_POSTING j, CONTRACT c WHERE a.ApplicationN = $aid AND a.j_id =j.j_id AND j.c_id = c.c_id";
			 while($row = mysqli_fetch_array($cquery)){
				 $cid = $row['c_id'];
			 }
			 $query = "UPDATE APPLIES
				            SET Status = 'O/-' WHERE ApplicationN = $aid"; 
			 $query2 = "DELETE FROM STUDENT_SIGNS WHERE s_id = $sid AND c_id = $cid";
			 mysqli_query($con,$query);
			 mysqli_query($con,$query2);
		 }
		
		  function CancelApplication($sid)
		        {//to cancel a posted job
				$con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
				$jid=$_POST['Cancel'];
				unset($_POST['Cancel']);
				$query = "DELETE FROM APPLIES WHERE s_id = $sid AND j_id = $jid";
				mysqli_query($con,$query);
				mysqli_close($con);
				}
		
  		  function getDetailsA(){//get detail information of a company
                $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
                $coid = $_POST['DetailA'];
	            $resultc = mysqli_query($con,"SELECT * FROM COMPANY WHERE co_id = $coid");
				$resultct = mysqli_query($con,"SELECT c.c_id, Salary, Status, TimePeriod FROM CONTRACT c, JOB_POSTING p WHERE p.co_id = $coid AND p.c_id = c.c_id");
				
                echo "Information of the company:";
				
				echo "<table id='companydets' border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>		
				<th>Name</th>
				<th>StreetNumber</th>
				<th>StreetName ID</th>
				<th>City</th>
				<th>Province</th>
				<th>PostalCode</th>
				</tr>";

				while($row = mysqli_fetch_array($resultc)) {
			  		echo "<tr bgcolor='#FFF' align='center' style='color: black;'>";	
			  		echo "<td>" . $row['Name'] . "</td>";
					echo "<td>" . $row['StreetNumber'] . "</td>";
  					echo "<td>" . $row['StreetName'] . "</td>";
  					echo "<td>" . $row['City'] . "</td>";
  					echo "<td>" . $row['Province'] . "</td>";
  					echo "<td>" . $row['PostalCode'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				
				 echo "Information of the contract:";
				
				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>		
				<th>Contract ID</th>
				<th>Salary</th>
				<th>Status</th>
				<th>TimePeriod</th>
				</tr>";

				while($row = mysqli_fetch_array($resultct)) {
			  		echo "<tr bgcolor='#FFF' align='center' style='color: black;'>";	
			  		echo "<td>" . $row['c_id'] . "</td>";
					echo "<td>" . $row['Salary'] . "</td>";
  					echo "<td>" . $row['Status'] . "</td>";
  					echo "<td>" . $row['TimePeriod'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				}
				
				function getDetails(){//get detail information of a company
                $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
                $coid = $_POST['Detail'];
	            $resultc = mysqli_query($con,"SELECT * FROM COMPANY WHERE co_id = $coid");
				$resultct = mysqli_query($con,"SELECT c.c_id, Salary, Status, TimePeriod FROM CONTRACT c, JOB_POSTING p WHERE p.co_id = $coid AND p.c_id = c.c_id");
				
                echo "Information of the company:";
				
				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>		
				<th>Name</th>
				<th>StreetNumber</th>
				<th>StreetName ID</th>
				<th>City</th>
				<th>Province</th>
				<th>PostalCode</th>
				</tr>";

				while($row = mysqli_fetch_array($resultc)) {
			  		echo "<tr bgcolor='#FFF' align='center' style='color: black;'>";	
			  		echo "<td>" . $row['Name'] . "</td>";
					echo "<td>" . $row['StreetNumber'] . "</td>";
  					echo "<td>" . $row['StreetName'] . "</td>";
  					echo "<td>" . $row['City'] . "</td>";
  					echo "<td>" . $row['Province'] . "</td>";
  					echo "<td>" . $row['PostalCode'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				
				 echo "Information of the contract:";
				
				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>		
				<th>Contract ID</th>
				<th>Salary</th>
				<th>Status</th>
				<th>TimePeriod</th>
				</tr>";

				while($row = mysqli_fetch_array($resultct)) {
			  		echo "<tr bgcolor='#FFF' align='center' style='color: black;'>";	
			  		echo "<td>" . $row['c_id'] . "</td>";
					echo "<td>" . $row['Salary'] . "</td>";
  					echo "<td>" . $row['Status'] . "</td>";
  					echo "<td>" . $row['TimePeriod'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				}
?>

<!--------------------------function setup area end--------------------------------->


<!---------------------------Interface area----------------------------------------->
<div id="mainbar">
    <ul>
          <tr>
            <input  id="main" type="button" style="font: bold 23px Arial" name="portfolio" value= "Profile" onClick="showPort('profileDiv')" />
          </tr>
          <tr >
             <input id="main" type="button" style="font: bold 23px Arial" name="posts" value="Job Postings" onClick="showPort('postingsDiv')" />
          </tr>
          <tr >
            <input id="main" type="button" style="font: bold 23px Arial" name="posts" value="Offers Pending" onClick="showPort('offerspending')" />
          </tr>
          <tr >
            <input id="main" type="button" style="font: bold 23px Arial" name="posts" value="Offers Accepted" onClick="showPort('offersaccepted')" />
          </tr>
          
  </ul>
</div>

<div id="editinfo"
     style="display:none;"
     class="answer_list">
     
     <form method="post" action="StudentInterface.php">
     <?php
      		  $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
			  $universityquery = mysqli_query($con,"SELECT u_id, Name FROM UNIVERSITY;");
			  $studentquery = mysqli_query($con,"SELECT * FROM STUDENT_STUDIES WHERE s_id = '$sid';");
			  $university = '';
			  $firstname = '';
			  $lastname = '';
			  $faculty = '';
			  $year = '';
			  $major = '';
			  
			  while($row = mysqli_fetch_array($studentquery)){
				  $university = $row['u_id'];
				  $firstname = $row['FirstName'];
				  $lastname = $row['LastName'];
			      $faculty = $row['Faculty'];
			      $year = $row['Year'];
			      $major = $row['Major'];
			  }
			  echo "<br>Student ID: '$sid'<br>";
			  echo 'University: <br><select name="universityid"><br>';
			  while($row = mysqli_fetch_array($universityquery)) {
				echo '<option value=' . $row['u_id'] . '>' . $row['Name'] . '</option>';
			  }
			  echo '<br></select><br>';
			  echo 'First Name:<br> <input type="text" name="firstname" value ='.$firstname.'><br>';
			  echo 'Last Name:<br> <input type="text" name="lastname" value ='.$lastname.'><br>';
			  echo 'Faculty:<br> <input type="text" name="faculty" value ='.$faculty.'><br>';
			  echo 'Year:<br> <input type="text" name="year" value ='.$year.'><br>';
			  echo 'Major:<br> <input type="text" name="major" value ='.$major.'><br>';
              echo '<input type="submit" value="submitinfo" name = "submitinfo">';
			  echo "<br>";

				  
			  
			     if(isset($_REQUEST["submitinfo"])){
				  $university = $_POST['universityid'];
				  $university = mysql_real_escape_string($university);
				  $firstname = $_POST['firstname'];
				  $firstname = mysql_real_escape_string($firstname);
				  $lastname = $_POST['lastname'];
				  $lastname = mysql_real_escape_string($lastname);
			      $faculty = $_POST['faculty'];
				  $faculty = mysql_real_escape_string($faculty);
			      $year = $_POST['year'];
				  $year = mysql_real_escape_string($year);
			      $major = $_POST['major']; 
				  $major = mysql_real_escape_string($major);

				  $query = "UPDATE STUDENT_STUDIES 
				            SET u_id = $university, FirstName = '$firstname', LastName = '$lastname', Faculty = '$faculty', Year = $year, Major = '$major' 
							WHERE s_id = $sid"; 
							
				  mysqli_query($con,$query);
				  echo "<input type = 'hidden' value = 'profileDiv' name='Div'>";
			  }
			  
		?>
        </form>    
</div>

<div id="editprofile"
     style="display:none;"
     class="answer_list">
     
     <form method="post" action="StudentInterface.php">
     <?php
                  $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
                  $profilequery = mysqli_query($con,"SELECT * FROM PROFILE_CREATES WHERE s_id = '$sid';");
                  $pid = '';
                  $pdate = '';
                  $experience = '';
                  $education = '';
                  if(mysqli_num_rows($profilequery) == 0){     
						$maxPid = mysqli_query($con, "SELECT DISTINCT MAX(p_id) AS pid FROM PROFILE_CREATES");
						$rowA = mysqli_fetch_array($maxPid);
						$pid = (int)$rowA['pid'] + 1 ;
						date_default_timezone_set('America/Los_Angeles');
						$pdate = date('Y-m-d', time());
						 //echo $pdate;
						 //echo $pid;
						 echo "<br>You do not have a profile, please create a new one:";
						 echo "<br>Student ID: '$sid'<br>";
						 echo 'Your Experience:<br> <input type="text" name="experience" value ='.$experience.'><br>';
						 echo 'Your Education:<br> <input type="text" name="education" value ='.$education.'><br>';
						 echo 'Date:<br> '.$pdate.' <br>';
						 echo '<input type="submit" value="submitprofile" name = "submitprofile">';
						 echo "<br>";
					   if(isset($_REQUEST["submitprofile"])){
						  $experience = $_POST['experience'];
						  $education = $_POST['education'];			  
						  $query = "insert into profile_creates (s_id, p_id, p_date, Experience, Education) VALUES ($sid,$pid,'$pdate','$experience','$education')"; 
						  mysqli_query($con,$query);
						  echo "<input type = 'hidden' value = 'profileDiv' name='Div'>";
                        }
				  }
                  else{  
				  
                          while($row = mysqli_fetch_array($profilequery)){
                              $pid = $row['p_id'];
                              $experience = $row['Experience'];
                              $education = $row['Education'];
            
                          }
                          
                          date_default_timezone_set('America/Los_Angeles');
                          $pdate = date('Y-m-d', time());
                          echo "<br>Student ID: '$sid'<br>";
                          echo 'Your Experience:<br> <input type="text" name="experience" value ='.$experience.'><br>';
                          echo 'Your Education:<br> <input type="text" name="education" value ='.$education.'><br>';
                          echo 'Date:<br>'.$pdate.'<br>';
                          echo '<input type="submit" value="submitprofile" name = "submitprofile">';
                          echo "<br>";
                          
                          
                          if(isset($_REQUEST["submitprofile"])){
                              $experience = $_POST['experience'];
							  $experience = mysql_real_escape_string($experience);
                              $education = $_POST['education'];
							  $education = mysql_real_escape_string($education);
							  $pdate = mysql_real_escape_string($pdate);
                              $query = "update PROFILE_CREATES set  Experience = '$experience', Education = '$education', p_date = '$pdate' WHERE s_id = $sid"; 
                              mysqli_query($con,$query);
                              echo "<input type = 'hidden' value = 'profileDiv' name='Div'>";
                                }
                  }
                  
            ?>
  </form>
     
    
</div>


<div id="profileDiv"
     style="display:none;"
     class="answer_list">
     
       <form id="prof" method="post" action="StudentInterface.php">
<?php
				$div = '';
				
				if(isset($_POST['Div']))
				$div = $_POST['Div'];
				
				//unset($_POST['Div']);
				 if($div=='profileDiv'){
					 
					                                 ?>
		 <script type="text/javascript">
		       			document.getElementById('profileDiv').style.display = "block"; 
		      			</script>
<?php
					
			                            }
				$studentinfo = mysqli_query($con,"SELECT * FROM STUDENT_STUDIES WHERE s_id = $sid;");
				 $uid = '';
				 $uname = '';
			     $firstname = '';
			     $lastname = '';
			     $faculty = '';
			     $year = '';
			     $major = '';
			  
			  while($row = mysqli_fetch_array($studentinfo)){
				  $uid = $row['u_id'];
				  $firstname = $row['FirstName'];
				  $lastname = $row['LastName'];
			      $faculty = $row['Faculty'];
			      $year = $row['Year'];
			      $major = $row['Major'];
			  }
			    $uquery = mysqli_query($con,"SELECT Name FROM UNIVERSITY WHERE u_id = $uid;");
				while($row = mysqli_fetch_array($uquery)){
				$uname = $row['Name'];
				}
				
										
				echo '<br><h2>Hello,'.$firstname.' '.$lastname.' </h2><br>'; ?>			
  <input type="button" name="edit" value="Edit Profile" onClick="showPort('editprofile')" /> <br>
  <input type="button" name="edit" value="Edit Info" onClick="showPort('editinfo')" /> 
   
   <?php
				echo '<br><table>Here is your information: <br>';
				echo '<br><tr>University: '.$uname.'</tr><br>';
				echo '<br><tr>Faculty: '.$faculty.'</tr><br>';
				echo '<br><tr>Year: '.$year.'</tr><br>';
				echo '<br><tr>Major: '.$major.'</tr></table><br>';
				echo '<br>You Profile:<br>';
     
     
				$result = mysqli_query($con,"SELECT * FROM PROFILE_CREATES WHERE s_id = '$sid'");

				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>	
				<th>Student ID</th>
				<th>Profile ID</th>
				<th>Profile Date</th>
				<th>Experience</th>
				<th>Education</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr bgcolor='#FFF' align='center' style='color: black;'>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['p_id'] . "</td>";
  					echo "<td>" . $row['p_date'] . "</td>";
  					echo "<td>" . $row['Experience'] . "</td>";
  					echo "<td>" . $row['Education'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
      
  </form>
            
</div>
		
 


 	       
   

           
<div id="postingsDiv"
     style="display:none;"
     class="answer_list"
     align="left">
    <form   id = "searchbar" method="post" action="StudentInterface.php"> 
     <div>
     <?php
	 $con=mysqli_connect('127.0.0.1','admin','pass', 'JobPost', 3306);
	 $companypost = mysqli_query($con,"SELECT * FROM COMPANY c, JOB_POSTING p WHERE c.co_id = p.co_id;");
	 $positions = mysqli_query($con,"SELECT Position FROM JOB_POSTING ;");
	 $salaryhigh = mysqli_query($con,"SELECT DISTINCT j_id FROM CONTRACT C, JOB_POSTING p WHERE c.Salary >= 3500 AND c.c_id = p.c_id; ;");
	 $salarylow = mysqli_query($con, "SELECT DISTINCT j_id FROM CONTRACT C, JOB_POSTING p WHERE c.Salary < 3500 AND c.c_id = p.c_id; ;");
              echo '  Select a company: <select name="companyid"> <br>';
			  echo '<option value= - > - </option>';
			  while($row = mysqli_fetch_array($companypost)) {
				echo '<option value=' . $row['co_id'] . '>' . $row['Name'] . '</option>';
			  }
			  echo '</select><br>';
			  echo 'Select a position: <select name="position"> <br>';
			  echo '<option value= - > - </option>';
			  while($row = mysqli_fetch_array($positions)) {
				echo '<option value=' . $row['Position'] . '>' . $row['Position'] . '</option>';
			  }
			  echo '</select><br>';
			  echo '      Salary: <br> <select name="salary">';
			  echo '<option value= - > - </option>';
			  echo '<option value= higher > higher than 3500 </option>';
			  echo '<option value= lower>lower than 3500</option>';
			  echo '</select> <br>';
			  echo '<br><tr>  Keyword: <input id="searchjp" type="text" name="key" value= > </tr> ';
			  echo 'Only to show the latest post: <input id="searchjpc" type="checkbox" name="latest" value= "latest">';
			  echo "<button input type='submit' value='Search' name='Search' >Search</button>";
			  $result = mysqli_query($con,"SELECT * FROM JOB_POSTING");
	          if(isset($_REQUEST['Search'])){
				  echo "<input type = 'hidden' value = 'jobposting' name='Div'>";
				  $cid = $_POST['companyid'];
				  $position = $_POST['position'];
				  $salary = $_POST['salary'];
				  $key ='' ;
				  if(isset($_POST['key']))
				  $key = $_POST['key'];
				  $key = mysql_real_escape_string($key);
				  
				  if($salary == 'higher'){
					  if($cid == '-' && $position == '-'){
						  echo $key ;
						  echo 1 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE c.Salary >=3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
					  }
													  
					 else if($cid != '-' && $position == '-'){
						 echo $key ;
						 echo 2 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.Position = '$position' AND c.Salary >=3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
					 }
			        else if($cid == '-' && $position != '-'){
						echo $key ;
						echo 3 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.co_id = '$cid' AND c.Salary >=3500 AND p.c_id = c.c_id
												      GROUP BY j_id,p.Position
												      HAVING p.Position like '%{$key}%'");
													  }
				
				   else  if($cid == '-' && $position != '-'){
					   echo $key ;
					   echo 4 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.co_id = '$cid' AND p.Position = '$position' AND c.Salary >=3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
													  }

			                            }
			      else if ($salary == 'lower'){
				      if($cid == '-' && $position == '-'){
						  echo $key ;
						  echo 5 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE c.Salary < 3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
					  }
													  
					 else if($cid == '-' && $position != '-'){
						 echo $key ;
						 echo 6 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.Position = '$position' AND c.Salary < 3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
					 }
			        else if($cid != '-' && $position == '-'){
						echo $key ;
						echo 7 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.co_id = '$cid' AND c.Salary < 3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
													  }
				
				   else  if($cid != '-' && $position != '-'){
					   echo $key ;
					   echo 8 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.co_id = '$cid' AND p.Position = '$position' AND c.Salary < 3500 AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
													  }
												   
				 }
				 else{
				 if($cid == '-' && $position == '-'){
					 echo $key ;
					 echo 9;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
					  }
													  
					 else if($cid == '-' && $position != '-'){
						 echo $key ;
						 echo 10 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.Position = '$position' AND  p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
					 }
			        else if($cid != '-' && $position == '-'){
						echo $key ;
						echo 11 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.co_id = '$cid' AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
													  }
				
				   else  if($cid != '-' && $position != '-'){
					   echo $key ;
					   echo 12 ;
				         $result = mysqli_query($con,"SELECT j_id,p.c_id,co_id,Position,DatePosted 
					  							      FROM JOB_POSTING p, Contract c 
												      WHERE p.co_id = '$cid' AND p.Position = '$position' AND p.c_id = c.c_id
												      GROUP BY j_id, p.Position
												      HAVING p.Position like '%{$key}%'");
													  }
				 
				 }
				 unset($_POST['Search']);
				 
			  }
	 ?>  
     </div>
  
            	<?php
				$div = '';
				if(isset($_POST['Div']))
				$div = $_POST['Div'];
				//unset($_POST['Div']);
				 if($div=='jobposting'){
					 ?>
						<script type="text/javascript">
		       			document.getElementById('postingsDiv').style.display = "block"; 
		      			</script>
				<?php
			                            }
										
					echo "<table id='tid' border='1'  height='auto' >
					<tr bgcolor='#F00' align='center' style='color:white;'>	
					<th class='view_th' width='5%'>Job ID</th>
					<th class='view_th' width='5%'>Contract ID</th>
					<th class='view_th' width='5%'>Company ID</th>
					<th class='view_th' width='20%'>Position</th>
					<th class='view_th' width='25%'>Date Posted</th>
					<th class='view_th' width='20%'>Status</th>
					<th class='view_th' width='20%'>Company</th>
					</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr bgcolor='#FFF' align='center' style='color: black;'>";	
			  		echo "<td class='view_th' width='5%'>" . $row['j_id'] . "</td>";
					$jid = $row['j_id'];
  					echo "<td class='view_th' width='5%'>" . $row['c_id'] . "</td>";
  					echo "<td class='view_th' width='5%'>" . $row['co_id'] . "</td>";
					$coid = $row['co_id'];
  					echo "<td class='view_th' width='20%'>" . $row['Position'] . "</td>";
  					echo "<td class='view_th' width='25%'>" . $row['DatePosted'] . "</td>";
					echo "<td class='view_td' width='20%'><center>";
	                $signedAppli = mysqli_query($con, "SELECT * FROM APPLIES WHERE j_id = '$jid' AND s_id = '$sid'");

		            if (mysqli_num_rows($signedAppli) == 0){ 
		            		echo "<button input type='submit' value='$jid' name='Apply' >Apply</button>";
							
		                                        }
		  			else{
            				echo "<button input type='submit' value='$jid' name='Cancel' >Cancel</button>";
							
			  									}						            
                    echo "</center></td>";
					echo "<td class='view_td' width='20%'><center>
					     <button name='Detail' type='submit' value='$coid' >Detail</button></td>";		           
					echo "</tr>";
												}

					echo "</table>";
				
				                 if(isset($_REQUEST['Apply']))
                                             {			 
								 
								 echo "<input type = 'hidden' value = 'jobposting' name='Div'>";
								 sendApplication($sid);
                                             }
                                 else if(isset($_REQUEST['Detail']))
                                             {
								
								 echo "<input type = 'hidden' value = 'jobposting' name='Div'>";
                                 getDetails();
                                              }
								 else if (isset($_REQUEST['Cancel']))
								 			 {
								
								 echo "<input type = 'hidden' value = 'jobposting' name='Div'>";	 
								 CancelApplication($sid);
								 			  }
			?>
            </form>
</div>
        
<div id="offerspending"
     style="display:none;">
                <form method="post" action="StudentInterface.php"> 
    			<?php
				$div = '';
				
				if(isset($_POST['Div']))
				$div = $_POST['Div'];
				
				//unset($_POST['Div']);
				 if($div=='offerspending'){
					 
					                                 ?>
		 <script type="text/javascript">
		       			document.getElementById('offerspending').style.display = "block"; 
		      			</script>
<?php
					
			                            }
				
				$result = mysqli_query($con,"SELECT a.s_id,j.co_id,j.j_id,a.ApplicationN,a.Status 
				                             FROM APPLIES a, JOB_POSTING j, CONTRACT c 
											 WHERE a.s_id = $sid AND a.Status = 'O/-' AND j.j_id = a.j_id AND j.c_id = c.c_id");

				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>	
				<th>Student ID</th>
				<th>Company ID</th>
				<th>Job ID</th>
				<th>Application Number</th>
				<th>Status</th>
				</tr>";
				$jid = '';
				$aid = '';

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['ApplicationN'] . "</td>";
					echo "<td>" . $row['Status'] . "</td>";
					
				    $jid = $row['j_id'];
					$aid = $row['ApplicationN'];
					
				    $signed = mysqli_query($con, "SELECT * FROM STUDENT_SIGNS WHERE j_id = '$jid' AND s_id = '$sid'");

					
		                           if (mysqli_num_rows($signedAppli) == 0){ 
		            		        echo "<td class='view_td' width='20%'><center><button input type='submit' value='$aid' name='Accept' >Accept</button>";
							
		                                        }
									else{
											echo "<td class='view_td' width='20%'><center><button input type='submit' value='$aid' name='CancelA' >Cancel</button>";
											
																}						            
									echo "</center></td>";
									echo "<td class='view_td' width='20%'><center>
										 <button name='DetailA' type='submit' value='$coid' >Detail</button></td>";		           
									echo "</tr>";
																}
				
									echo "</table>";
				
				                 if(isset($_REQUEST['Accept']))
                                             {			 
								 
								 echo "<input type = 'hidden' value = 'offerspending' name='Div'>";
								 Accept($sid);
                                             }
                                 else if(isset($_REQUEST['DetailA']))
                                             {
								
								 echo "<input type = 'hidden' value = 'offerspending' name='Div'>";
                                 getDetailsA();
                                              }
								 else if (isset($_REQUEST['CancelA']))
								 			 {
								
								 echo "<input type = 'hidden' value = 'offerspending' name='Div'>";	 
								 CancelAccept($sid);
								 			  }
					echo "</tr>";
				


			   ?>
               </form>
               
</div>
        

<div id="offersaccepted"
    		style="display:none;"
    		class="answer_list">
            <form method="post" action="StudentInterface.php"> 
    			<?php
				
				$div = '';
				
				if(isset($_POST['Div']))
				$div = $_POST['Div'];
				
				//unset($_POST['Div']);
				 if($div=='offersaccepted'){
					 
					                                 ?>
		 <script type="text/javascript">
		       			document.getElementById('offersaccepted').style.display = "block"; 
		      			</script>
<?php
					
			                            }
				
				
				
				
				$result = mysqli_query($con,"SELECT * FROM STUDENT_SIGNS WHERE s_id = '$sid'");


				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>	
				<th>Student ID</th>
				<th>Contract ID</th>
				<th>Sign Date</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['s_date'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
            </form>
</div>
        
      
        
<!-------------------------------------------Interface area----------------------------------------------------->	
	

	
	
</body>
</html>
