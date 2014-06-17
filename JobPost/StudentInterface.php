<html>
<!--------------------------css--------------------------------->
<style type="text/css">
.page1 {
	background-color: #FC0;
	border: thick solid #F00;
}
#mainbar {
	position:absolute;
	width:800px;
	height:50px;
	left: 600px;
	right:600px;
	top: 100px;
	background-color: #F60;
}
#profileDiv{
	position:absolute;
	width:800px;
	height:auto;
	left: 600px;
	right:600px;
	top: 250px;
	
}
#postingsDiv{
	position:absolute;
	width:800px;
	height:auto;
	left: 600px;
	right:600px;
	top: 250px;
	padding-right:300px;
	padding-left:-100px;
}
#offerspending{
	position:absolute;
	width:800px;
	height:auto;
	left: 600px;
	right:600px;
	top: 250px;

}
#offersaccepted{
	position:absolute;
	width:800px;
	height:auto;
	left: 600px;
	right:600px;
	top: 250px;

}

</style>
<!-----------------------------------------css---------------------------------->
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
			if (x != 'Edit Info') {
	   			document.getElementById('Edit Info').style.display = "none";
	   		}
			if (x != 'Edit profile') {
	   			document.getElementById('Edit profile').style.display = "none";
	   		}
	  }

    </script>
</head>
  

<!------------------------------function setup area--------------------------------------->

    <?php

	// These variables are extracted from the text boxes each time this page is called 
	  if(isset($_POST['username']))
       $username = $_POST["username"];
	  $username = "admin";//for test, delete it later
	  
	   global $con, $sid;
	   $con=mysqli_connect('localhost','root','', 'jobpost');
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
				$con=mysqli_connect('localhost','root','', 'jobpost');
				$jid=$_POST["Apply"];
				unset($_POST['Apply']);
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING WHERE j_id = '$jid'");
				$row = mysqli_fetch_array($result);
				$coid = $row['co_id'];
				$maxAliNum = mysqli_query($con, "SELECT DISTINCT MAX(ApplicationN) AS AppliN FROM APPLIES");
				$rowA = mysqli_fetch_array($maxAliNum);
				$apliN = (int)$rowA['AppliN'] + 1 ;
        
				if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				//for test, delete it later---
				echo $sid;
				echo $jid;
				echo $coid;
				echo $apliN;
				//----------------------------
				$query = "insert into applies (s_id,co_id,j_id,ApplicationN) VALUES ($sid,$coid,$jid,$apliN)";
				mysqli_query($con,$query);
				mysqli_close($con);
				
				}
		
		  function CancelApplication($sid)
		        {//to cancel a posted job
				$con=mysqli_connect('localhost','root','', 'jobpost');
				$jid=$_POST['Cancel'];
				unset($_POST['Cancel']);
				$query = "DELETE FROM APPLIES WHERE s_id = '$sid' AND j_id = '$jid'";
				mysqli_query($con,$query);
				//to slow down php
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING WHERE j_id = '$jid'");
				mysqli_close($con);
				}
		
  		  function getDetails(){//get detail information of a company
                $con=mysqli_connect('localhost','root','', 'jobpost');
                $coid = $_POST['Detail'];
	            $result = mysqli_query($con,"SELECT * FROM COMPANY WHERE co_id = '$coid'");
				
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

				while($row = mysqli_fetch_array($result)) {
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
				}
?>

<!--------------------------function setup area end--------------------------------->


<!---------------------------Interface area----------------------------------------->
<div id="mainbar">
    <ul>
          <li>
            <input type="button" name="portfolio" value="Profile" onClick="showPort('profileDiv')" />
          </li>
          <li>
             <input type="button" name="posts" value="Job Postings" onClick="showPort('postingsDiv')" />
          </li>
          <li>
            <input type="button" name="posts" value="offerspending" onClick="showPort('offerspending')" />
          </li>
          <li>
            <input type="button" name="posts" value="offersaccepted" onClick="showPort('offersaccepted')" />
          </li>
          
  </ul>
</div>

<div id="Edit Info"
     style="display:none;"
     class="answer_list">
     
     <form method="POST" action="StudentInterface.php">
     <?php
      		  $con=mysqli_connect('localhost','root','', 'jobpost');
			  $universityquery = mysqli_query($con,"SELECT u_id, Name FROM UNIVERSITY;");
			  $studentquery = mysqli_query($con,"SELECT * FROM STUDENT_STUDIES WHERE s_id = '$sid';");
			  $university = '';
			  $firstname = '';
			  $lastname = '';
			  $faculty = '';
			  $year = '';
			  $major = '';
			  
			  while($row = mysqli_fetch_array($studentquery)){
				  $university = $row['University'];
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
              echo '<input type="submit" value="Submit Info" name = "Submit Info">';
			  echo "<br>";
			  
			  if(isset($_REQUEST["Submit Info"])){
				  $university = $_POST['universityid'];
				  $firstname = $_POST['firstname'];
				  $lastname = $_POST['lastname'];
			      $faculty = $_POST['faculty'];
			      $year = $_POST['year'];
			      $major = $_POST['major']; 
				  $query = "update STUDENT_STUDIES set u_id = '$university', FirstName = '$firstname', LastName = '$lastname', Faculty = '$faculty', Year = '$year', Major = '$major' WHERE s_id = '$sid'"; 
				  mysqli_query($con,$query);
				  echo "<input type = 'hidden' value = 'profileDiv' name='Div'>";
			  }
			  
		?>
        </form>    
</div>

<div id="Edit profile"
     style="display:none;"
     class="answer_list">
     
     <form method="POST" action="StudentInterface.php">
     <?php
                  $con=mysqli_connect('localhost','root','', 'jobpost');
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
                  $pdate = date('m/d/Y', time());
                  echo "<br>You do not have a profile, please create a new one:";
                  echo "<br>Student ID: '$sid'<br>";
                  echo 'Your Experience:<br> <input type="text" name="experience" value ='.$experience.'><br>';
                  echo 'Your Education:<br> <input type="text" name="education" value ='.$education.'><br>';
                  echo 'pdate:<br> <input type="hidden" name="pdate" value ='.$pdate.'><br>';
                  echo '<input type="submit" value="Submit Profile" name = "Submit Profile">';
                  echo "<br>";
                   if(isset($_REQUEST["Submit Profile"])){
                      $experience = $_POST['experience'];
                      $education = $_POST['education'];
                      $pdate = $_POST['pdate'];
                      $query = "INSERT INTO PROFILE_CREATES VALUES ('$sid','$pid','$pdate','$experience','$education')"; 
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
                          $pdate = date('m/d/Y', time());
                          echo "<br>Student ID: '$sid'<br>";
                          echo 'Your Experience:<br> <input type="text" name="experience" value ='.$experience.'><br>';
                          echo 'Your Education:<br> <input type="text" name="education" value ='.$education.'><br>';
                          echo 'pdate:<br> <input type="hidden" name="pdate" value ='.$pdate.'><br>';
                          echo '<input type="submit" value="Submit Profile" name = "Submit Profile">';
                          echo "<br>";
                          
                          
                          if(isset($_REQUEST["Submit Profile"])){
                              $experience = $_POST['experience'];
                              $education = $_POST['education'];
                              $pdate = $_POST['pdate'];
                              $query = "update PROFILE_CREATES set  Experience = '$experience', Education = '$education', p_date = 'pdate' WHERE s_id = '$sid'"; 
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
     
       <form method="POST" action="StudentInterface.php">
<?php
				$div = '';
				
				if(isset($_POST['dIV']))
				$div = $_POST['Div'];
				
				//unset($_POST['Div']);
				 if($div=='profileDiv'){
					 
					                                 ?>
		 <script type="text/javascript">
		       			document.getElementById('profileDiv').style.display = "block"; 
		      			</script>
<?php
					
			                            }
     
     
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
            
            <input type="button" name="edit" value="editprofile" onClick="showPort('Edit profile')" />
  <input type="button" name="edit" value="edit Info" onClick="showPort('Edit Info')" />
</div>
		
 


 	       
   

           
<div id="postingsDiv"
     style="display:none;"
     class="answer_list">
    <form method="POST" action="StudentInterface.php"> 
     <div id = "searchbar">
     <?php
	 $con=mysqli_connect('localhost','root','', 'jobpost');
	 $companypost = mysqli_query($con,"SELECT * FROM COMPANY c, JOB_POSTING p WHERE c.co_id = p.co_id;");
	 $positions = mysqli_query($con,"SELECT Position FROM JOB_POSTING ;");
	 $salaryhigh = mysqli_query($con,"SELECT DISTINCT j_id FROM CONTRACT C, JOB_POSTING p WHERE c.Salary >= 3500 AND c.c_id = p.c_id; ;");
	 $salarylow = mysqli_query($con,"SELECT DISTINCT j_id FROM CONTRACT C, JOB_POSTING p WHERE c.Salary < 3500 AND c.c_id = p.c_id; ;");
              echo 'Select a company: <br><select name="companyid"><br>';
			  echo '<option value= - > - </option>';
			  while($row = mysqli_fetch_array($companypost)) {
				echo '<option value=' . $row['co_id'] . '>' . $row['Name'] . '</option>';
			  }
			  echo '<br></select><br>';
			  echo 'Select a position: <br><select name="position"><br>';
			  echo '<option value= - > - </option>';
			  while($row = mysqli_fetch_array($positions)) {
				echo '<option value=' . $row['Position'] . '>' . $row['Position'] . '</option>';
			  }
			  echo '<br></select><br>';
			  echo 'Salary: <br><select name="salary"><br>';
			  echo '<option value= - > - </option>';
			  echo '<option value= higher > higher than 3500 </option>';
			  echo '<option value= lower>lower than 3500</option>';
			  echo '<br></select><br>';
			  echo "<button input type='submit' value='Search' name='Search' >Search</button>";
			  $result = mysqli_query($con,"SELECT * FROM JOB_POSTING");
	          if(isset($_REQUEST['Search'])){
				  echo "<input type = 'hidden' value = 'jobposting' name='Div'>";
				  $cid = $_POST['companyid'];
				  $position = $_POST['position'];
				  $salary = $_POST['salary'];
				  if($cid == '-'&&$position =='-'&& $salary =='-'){
					  $result = mysqli_query($con,"SELECT * FROM JOB_POSTING");			  
				  }
				  else if($salary == 'higher'){
				      $result = mysqli_query($con,"SELECT * FROM JOB_POSTING p, Contract c WHERE p.co_id = $cid AND p.Position = 'position' AND c.Salary >= 3500");
			                            }
			     else if ($salary == 'lower'){
				      $result = mysqli_query($con,"SELECT * FROM JOB_POSTING p, Contract c WHERE p.co_id = $cid AND p.Position = 'position' AND c.Salary < 3500");
				 }
				 else{
				 $result = mysqli_query($con,"SELECT * FROM JOB_POSTING p, Contract c WHERE p.co_id = $cid AND p.Position = 'position'");
				 }
				 unset($_POST['Search']);
				 
			  }
	 ?>  
     </div>
  
            	<?php
				$div = $_POST['Div'];
				//unset($_POST['Div']);
				 if($div=='jobposting'){
					 ?>
						<script type="text/javascript">
		       			document.getElementById('postingsDiv').style.display = "block"; 
		      			</script>
				<?php
			                            }
										
					echo "<table border='1'  height='auto' >
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

					 if(mysqli_num_rows($signedAppli) == 0){
					    $AorC = 'A';
					}
					else{
						$AorC = 'C';
					}
		            if ($AorC == 'A'){ 
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
         
    			<?php
				//may need to add a field in APPLIES to show this part
				$result = mysqli_query($con,"SELECT * FROM APPLIES WHERE s_id = '$sid'");

				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>	
				<th>Student ID</th>
				<th>Company ID</th>
				<th>Job ID</th>
				<th>Application Number</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['ApplicationN'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			   ?>
               
</div>
        

<div id="Offers Accepted"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM STUDENT_SIGNS WHERE s_id = '$sid'");
				//change this to a view that also show content of contract later

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
</div>
        
      
        
<!-------------------------------------------Interface area----------------------------------------------------->	
	

	
	
</body>
</html>