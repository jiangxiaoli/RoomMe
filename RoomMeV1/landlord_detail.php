<?php
	//database settings
	$host="localhost";
	$username="root";
	$password="root";
	$database="roomme";
	
	//connect to database
	$con = mysqli_connect($host,$username,$password, $database);
	if (mysqli_connect_errno($con)) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	} 
	//mysql_select_db("$database") or die("Cannot select DB");
	
	$Landlord_ID = $_GET['Landlord_ID'];
	

	?>
<html>

   <head>
   <!-- 
   	landlord detail Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Landlord Details</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
	<style>
	.resultlist th {
		  padding: 0 10px 0 10px;
		}
		table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):after { 
						content: " \25B4\25BE" 
					}
	</style>
	<script src="sorttable.js"></script>
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

	
  <nav>
      <ul>
        <li><a href="homepage.html">RoomMe Home</a></li>
      </ul>
    </nav>

	</br>	
	</br>

	<h2 id="pagetype">Landlord Details Page</h2>

		<?php

			if (isset($_GET['user_id'])) {
				$user_id = $_GET['user_id'];
				
				if ($user_id == 1000){
				//execute query
				$query = "SELECT * FROM landlord WHERE Landlord_ID = '$Landlord_ID'";
				$result = mysqli_query($con, $query);

				$row = mysqli_fetch_array ($result);


				echo "<section>";
	            echo "<h2>Landlord ID: $Landlord_ID </h2> ";

				//admin is able to see update and delete button
					echo "

					<h2>

					<a href=\"updateusers.php?user_id=1000&Landlord_ID=$Landlord_ID\">
	                <input type=\"submit\" value=\"Update\"/></a>

	                <a href=\"managetenants.php?user_id=1000&Landlord_ID=$Landlord_ID\">
	                <input type=\"submit\" value=\"Delete\"/></a>

	                <a href=\"adminhome.php?user_id=1000\">
	                <input type=\"submit\" value=\"Back to AdminHome\"/></a>

					";


                echo "</h2>
          			  <ul>"
                	."<li> Landlord_ID: ".$row['Landlord_ID']."</li>" 
                	."<li> Username: ".$row["Username"]."</li>"
                	."<li> Password: ". $row["Password"]."</li>"
                	."<li> First Name: ".$row['Fname']."</li>"
                	."<li> Last Name: ".$row["Lname"]." </li>"
                	."<li> Email: ".$row["Email"]."  </li>"
                	."<li> Phone Number: ".$row["Phone_number"]." </li>";

			echo "</ul></section>";

				} 
			}else {
					echo "
					<nav>
					<ul>
						<li><a href='homepage.html'>RoomMe Home</a></li>
						<li><a href='userhome.php'>User Home</a></li>
						<li><a href='posthouse.php'>Post Housing</a></li>
						<li><a href='postroom.php'>Post a Room</a></li>
					</ul>
					</nav>

					</br>	
					</br>

					<h2>For Admin Only</h2>

					<p>Please <a href='signin.html'>login</a> to get Admin access.</p>";
			}
			
			mysqli_close($con);
		?>



   </body>
   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>