<html>
<!--------------------------css--------------------------------->
<style type="text/css">

#mainbar {
	position:absolute;
	width:auto;
	height:50px;
	top: 100px;
    left:0px;
}
#profileDiv{
	position:absolute;
	width:800px;
	height:auto;
	top: 250px;
	
}
#postingsDiv{
	position:absolute;
	width:800px;
	height:auto;
	top: 250px;

}
#offerspending{
	position:absolute;
	width:800px;
	height:auto;
	top: 250px;

}
#offersaccepted{
	position:absolute;
	width:800px;
	height:auto;
	top: 250px;

}
#editinfo{
		position:absolute;
	width:800px;
	height:auto;
	top: 250px;
}
#editprofile{
		position:absolute;
	width:800px;
	height:auto;
	top: 250px;
}

#deleteaccount{
	margin-left: 600px;
	margin-top:700px;	
}

#makesure{
	margin-left: 200px;
	margin-top:200px;
	width:300px;
	height:300px;
	border: thin solid #F00;
	background-color: #FFF;
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
			if (x != 'editinfo') {
	   			document.getElementById('editinfo').style.display = "none";
	   		}
			if (x != 'editprofile') {
	   			document.getElementById('editprofile').style.display = "none";
	   		}
			if (x != 'makesure') {
	   			document.getElementById('makesure').style.display = "none";
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
		
		checkbutton($sid,$con);
		//checkdiv();
		
		
		function checkdiv(){
			if(isset($_POST['Div'])){
				$div = $_POST['Div'];
				//showPort($div);	
			}
			
		}
		
		function checkbutton($sid,$con)
		{
			if(isset($_POST["submitprofile"])){
				              $pid = $_POST['pid'];
							  $pid = mysqli_real_escape_string($pid);
							  $pdate = $_POST['pdate'];
							  $pdate = mysqli_real_escape_string($pdate);
                              $experience = $_POST['experience'];
							  $experience = mysqli_real_escape_string($experience);
                              $education = $_POST['education'];
							  $education = mysqli_real_escape_string($education);
                              $query = "update PROFILE_CREATES set  Experience = '$experience', Education = '$education', p_date = '$pdate' WHERE s_id = $sid"; 
                              mysqli_query($con,$query);
                                }
								
		   if(isset($_POST["submitinfo"])){
							  $university = $_POST['universityid'];
							  $firstname = $_POST['firstname'];
							  $lastname = $_POST['lastname'];
							  $faculty = $_POST['faculty'];
							  $year = $_POST['year'];
							  $major = $_POST['major']; 
							  $query = "UPDATE STUDENT_STUDIES 
										SET u_id = $university, FirstName = '$firstname', LastName = '$lastname', Faculty = '$faculty', Year = $year, Major = '$major' 
										WHERE s_id = $sid"; 	
							 $query = mysqli_real_escape_string($con,$query);									
							  mysqli_query($con,$query);
			                    }
								
			if(isset($_POST["makenewprofile"])){
				          $pid = $_POS['pid'];
						  $pdate = $_POST['pdate'];
						  $experience = $_POST['experience'];
						  $education = $_POST['education'];		  
						  $query = "INSERT into profile_creates (s_id, p_id, p_date, Experience, Education) VALUES ($sid,$pid,'$pdate','$experience','$education')"; 
						  $query = mysqli_real_escape_string($con,$query);	
						  mysqli_query($con,$query);
                               }
							   
			  
			 if(isset($_POST['Apply']))
                                             {			 
								 sendApplication($sid,$con);
                                             }
			 if (isset($_POST['Cancel']))
								 			 {	 
								 CancelApplication($sid,$con);
								 			  }
											  
			 if(isset($_POST['Accept']))
                                             {			 
								 Accept($sid,$con);
                                             }
                                 
			  if (isset($_POST['CancelA']))
								 			 {
								 CancelAccept($sid,$con);
								 			  }
											  
											  
			  
							   
		}

  		function sendApplication($sid,$con)
		        {//to apply a posted job
				$jid=$_POST["Apply"];
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

				//----------------------------
				$query = "INSERT into applies (s_id,co_id,j_id,ApplicationN,Status) VALUES ($sid,$coid,$jid,$apliN,'$status')";
				//$query = mysqli_real_escape_string($con,$query);	
				mysqli_query($con,$query);
				mysqli_close($con);
				}
				
		 function Accept($sid,$con){
			 $aid = $_POST['Accept'];
			 $cid ='';
			 $cquery = "Select c.c_id FROM APPLIES a, JOB_POSTING j, CONTRACT c WHERE a.ApplicationN = $aid AND a.j_id =j.j_id AND j.c_id = c.c_id";
			 $cresult = mysqli_query($con, $cquery);
			 while($row = mysqli_fetch_array($cresult)){
				 $cid = $row['c_id'];
			 }
			 
			 $query = "UPDATE APPLIES
				            SET Status = 'O/A' WHERE ApplicationN = $aid"; 
			 date_default_timezone_set('America/Los_Angeles');
             $sdate = date('Y-m-d');
			 echo '/';
			 echo $cid;
			 echo '/';
			 echo $sdate;
			 $d = mysqli_real_escape_string($con, $sdate);
			 $query2 = "INSERT into student_signs (s_id,c_id,s_date) VALUES($sid,$cid,'$d')";
			 //$query = mysqli_real_escape_string($con,$query);	
			 $query2 = mysqli_real_escape_string($con,$query2);	
			 mysqli_query($con,$query);
			 mysqli_query($con,$query2);	 
		 }
		 
		 function CancelAccept($sid,$con){
			 $aid = $_POST['CancelA'];
			 $cid ='';
			 $cquery = "Select c.c_id FROM APPLIES a, JOB_POSTING j, CONTRACT c WHERE a.ApplicationN = $aid AND a.j_id =j.j_id AND j.c_id = c.c_id";
			 $cresult = mysqli_query($con, $cquery);
			 while($row = mysqli_fetch_array($cresult)){
				 $cid = $row['c_id'];
			 }
			 $query = "UPDATE APPLIES
				            SET Status = 'O/-' WHERE ApplicationN = $aid"; 
			 $query2 = "DELETE FROM STUDENT_SIGNS WHERE s_id = $sid AND c_id = $cid";
			 //$query = mysqli_real_escape_string($con,$query);	
			 //$query2 = mysqli_real_escape_string($con,$query2);	
			 mysqli_query($con,$query);
			 mysqli_query($con,$query2);
		 }
		
		  function CancelApplication($sid,$con)
		        {//to cancel a posted job
				$jid=$_POST['Cancel'];
				$query = "DELETE FROM APPLIES WHERE s_id = $sid AND j_id = $jid";
				$query = mysqli_real_escape_string($con,$query);	
				mysqli_query($con,$query);
				mysqli_close($con);
				}
		
  		  function getDetailsA(){//get detail information of a company
                $con=mysqli_connect('localhost','root','', 'jobpost');
                $coid = $_POST['DetailA'];
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
				
				function getDetails(){//get detail information of a company
                $con=mysqli_connect('localhost','root','', 'jobpost');
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
<div id="makesure"
    		style="display:none;"
    		class="answer_list">
            <form method="post" action="Homepage.php"> 
            <?php
			echo '<br>WARNING<br>';
			echo '<br>ARE YOU SURE <br>';
			echo '<br>YOU WANNA DELETE YOUR<br>';
			echo '<br>SUPER COOL ACCOUNT?<br>';
			echo '<br>Yes<input type = "radio" name = "deletecheck" value = "yes">
			      NO<input type = "radio" name = "deletecheck" value = "no"><br>';
			echo '<br><button input type = "submit" name = "deletecomfirm" value = "$sid" >Confirm</button><br>';
			
			?>
            
            </form>
</div>





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

<div id="editinfo"
     style="display:none;"
     class="answer_list">
     
     <form method="post" action="StudentInterface.php">
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

				  
			  
			  
		?>
        </form>    
</div>

<div id="editprofile"
     style="display:none;"
     class="answer_list">
     
     <form method="post" action="StudentInterface.php">
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
						$pdate = date('Y-m-d', time());
						 //echo $pdate;
						 //echo $pid;
						 echo "<br>You do not have a profile, please create a new one:";
						 echo "<br>Student ID: '$sid'<br>";
						 echo '<input type = "hidden" name = "pid" value = '.$pid.'>';
						 echo 'Your Experience:<br> <input type="text" name="experience" value ='.$experience.'><br>';
						 echo 'Your Education:<br> <input type="text" name="education" value ='.$education.'><br>';
						 echo 'Date:<br>'.$pdate.'<input type="hidden" name="pdate" value ='.$pdate.'><br>';
						 echo '<input type="submit" value="makenewprofile" name = "makenewprofile">';
						 echo "<br>";
					  
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
						  echo '<input type = "hidden" name = "pid" value = '.$pid.'>';
                          echo 'Your Experience:<br> <input type="text" name="experience" value ='.$experience.'><br>';
                          echo 'Your Education:<br> <input type="text" name="education" value ='.$education.'><br>';
                          echo 'Date:<br>'.$pdate.'<input type="hidden" name="pdate" value ='.$pdate.'><br>';
                          echo '<input type="submit" value="submitprofile" name = "submitprofile">';
                          echo "<br>";
                          
                  		  }
                  
            ?>
  </form>
     
    
</div>


<div id="profileDiv"
     style="display:none;"
     class="answer_list">
     
       <form method="post" action="StudentInterface.php">
       
<?php
				if(isset($_POST['makenewprofile'])||isset($_POST['submitprofile'])||isset($_POST['submitinfo']))
				{
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
				
										
				echo '<br>Hello,'.$firstname.' '.$lastname.' <br>';
				echo '<br>Here is your information: <br>';
				echo '<br>University: '.$uname.'<br>';
				echo '<br>Faculty: '.$faculty.'<br>';
				echo '<br>Year: '.$year.'<br>';
				echo '<br>Major: '.$major.'<br>';
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
            
  <input type="button" name="edit" value="editprofile" onClick="showPort('editprofile')" />
  <input type="button" name="edit" value="editinfo" onClick="showPort('editinfo')" />
</div>
		
 


 	       
   

           
<div id="postingsDiv"
     style="display:none;"
     class="answer_list">
    <form method="post" action="StudentInterface.php"> 
    
     <div id = "searchbar">
     <?php
	 $con=mysqli_connect('localhost','root','', 'jobpost');
	 $companypost = mysqli_query($con,"SELECT * FROM COMPANY c, JOB_POSTING p WHERE c.co_id = p.co_id;");
	 $positions = mysqli_query($con,"SELECT Position FROM JOB_POSTING ;");
	 $salaryhigh = mysqli_query($con,"SELECT DISTINCT j_id FROM CONTRACT C, JOB_POSTING p WHERE c.Salary >= 3500 AND c.c_id = p.c_id; ;");
	 $salarylow = mysqli_query($con, "SELECT DISTINCT j_id FROM CONTRACT C, JOB_POSTING p WHERE c.Salary < 3500 AND c.c_id = p.c_id; ;");
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
			  echo 'Keyword:<br> <input type="text" name="key" value= ><br>';
			  echo 'Only to show the latest post:<br> <input type="checkbox" name="latest" value= "latest"><br>';
			  echo "<button input type='submit' value='Search' name='Search' >Search</button>";
			  $result = mysqli_query($con,"SELECT * FROM JOB_POSTING");
			  if(isset($_POST['Search'])){
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
			  							}
			  

	 ?>  
     </div>
  
            	<?php
				if(isset($_POST['Apply'])||isset($_POST['Cancel'])||isset($_POST['Detail'])||isset($_POST['Search']))
				{
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

		            if (mysqli_num_rows($signedAppli) == 0){ 
		            		echo "<button name='Apply' input type='submit' value='$jid' >Apply</button>";
							
		                                        }
		  			else{
            				echo "<button name='Cancel' input type='submit' value='$jid'  >Cancel</button>";
							
			  									}						            
                    echo "</center></td>";
					echo "<td class='view_td' width='20%'><center>
					     <button name='Detail' type='submit' value='$coid' >Detail</button></td>";		           
					echo "</tr>";
												}

					echo "</table>";
					
					if(isset($_POST['Detail']))
                                             {	
								 echo "<input type = 'hidden' value = 'jobposting' name='Div'>";
                                 getDetails();
                                              }
				

			?>
            </form>
</div>
        
<div id="offerspending"
     style="display:none;">
                <form method="post" action="StudentInterface.php"> 
            	<?php
				if(isset($_POST['Accept'])||isset($_POST['CancelA'])||isset($_POST['DetailA']))
				{
				?>
				  <script type="text/javascript">
		       			document.getElementById('offerspending').style.display = "block"; 
		      			</script>
				<?php
			                            }

				$result = mysqli_query($con,"SELECT a.s_id,j.co_id,j.j_id,c.c_id,a.ApplicationN,a.Status 
				                             FROM APPLIES a, JOB_POSTING j, CONTRACT c 
											 WHERE a.s_id = $sid AND a.Status <> '-/-' AND j.j_id = a.j_id AND j.c_id = c.c_id ");

				echo "<table border='1'>
				<tr bgcolor='#F00' align='center' style='color:white;'>	
				<th>Student ID</th>
				<th>Company ID</th>
				<th>Job ID</th>
				<th>Contract ID</th>
				<th>Application Number</th>
				<th>Status</th>
				<th></th>
				<th></th>
				</tr>";
				$jid = '';
				$cid = '';
				$aid = '';
				$coid ='';

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['j_id'] . "</td>";
					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['ApplicationN'] . "</td>";
					echo "<td>" . $row['Status'] . "</td>";
				    $jid = $row['j_id'];
					$cid = $row['c_id'];
					$aid = $row['ApplicationN'];
					$coid = $row['co_id'];
				    $signed = mysqli_query($con, "SELECT * FROM STUDENT_SIGNS WHERE c_id = $cid AND s_id = $sid"); echo sizeof($signed) . "test";
		            if (mysqli_num_rows($signed) == 0){ 
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
					                echo "</tr>";
							    if(isset($_POST['DetailA']))
                                             {
                                 getDetailsA();
                                              }
			   ?>
               </form>
               
</div>
        


<div id="offersaccepted"
    		style="display:none;"
    		class="answer_list">
            <form method="post" action="StudentInterface.php"> 

<?php

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

<div id="deleteaccount">
<input type="button" name="deleteAccount" value="deleteaccount" onClick="showPort('makesure')" />
</div>


        
      
        
<!-------------------------------------------Interface area----------------------------------------------------->	
	

	
	
</body>
</html>