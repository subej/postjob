<html>
<style type="text/css">
.page1 {
	background-color: #FC0;
	border: thick solid #F00;
}
</style>
<body>

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
  


    <?php
	// These variables are extracted from the text boxes each time this page is called 
       $username = $_POST['username'];
	   global $con, $sid;
	   $con=mysqli_connect("localhost","root","123456", "newdb");
	   if(!$con){ 
		echo "Connection failed"; 
	}
	// Check connection
	   if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

        $username = "admin";
        $sidresult = mysqli_query($con,"SELECT s_id FROM STUDENT_STUDIES  WHERE username = '$username' ");
		while($row = mysqli_fetch_array($sidresult))
		$sid = $row['s_id'];
	//delete it after finished    
		echo $username;
		echo $sid;

  function sendApplication($sid){//to apply a posted job
        $con=mysqli_connect('localhost','root','', 'jobpost');
		$jid=$_POST["Apply"];
		$result = mysqli_query($con,"SELECT * FROM JOB_POSTING WHERE j_id = '$jid'");
		$row = mysqli_fetch_array($result);
		$coid = $row['co_id'];
		$maxAliNum = mysqli_query($con, "SELECT DISTINCT MAX(ApplicationN) AS AppliN FROM APPLIES");
		$rowA = mysqli_fetch_array($maxAliNum);
		$apliN = (int)$rowA['AppliN'] + 1 ;
        
		if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
		echo $sid;
		echo $jid;
		echo $coid;
        echo $apliN;
        $query = "insert into applies (s_id,co_id,j_id,ApplicationN) VALUES ($sid,$coid,$jid,$apliN)";
		mysqli_query($con,$query);
		mysqli_close($con);
        }
		
		  function CancelApplication($sid){//to cancel a posted job
		$con=mysqli_connect('localhost','root','', 'jobpost');
		$jid=$_POST["Cancel"];
        $query = "DELETE FROM APPLIES WHERE s_id = '$sid' AND j_id = '$jid'";
		mysqli_query($con,$query);
		mysqli_close($con);
        }
		
  function getDetails(){//get detail information of a company
                $con=mysqli_connect('localhost','root','', 'jobpost');
                $coid = $_POST['Detail'];
	            $result = mysqli_query($con,"SELECT * FROM COMPANY WHERE co_id = '$coid'");
				
                echo "Information of the company:";
				
				echo "<table border='1'>
				<tr>	
				<th>Name</th>
				<th>StreetNumber</th>
				<th>StreetName ID</th>
				<th>City</th>
				<th>Province</th>
				<th>PostalCode</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
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
  //delete later
  function ApplyOrCancel($jid,$sid){
	  $con=mysqli_connect('localhost','root','', 'jobpost');
	  $result = mysqli_query($con, "SELECT * FROM APPLIES WHERE j_id = '$jid' AND s_id = '$sid'");
	  while($row = mysqli_fetch_array($result)){
		  echo $row['s_id'];
		  if (is_null($row['s_id'])){  
		  echo 'apply';//for test
		    echo "<td ><input type='submit' value='Apply' name='Apply' ></td>";
		  }
		  else{
			  echo 'cancel' ; // for test
            echo "<td><input type='submit' value='Apply' name='Cancel' ></td>";
			  }
			 
		     
	  }
  }


?>



    <ul>
      <li>
        <input type="button" name="portfolio" value="Profile" onClick="showPort('profileDiv')" />
      </li>
      <li>
         <input type="button" name="posts" value="Job Postings" onClick="showPort('postingsDiv')" />
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
				$result = mysqli_query($con,"SELECT * FROM PROFILE_CREATES WHERE s_id = '$sid'");

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
            
            <form method="POST" action="StudentInterface.php">
    			<?php
				$con=mysqli_connect('localhost','root','', 'jobpost');
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING");
				echo "<table border='1' width='700px' height='auto'>
				<tr>	
				<th class='view_th' width='5%'>Job ID</th>
				<th class='view_th' width='5%'>Contract ID</th>
				<th class='view_th' width='5%'>Company ID</th>
				<th class='view_th' width='30%'>Position</th>
				<th class='view_th' width='15%'>>Date Posted</th>
				<th class='view_th' width='20%'>Apply</th>
				<th class='view_th' width='20%'>Detail</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td class='view_th' width='5%'>" . $row['j_id'] . "</td>";
					$jid = $row['j_id'];
  					echo "<td class='view_th' width='5%'>" . $row['c_id'] . "</td>";
  					echo "<td class='view_th' width='5%'>" . $row['co_id'] . "</td>";
					$coid = $row['co_id'];
  					echo "<td class='view_th' width='30%'>" . $row['Position'] . "</td>";
  					echo "<td class='view_th' width='15%'>" . $row['DatePosted'] . "</td>";
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
					     <button name='Detail' type='submit' value='$coid' onClick='showPort('postingsDiv')'>Detail</button></td>";		           
					echo "</tr>";
					
					//$coid = $row['co_id'];
					
				}

				echo "</table>";
				
				                  if(isset($_REQUEST['Apply']))
                                             {
                                 sendApplication($sid);
                                             }
                                 else if(isset($_REQUEST['Detail']))
                                             {
                                 getDetails();
                                              }
								 else if (isset($_REQUEST['Cancel']))
								 {
									 CancelApplication($sid);
								 }
			?>
            </form>
</div>
        
        <div id="Offers Pedning"
    		style="display:none;"
    		class="answer_list">
         
    			<?php
				//may need to add a field in APPLIES to show this part
				$result = mysqli_query($con,"SELECT * FROM APPLIES WHERE s_id = '$sid'");

				echo "<table border='1'>
				<tr>	
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
				<tr>	
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
        
      
        
	
	

	
	
</body>
</html>
