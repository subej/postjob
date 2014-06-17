<html>
<body>
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
      function showOffers(){
	  document.getElementById(OffersAccepted).style.display = "block";
	  }
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
        <a href="javascript:activateTab('page1')">Your Profile</a>
      </li>
      <li>
        <a href="javascript:activateTab('page2')">Your Postings</a>
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
	<div id="OffersAccepted"
    		
    		class="answer_list">
			<p> I am a test. Can you see me? </p>
    			<?php
				//THIS TESTS FOR POST INFO
				$TEST = $_POST['username'];
				echo $TEST;
				if(isset($_POST['username'])){$username = $_POST['username'];}
				$con = mysqli_connect("localhost","root", "123456","newdb");
				$coidresult = mysqli_query($con,"SELECT co_id
				FROM COMPANY WHERE COMPANY.Username = '". $username . "'");
				if(!$coidresult){ 
					echo "I didn't query.";
					die('Error: ' . mysqli_error($con));
				}
				$co_id = null;
				while($row = mysqli_fetch_array($coidresult)){
					echo $row['co_id'];
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
  </body>
</html>