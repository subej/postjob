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

				if(isset($_POST['username'])){$username = $_POST['username'];} else{exit();}
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
	$compresult = mysqli_query($con,"SELECT * FROM COMPANY C WHERE C.co_id =" . $co_id );	
	$compstring = '';	
	while($row = mysqli_fetch_array($compresult)) {
		$compstring.= "Company Name: <br><b>" . $row['Name'] . "</b><br>";	
		$compstring.= "Address:<br><b>" .$row['StreetNumber'] . $row['StreetName'] . "<br>" . $row['City'] . $row['Province'] . $row['PostalCode'] . "</b><br>";
	}

	$currentposts = 'Your job posts: <br>';
	$result = mysqli_query($con,"SELECT * FROM JOB_POSTING J WHERE J.co_id =" . $co_id );	
	while($row = mysqli_fetch_array($result)) {
		$currentposts.= "<tr>";	
		$currentposts.= "<td>" . $row['Position'] . "</td>";
		$currentposts.= "<td>" . $row['DatePosted'] . "</td> . <td><Button>Remove</Button></td>";
		$currentposts.= "</tr>";
	}	


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
		$appstring.= "<td>" . $row['Major'] . "</td>";
		$appstring.= "<td>" . $row['Year'] . "</td>";
		$appstring.= "<td>" . $row['Experience'] . "</td>";
		$appstring.= "<td>" . $row['Education'] . "</td>";
		$appstring.= "</tr>";
	}


	// All queries for candidates who companies have extended an offer to
	$offeredresult = mysqli_query($con,"SELECT FirstName, LastName, Faculty, Year, Major
	FROM STUDENT_STUDIES S, APPLIES A WHERE S.s_id = A.s_id AND A.Status = 'O/-' AND A.co_id = " . $co_id);
	if(!$offeredresult){ die('Error: ' . mysqli_error($con)); }
	$offeredstring = '';
	while($row = mysqli_fetch_array($candresult)){
	 	$offeredstring.= "<tr>";	
  		$offeredstring.= "<td>" . $row['FirstName'] . "</td>";
  		$offeredstring.= "<td>" . $row['LastName'] . "</td>";
		$offeredstring.= "<td>" . $row['Faculty'] . "</td>";
		$offeredstring.= "<td>" . $row['Year'] . "</td>";
		$offeredstring.= "<td>" . $row['Major'] . "</td>";
		$offeredstring.= "</tr>";
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

	// Handle query for Student Searches
	$studentsearch = '';
	// Since there is a lot of data, create the query strings by concat
	if(isset($_POST['grad'])){
		$queryconstructor = 'SELECT FirstName, LastName';
		if($_POST['suniversity'] != 'any'){$queryconstructor.= ", Name ";}
		$queryconstructor.= " FROM STUDENT_STUDIES s ";
		if($_POST['suniversity'] != 'any'){$queryconstructor.= ", UNIVERSITY u ";}
		$queryconstructor.= "WHERE";
		// This boolean keeps track of if a comma is necessarry
		$ispreceeded = False;
		if($_POST['sfaculty'] != 'any'){$queryconstructor.= " s.Faculty='" . $_POST['sfaculty'] . "'"; $ispreceeded = True;}
		if($_POST['syear'] != 'any' && $ispreceeded){$queryconstructor.=" AND s.Year=" . $_POST['syear']; $ispreceeded = True;}
		if($_POST['syear'] != 'any' && !$ispreceeded){$queryconstructor.=" s.Year=" . $_POST['syear']; $ispreceeded = True;}
		if($_POST['smajor'] != 'any' && $ispreceeded){$queryconstructor.=" AND s.Major='" . $_POST['smajor'] . "'"; $ispreceeded = True;}
		if($_POST['smajor'] != 'any' && !$ispreceeded){$queryconstructor.=" s.Major='" . $_POST['smajor'] . "'"; $ispreceeded = True;}
		if($_POST['suniversity'] != 'any' && $ispreceeded){$queryconstructor.=" AND u.u_id=" . $_POST['suniversity'];}
		if($_POST['suniversity'] != 'any' && !$ispreceeded){$queryconstructor.= " u.u_id=" . $_POST['suniversity'];}
		if($_POST['suniversity'] != 'any'){$queryconstructor.= " AND u.u_id=s.u_id";}
		if($_POST['grad'] == 'graduate'){
			if($ispreceeded || isset($_POST['suniversity'])){$queryconstructor.=" AND s.s_id IN (SELECT s_id FROM GRAD)";}
			else{$queryconstructor.= " s.s_id IN (SELECT s_id FROM GRAD)";}
			$gradresult = mysqli_query($con, $queryconstructor);
			//change this to a view that also show content of contract later
			if(!$gradresult){ 
				echo $queryconstructor;
				echo "I didn't query applications.";
				die('Error: ' . mysqli_error($con));
			}
			while($row = mysqli_fetch_array($gradresult)) {
		  		$studentsearch.= $row['FirstName'] . " " . $row['LastName'] . "<br>";
			}
			
			
		}
		if($_POST['grad'] == 'undergraduate'){
			if($ispreceeded || isset($_POST['suniversity'])){$queryconstructor.=" AND s.s_id NOT IN (SELECT s_id FROM GRAD)";}
			else{$queryconstructor.= " s.s_id NOT IN (SELECT s_id FROM GRAD)";}
			$ugradresult = mysqli_query($con,$queryconstructor);
			//change this to a view that also show content of contract later
			if(!$ugradresult){ 
				echo $queryconstructor;
				echo "I didn't query applications.";
				die('Error: ' . mysqli_error($con));
			}
			while($row = mysqli_fetch_array($ugradresult)) {
		  		$studentsearch.= $row['FirstName'] . " " . $row['LastName'] . "<br>";
			}
		}
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
   <?php
	// This PHP block handles initial job posting requests
    		if (isset($_POST['position'])) {
			$username = $_POST['username'];
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
			

	
			//bring contract we're about to put into the db
			echo "<br>";
			echo " <br>Job Title: ". $_POST['position'] . "<br>";
			echo "Salary: ".$_POST['salary']. "<br>";
			echo "Status: OPEN <br>"; 
			echo "Length: ".$_POST['timeType']. "<br>";
			echo "If this is right, please click the yes button below and your username <br>";
		        echo '<form action="EmployerInterface.php" method="post">';
			echo '<input type="radio" name="positionfinal" value="' . $_POST['position'] .'">This is correct<br>';
			echo '<input type="radio" name="positionfinal" value="reject">This is incorrect <br>';
   			echo '<input type="submit" value=' . $username . ' name="username">';
   			echo '</form>';


            exit();

		} 
	?>

	<?php
		if(isset($_POST['positionfinal'])){
    			//get all fields together for Job Post
    			//first need to pull timestamp
			date_default_timezone_set("Canada/Pacific");
			$date = date("Y-m-d");
			if($_POST['positionfinal'] != 'reject'){
				// This is the job title
				$jPosition  = $_POST['positionfinal'];
				//get company ID
				$compID = mysqli_query($con, "SELECT co_id FROM COMPANY WHERE Username ='$username'");
				if (!$compID) {
					echo 'MySQL ERROR: '. mysql_error();
					exit;
				} //Fine

				$crow = mysqli_fetch_array($compID, MYSQLI_NUM);
				$cID = $crow[0];
				//get contract ID from new post
				//need max contract # which is the new posting
    				$sql = 'SELECT MAX(c_id) FROM CONTRACT';
				$maxContract = mysqli_query($con, $sql);
				//check to see if we got our max
				if (!$maxContract) {
   					echo "DB Error, could not query the database\n";
    					echo 'MySQL Error: ' . mysql_error();
    					exit;
				}// Fine

				//get our maxcontact id number and increase it by one, this will be our contract num
				$row = mysqli_fetch_array($maxContract, MYSQLI_NUM);
				$maxContractID = $row[0];
			
				//need max job post # to ensure we create a unique one
    				$jsql    = 'SELECT MAX(j_id) FROM JOB_POSTING';
				$maxJob = mysqli_query($con, $jsql);
				//check to see if we got our max
				if (!$maxJob) {
   					echo "DB Error, could not query the database\n";
    					echo 'MySQL Error: ' . mysql_error();
    					exit;
				} // Fine
				//get our max job id number and increase it by one, this will be our job num
				$jrow = mysqli_fetch_array($maxJob, MYSQLI_NUM);
				$maxJobID = $jrow[0];
				$jobID = ($maxJobID + 1); //Fine
				$finalposition = $_POST['positionfinal'];
				//clean variables for insertion into table
				$jid = mysqli_real_escape_string($con, $jobID);	
				$cid = mysqli_real_escape_string($con, $maxContractID);
				$coid = mysqli_real_escape_string($con, $cID);
				$pt = mysqli_real_escape_string($con, $jPosition);
				$d = mysqli_real_escape_string($con, $date);
				//insert job into the db
				$jAddition = mysqli_query($con, "INSERT INTO JOB_POSTING(j_id, c_id, co_id, Position, DatePosted) VALUES ($jid, $cid, $coid, '$pt', '$d')");
				echo $contractID;
				if(!$jAddition) {
					die('Invalid query: ' .mysqli_error($con));
				} 
							 
			} 
		} 
	?>

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
      <li>
        <a href="javascript:activateTab('findstudents')">
	  <input type="button" name="OffersAccepted" value="Find Students" />
	</a>
      </li>
    </ul>
    <div id="tabCtrl">
      <div id="CompanyProfile" style="display: block;"
	class="answer_list">
	<?php 
	if(isset($_POST['username'])){$username = $_POST['username'];}
	echo "<p>" . $username . "'s Profile</p>";
	echo $compstring;
	echo "<table border='1'>
		<tr>	
		<th>Position</th>
		<th>Date Posted</th>
		</tr>";
		echo $currentposts;
		echo "</table>";
	if(isset($_POST['grad'])){
		echo 'Student search results: <br>' . $studentsearch;
	}
	?>
	
	</div>
	
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
      <div id="OffersExtended" style="display: none;">Offers Pedning 
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
			
			echo $offeredstring;

			echo "</table>";
	?>
      </div>
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
    <div id="findstudents" style="display: none;"> 
      <form action="<?php $_PHP_SELF ?>" method="post">
       Select whether you're looking for a graduate or undergraduate student:<br>
       <select name='grad'>
         <option value="undergraduate"> Undergraduate </option>
         <option value="graduate"> Graduate </option>
	 <option value='any'> ANY </option>
       </select>
       <br>
       <?php
        echo "<br>Select University:<br><select name='suniversity'>";
	$universityresult = mysqli_query($con,"SELECT Name, u_id FROM UNIVERSITY");
	if(!$universityresult){ die('Error: ' . mysqli_error($con)); }
	while($row = mysqli_fetch_array($universityresult)) {
		echo '<option value=' . $row['u_id'] . '>' . $row['Name'] . '</option>';
	}
	echo "<option value='any'> ANY </option>";
        echo "</select><br>";
        echo "<br>Select student's faculty:<br><select name='sfaculty'>";
	$facresult = mysqli_query($con,"SELECT DISTINCT Faculty FROM STUDENT_STUDIES");
	if(!$facresult){ die('Error: ' . mysqli_error($con)); }
	while($row = mysqli_fetch_array($facresult)) {
		echo '<option value=' . $row['Faculty'] . '>' . $row['Faculty'] . '</option>';
	}
	echo "<option value='any'> ANY </option>";
        echo "</select>";
        echo "<br>";
        echo "<br>Select student's year of study:<br><select name='syear'>";
	$yearresult = mysqli_query($con,"SELECT DISTINCT Year FROM STUDENT_STUDIES");
	if(!$yearresult){ die('Error: ' . mysqli_error($con)); }
	while($row = mysqli_fetch_array($yearresult)) {
		echo '<option value=' . $row['Year'] . '>' . $row['Year'] . '</option>';
	}
	echo "<option value='any'> ANY </option>";
        echo "</select>";
        echo "<br>";
        echo "<br>Select student's major:<br><select name='smajor'>";
	$majorresult = mysqli_query($con,"SELECT DISTINCT Major FROM STUDENT_STUDIES");
	if(!$majorresult){ die('Error: ' . mysqli_error($con)); }
	while($row = mysqli_fetch_array($majorresult)) {
		echo '<option value=' . $row['Major'] . '>' . $row['Major'] . '</option>';
	}
	echo "<option value='any'> ANY </option>";
        echo "</select>";
       ?>
       <br><br>
       <input type="submit" value='<?php echo $username; ?>' name="username" >
      </form>    
    </div>
    <div id="createJob" style="display: none;"> 
    				<!--Makes form to fill -->
    				
    		<form action="<?php $_PHP_SELF ?>" method="POST">
    			<br>
    			Position Title: <input type="text" name="position" placeholder="Title is required"><br>
    			<textarea rows="4" cols="50" name="description">Please describe the position. </textarea> <br>
    			Contract Length: <br>
    			<input type="radio" name="timeType" value='temporary'>Temporary<br>
			<input type="radio" name="timeType" value='longTerm'>Long Term <br>
			Salary: <input type="number" name="salary" placeholder="$" min="1"> <br>
			<input type="submit" name="username" value="<?php echo $username ?>"/>
			
    		</form>	
    	</div>
   </div>
	
  </body>
</html>
