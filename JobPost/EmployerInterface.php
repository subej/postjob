<html>
<body>

<!-- YOU WILL NEED TO CHANGE YOUR CONNECTION SETTINGS TO MAKE THIS WORK. -->

<?php

	//Change your connection settings to make this work 
	$con=mysqli_connect("localhost","root","Compouter25624!", "cpsc304");
	if(!$con){ 
		echo "Connection failed"; 
	}
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

				if(isset($_POST['username'])){$username = $_POST['username'];}
				$coidresult = mysqli_query($con,"SELECT * FROM COMPANY WHERE COMPANY.Username = '". $username . "'");

				if(!$coidresult){ 
					echo "I didn't query.";
					die('Error: ' . mysqli_error($con));
				}	
				$co_id = null;
				while($row = mysqli_fetch_array($coidresult)){
					$co_id = $row['co_id'];
				}
	
	// Due to obstacles from so many queries, the data is stashed in arrays:
	// Query for company profile
	$result = mysqli_query($con,"SELECT * FROM JOB_POSTING J WHERE J.co_id =" . $co_id );	
	
	// All queries for job applicants to make appropriate HTML script into one string
	$candresult = mysqli_query($con,"SELECT FirstName, LastName, Faculty, Year, Major, Experience, Education
	FROM STUDENT_STUDIES S, APPLIES A, PROFILE_CREATES P WHERE S.s_id = P.s_id AND S.s_id = A.s_id AND P.s_id = A.s_id AND A.co_id = " . $co_id);
	if(!$candresult){ die('Error: ' . mysqli_error($con)); }
	$appstring = '';
	while($row = mysqli_fetch_array($candresult)){
	 	$appstring.= "<tr>";	
  		$appstring.= "<td>" . $row['FirstName'] . "</td>";
  		$appstring.= "<td>" . $row['LastName'] . "</td>";
		$appstring.= "<td>" . $row['Faculty'] . "</td>";
		$appstring.= "<td>" . $row['Year'] . "</td>";
		$appstring.= "<td>" . $row['Major'] . "</td>";
		$appstring.= "<td>" . $row['Experience'] . "</td>";
		$appstring.= "<td>" . $row['Education'] . "</td>";
		$appstring.= "</tr>";
	}


	// All queries for applicants who accepted job offers
	$oaresult = mysqli_query($con,"SELECT * FROM APPLIES A, STUDENT_STUDIES S WHERE S.s_id = A.s_id AND A.co_id =" . $co_id );
	//change this to a view that also show content of contract later
	if(!$oaresult){ 
		echo "I didn't query applications.";
		die('Error: ' . mysqli_error($con));
	}
	
	$oastring = '';

	while($row = mysqli_fetch_array($oaresult)) {
  		$oastring.= "<tr>";	
  		$oastring.= "<td>" . $row['s_id'] . "</td>";
		$oastring.= "<td>" . $row['FirstName'] . "</td>";
		$oastring.= "<td>" . $row['LastName'] . "</td>";
		$oastring.= "<td>" . $row['Faculty'] . "</td>";
		$oastring.= "<td>" . $row['Year'] . "</td>";
		$oastring.= "<td>" . $row['Major'] . "</td>";
		$oastring.= "</tr>";
	}
?>





<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
    <script type="text/javascript">
      function activateTab(pageId) {
          var tabCtrl = document.getElementById('tabCtrl');
          var pageToActivate = document.getElementById(pageId);
          for (var i = 0; i < tabCtrl.childNodes.length; i++) {
              var node = tabCtrl.childNodes[i];
              if (node.nodeType == 1) { /* Element */
                  node.style.display = (node == pageToActivate) ? 'block' : 'none';
              }
          }
      }
      
    </script>
  </head>
  <body>
    <ul>
      <li>
        <a href="javascript:activateTab('CompanyProfile')">
	<input type="button" name="newPost" value="CompanyProfile" />
	</a>
      </li>
      <li>
	<a href="javascript:activateTab('Candidates')">
	<input type="button" name="newPost" value="Candidates" />
        </a>
      </li>
      <li>
	<a href="javascript:activateTab('OffersExtended')">
	<input type="button" name="newPost" value="OffersExtended" />
        </a>
      </li>
      <li>
        <a href="javascript:activateTab('OffersAccepted')">
	<input type="button" name="OffersAccepted" value="OffersAccepted" />
	</a>
      </li>
      <li>
        <a href="javascript:activateTab('createJob')">
	<input type="button" name="OffersAccepted" value="Create a new Job Post" />
	</a>
      </li>
    </ul>
    <div id="tabCtrl">
      <div id="CompanyProfile" style="display: block;"
	class="answer_list">
	<?php 
	echo "<p>" . $username . "'s Profile</p>";
	if(isset($_POST['username'])){$username = $_POST['username'];}

				echo "<table border='1'>
				<tr>	
				<th>JOBID</th>
				<th>CONTRACT-ID</th>
				<th>Position</th>
				<th>DatePosted</th>
				
				
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['DatePosted'] . "</td>";					
					echo "</tr>";
				}

				echo "</table>";
	?>
	
	</div>
	
      <div id="CreateNewJobPost" style="display: none;">Your Postings </div>
      <div id="Candidates" style="display:none;">Posting Candidates
	<?php			
		echo "<table border='1'>
				<tr>	
				<th>First Name</th>
				<th>Last Name</th>
				<th>Faculty</th>
				<th>Year</th>	
				<th>Major</th>
				<th>Experience</th>
				<th>Education</th>
			</tr>";
		echo $appstring;
		echo "</table>";
	?>
      </div>
      <div id="OffersExtended" style="display: none;">Offers Pedning</div>
      <div id="OffersAccepted" style="display: none;">
      <?php

				echo "<table border='1'>
				<tr>	
				<th>Student ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Faculty</th>
				<th>Year</th>	
				<th>Major</th>
				
				</tr>";
				echo $oastring;

				echo "</table>";
			?>
		</div>    
    <div id ="createJob" style="display: none;"> 
    				<!--Makes form to fill -->
    				
    		<form action="<?php $_PHP_SELF ?>" method="POST">
    			<br>
    			Position Title: <input type="text" name="position" placeholder="Title is required"><br>
    			<textarea rows="4" cols="50" name="description">
				Please describe the position. </textarea> <br>
    			Contract Length: <br>
    			<input type="radio" name="timeType" value='temporary'>Temporary<br>
			<input type="radio" name="timeType" value='longTerm'>Long Term <br>
			Salary: <input type="number" name="salary" placeholder="$" min="1"> <br>
			<input type="submit" name="username" value="<?php echo $username ?>"/>
			
    		</form>	
    	</div>
   </div>
    	
   <?php
    		if (isset($_POST['position'])) {
    			
    			$username = $_POST['username'];
    		
    			//get all fields together for Job Post
    			//first need to pull timestamp
			date_default_timezone_set("Canada/Pacific");
			$date = date("Y-m-d");
			
			//get fields from query
			$jPosition  = $_POST['position'];
    			$jDesc = $_POST['description'];
   		 	$jTimePeriod = $_POST['timeType'];
    			$jSalary = $_POST['salary'];
			
			//get company ID
			$compID = mysqli_query($con, "SELECT co_id FROM COMPANY WHERE Name ='$username'");
			if (!$compID) {
				echo 'MySQL ERROR: '. mysql_error();
				exit;
			}
			 
			 
			$crow = mysqli_fetch_array($compID, MYSQLI_NUM);
			$cID = $crow[0];
			
			
			//need max contract # to ensure we create a unique one
    			$sql    = 'SELECT MAX(c_id) FROM CONTRACT';
			$maxContract = mysqli_query($con, $sql);
			//check to see if we got our max
			if (!$maxContract) {
   				echo "DB Error, could not query the database\n";
    				echo 'MySQL Error: ' . mysql_error();
    				exit;
			}
			
			//get our maxcontact id number and increase it by one, this will be our contract num
			$row = mysqli_fetch_array($maxContract, MYSQLI_NUM);
			$maxContractID = $row[0];
			$contractID = ($maxContractID + 1);
			//insert our contract into the db
			$cAddition = mysqli_query($con, "INSERT INTO CONTRACT VALUES ($contractID, $jSalary, 'open', '$jTimePeriod')");
			//make sure that insertion worked
			if (!$cAddition) {
    				die('Invalid query: ' . mysqli_error($con));	
			}
			
			
		    //need max job post # to ensure we create a unique one
    			$jsql    = 'SELECT MAX(j_id) FROM JOB_POSTING';
			$maxJob = mysqli_query($con, $jsql);
			//check to see if we got our max
			if (!$maxJob) {
   				echo "DB Error, could not query the database\n";
    				echo 'MySQL Error: ' . mysql_error();
    				exit;
			}
			//get our max job id number and increase it by one, this will be our job num
			$jrow = mysqli_fetch_array($maxJob, MYSQLI_NUM);
			$maxJobID = $jrow[0];
			$jobID = ($maxJobID + 1);
			

			//insert job into the db
			$jAddition = mysqli_query($con, "INSERT INTO JOB_POSTING(j_id, c_id, co_id, Position, DatePosted) VALUES ($jobID, $contractID, $cID, '$jPosition', CURDATE())");
			echo $contractID;
			if(!$jAddition) {
				die('Invalid query: ' .mysqli_error($con));
			}
    			
    			//Just print the job that we are about to put into the db
    			echo "<br>";
   			echo "Job Post Created: <br>";
   			echo "<br>";
   			echo "Job ID: ". $jobID . "<br>";
   			echo "Contract ID: ". $contractID . "<br>";
   			echo "Company ID: ".$cID."<br>";
   			echo "Position Title:  ". $_POST['position']. "<br>";
            echo "Description: ". $_POST['description']. "<br>";
            echo "Date Posted: ". $date. "<br>";
    			
	
			//bring contract we're about to put into the db
			echo "<br>";
			echo " <br>Contract ID: ". $contractID. "<br>";
			echo "Contract Salary: ".$_POST['salary']. "<br>";
			echo "Contract Status: OPEN <br>"; 
			echo "Contract Length: ".$_POST['timeType']. "<br>";

            exit();
		} 
	?>
	
  </body>
</html>
