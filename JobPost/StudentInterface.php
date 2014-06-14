<html>
<body>

<?php
	$con=mysqli_connect("127.0.0.1","admin","pass", "JobPost", 3306);
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
      
      function showPort(x) {
	   		document.getElementById(x).style.display = "block";
	   		if (x != 'profileDiv') {
	   			document.getElementById('profileDiv').style.display = "none";
	   		}
	   		if (x != 'postingsDiv') {
	   			document.getElementById('postingsDiv').style.display = "none";
	   		}
	  }

    </script>
  </head>
  <body>
    <ul>
      <li>
        <input type="button" name="portfolio" value="Profile" onclick="showPort('profileDiv')" />
      </li>
      <li>
         <input type="button" name="posts" value="Job Postings" onclick="showPort('postingsDiv')" />
      </li>
      <li>
        <a href="javascript:activateTab('page4')">Offers Pedning</a>
      </li>
      <li>
        <a href="javascript:activateTab('page5')">Offers Accepted</a>
      </li>
    </ul>
    <div id="tabCtrl">
      <div id="page1" style="display: block;">Job Postings</div>
      <div id="page2" style="display: none;">Your Postings</div>
      <div id="page3" style="display: none;">Posting Candidates</div>
      <div id="page4" style="display: none;">Offers Pedning</div>
      <div id="page5" style="display: none;">Offers Accepted</div>
    </div>
    
    	<div id="profileDiv"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM PROFILE_CREATES");

				echo "<table border='1'>
				<tr>	
				<th>Student ID</th>
				<th>Profile ID</th>
				<th>Profile Date</th>
				<th>Experience</th>
				<th>Education</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['p_id'] . "</td>";
  					echo "<td>" . $row['p_date'] . "</td>";
  					echo "<td>" . $row['Experience'] . "</td>";
  					echo "<td>" . $row['Education'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
		
    	<div id="postingsDiv"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING");

				echo "<table border='1'>
				<tr>	
				<th>Job ID</th>
				<th>Contract ID</th>
				<th>Company ID</th>
				<th>Position</th>
				<th>Date Posted</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['Position'] . "</td>";
  					echo "<td>" . $row['DatePosted'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
		
 	<div id="postingsDiv"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING");

				echo "<table border='1'>
				<tr>	
				<th>Job ID</th>
				<th>Contract ID</th>
				<th>Company ID</th>
				<th>Position</th>
				<th>Date Posted</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['Position'] . "</td>";
  					echo "<td>" . $row['DatePosted'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
	
	

	
	
  </body>
</html>
