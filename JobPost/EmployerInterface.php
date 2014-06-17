<html>
<body>

<!-- YOU WILL NEED TO CHANGE YOUR CONNECTION SETTINGS TO MAKE THIS WORK. -->

<?php
	//Change your connection settings to make this work 
	$con = mysqli_connect("localhost","root", "123456","newdb");
	if(!$con){ 
		echo "Connection failed"; 
	}
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>





<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
    <script type="text/javascript">
t
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
<<<<<<< HEAD
      function showOffers(){
	  document.getElementById(OffersAccepted).style.display = "block";
	  }
=======
      
      
      function showJobForm() {
		document.getElementById('createJob').style.display = "block";
      }
      
      function showNewJob() {
      	
      }
      
>>>>>>> origin/master
    </script>
  </head>
  <body>
  <?php 
  // THIS IS A TEST
  if(isset($_POST['username'])){
    $TEST = $_POST['username'];
	echo $TEST;
	} else{
	  echo "I did not get a post request";
	}
  ?>
    <ul>
      <li>
         <input type="button" name="YourProfile" value="YourProfile" onclick="showJobPostings()" />
      </li>
      <li>
         <input type="button" name="newPost" value="Create New Job Post" onclick="showJobForm()" />
      </li>
      <li>
        <a href="javascript:activateTab('page3')">Posting Candidates</a>
      </li>
      <li>
        <a href="javascript:activateTab('page4')">Offers Pedning</a>
      </li>
      <li>
       <input type="button" name="Offers Accepted" value="Offers Accepted" onClick="showOffers()"
      </li>
    </ul>
	<div id ="YourProfile"
	class="answer_list">
	<?php 
	if(isset($_POST['username'])){$username = $_POST['username'];}
				
				$coidresult = mysqli_query($con,"SELECT co_id
				FROM COMPANY WHERE COMPANY.Username = '". $username . "'");
				$co_id = null;
				while($row = mysqli_fetch_array($coidresult)){
					
					$co_id = $row['co_id'];
					}
					$result = mysqli_query($con,"SELECT * FROM JOB_POSTING J WHERE J.co_id =" . $co_id );

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
	<div id="OffersAccepted"
    		
    		class="answer_list">
			
    			<?php
				
				if(isset($_POST['username'])){$username = $_POST['username'];}
				$con = mysqli_connect("localhost","root", "123456","newdb");
				$coidresult = mysqli_query($con,"SELECT co_id
				FROM COMPANY WHERE COMPANY.Username = '". $username . "'");
				
				$co_id = null;
				while($row = mysqli_fetch_array($coidresult)){
					
					$co_id = $row['co_id'];
				}
				$result = mysqli_query($con,"SELECT * FROM APPLIES A, STUDENT_STUDIES S WHERE S.s_id = A.s_id AND A.co_id =" . $co_id );
				//change this to a view that also show content of contract later
				if(!$result){ 
					echo "I didn't query applications.";
					die('Error: ' . mysqli_error($con));
				}
				echo "<table border='1'>
				<tr>	
				<th>Student ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Faculty</th>
				<th>Year</th>	
				<th>Major</th>
				
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['FirstName'] . "</td>";
  					echo "<td>" . $row['LastName'] . "</td>";
					echo "<td>" . $row['Faculty'] . "</td>";
					echo "<td>" . $row['Year'] . "</td>";
					echo "<td>" . $row['Major'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
    <div id="tabCtrl">
      <div id="page1" style="display: block;">Your Profile</div>
      <div id="page2" style="display: none;">Your Postings</div>
      <div id="page3" style="display: none;">Posting Candidates</div>
      <div id="page4" style="display: none;">Offers Pedning</div>
      <div id="page5" style="display: none;">Offers Accepted</div>
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
			<input type="radio" name="timeType" value=longTerm>Long Term <br>
			Salary: <input type="number" name="salary" placeholder="$" min="1"> <br>
			<input type="submit"/>
			
    		</form>	
    	</div>
    	
   <?php
    		if (isset($_POST['position'])) {
    			
    			$username = $_POST['username'];
    		
    			//get all fields together for Job Post
    			//first need to pull timestamp
			date_default_timezone_set("Canada/Pacific");
			$date = date("Y/m/d");
			
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
			
			//insert our contract into the db
			$cAddition = mysqli_query($con, "INSERT INTO CONTRACT VALUES ($contractID, $jSalary, 'open', '$jTimePeriod')");
			//make sure that insertion worked
			if (!$cAddition) {
    				die('Invalid query: ' . mysqli_error($con));	
			}
			
			//insert job into the db
			$jAddition = mysqli_query($con, "INSERT INTO JOB_POSTING VALUES ($jobID, $contractID, $cID, '$jPosition', $date)");
			
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
