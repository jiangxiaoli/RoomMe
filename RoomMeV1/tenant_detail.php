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
	
	$Tenant_ID = $_GET['Tenant_ID'];
	

	?>
<html>

   <head>
   <!-- 
   	tenant detail Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Tenant Details</title>
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

	<h2 id="pagetype">Tenant Details Page</h2>

		<?php

			if (isset($_GET['user_id'])) {
				$user_id = $_GET['user_id'];
				
				if ($user_id == 1000){
					//execute query
					$query = "SELECT * FROM Tenant WHERE Tenant_ID = '$Tenant_ID'";
					$result = mysqli_query($con, $query);
					
					$row = mysqli_fetch_array ($result);

					echo "<section>";
		            echo "<h2>Tenant ID: $Tenant_ID </h2> ";

					//admin is able to see update and delete button
				
					echo "

					<h2>

					<a href=\"updateusers.php?user_id=1000&Tenant_ID=$Tenant_ID\">
	                <input type=\"submit\" value=\"Update\"/></a>

	                <a href=\"managetenants.php?user_id=1000&Tenant_ID=$Tenant_ID\">
	                <input type=\"submit\" value=\"Delete\"/></a>

	                <a href=\"adminhome.php?user_id=1000\">
	                <input type=\"submit\" value=\"Back to AdminHome\"/></a>

					";
				

	                echo "</h2>
	          			  <ul>"
	                	."<li> Tenant_ID: ".$row['Tenant_ID']."</li>" 
	                	."<li> Username: ".$row['Username']."</li>"
	                	."<li> Password: ". $row["Password"]."</li>"
	                	."<li> Fname: ".$row['Fname']."</li>"
	                	."<li> Lname: ".$row["Lname"]." </li>"
	                	."<li> School: ".$row["School"]."  </li>"
	                	."<li> Email: ".$row["Email"]." </li>"
	                	."<li> Phone_number: ".$row["Phone_number"]." </li>"
	                	."<li> Major: ".$row["Major"]." </li>"
	                	."<li> Gender: ".$row["Gender"]." </li>"
	                	."<li> Age: ".$row["Age"]." </li>"
	                	."<li> Home_country: ".$row["Home_country"]." </li>"
	                	."<li> Smoking: ".$row["Smoking"]." </li>"
	                	."<li> Pets: ".$row["Pets"]." </li>"
	                	."</ul></section>";

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