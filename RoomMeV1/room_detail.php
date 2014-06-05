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
	
	$rooms_ID = $_GET['Rooms_ID'];
?>

<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>Room Details</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
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

	<h2 id="pagetype">Room Details Page</h2>

		<?php
			//execute query
			$query = "SELECT Campus, Street_Address,City, State, Zip_code, Distance_to_school, Rooms.Price, "
					."Rooms.Min_term, Rooms.Start_date, Room_Type, Bathroom_Type, Capacity, Rooms.Parking, Rooms.Laundry,"
					."Rooms.Smoking, Rooms.Pets, Rooms.Description, Habits, In_Housing FROM"
					." Rooms, housing WHERE Rooms_ID = '$rooms_ID' AND housing_id = in_housing";
			$result = mysqli_query($con, $query);

			//if (mysqli_num_rows($result) == 0){
              //      echo "<h4> Room not found </h4>";
            //} else{
				$row = mysqli_fetch_array ($result);
				echo "<section>";
                echo "<h2>Room ID: ". $rooms_ID ."</h2>";

				//admin is able to see update and delete button
				$user_id = $_GET['user_id'];
				if ($user_id == 1000){
					echo "

					<h2>

					<a href=\"updateroom.php?user_id=1000&Room_ID=$rooms_ID\">
	                <input type=\"submit\" value=\"Update\"/></a>

	                <a href=\"deleteroom.php?user_id=1000&Room_ID=$rooms_ID\">
	                <input type=\"submit\" value=\"Delete\"/></a>

	                <a href=\"adminhome.php?user_id=1000\">
	                <input type=\"submit\" value=\"Back to AdminHome\"/></a>

	                </h2>

					";
				}


                echo "<ul>"
                	."<li> Campus: ".$row['Campus']."</li>" 
                	."<li> Address: ".$row["Street_Address"]. ", ".$row["City"].", ".$row["State"]." ".$row["Zip_code"]."</li>"
                	."<li> Distance to School: ". $row["Distance_to_school"]."</li>"
                	."<li> Price: $".$row['Price']."</li>"
                	."<li> Minimus Term: ".$row["Min_term"]." months </li>"
                	."<li> Avaiable Start date: ".$row["Start_date"]."  </li>"
                	."<li> Room Type: ".$row["Room_Type"]." </li>"
                	."<li> Bathroom Type: ".$row["Bathroom_Type"]." </li>"
                	."<li> Capacity: ".$row["Capacity"]." </li>"
                	."<li> Parking: ".$row["Parking"]." </li>"
                	."<li> Laundry: ".$row["Laundry"]." </li>"
                	."<li> Smoking: ".$row["Smoking"]." </li>"
                	."<li> Pets: ".$row["Pets"]." </li>"
                	."<li> Description: ".$row["Description"]." </li>"
                	."<li> Habits: ".$row["Habits"]." <br/>"
                	."--------------------------------------------------</li>"
                	."<li> In Housing #".$row["In_Housing"]." </li>";

	            //who's primary tenant
				$query2 = "SELECT * FROM Primary_tenant, rooms, tenant WHERE Rooms_ID = '$rooms_ID'"
							." AND In_Housing = Rents_Housing AND Primary_tenant.Tenant_ID = tenant.Tenant_ID ";
				$ptenant = mysqli_query($con,$query2); 
				$row2 = mysqli_fetch_array ($ptenant);
				
				//who's secondary tenant in the housing
				$query3 = "SELECT * FROM tenant, Secondary_tenant WHERE Renting_room = '$rooms_ID' AND "
						."Secondary_tenant.Tenant_ID = tenant.Tenant_ID ";
				$tenant = mysqli_query($con,$query3);
				
				
				if (mysqli_num_rows($ptenant) == 0){
                    echo "<li> Room is unoccupied. </li>";
            	} else{
            		echo "<li> Rented By Primary Tenant ID #".$row2["Tenant_ID"].": ".$row2["Fname"]." ".$row2["Lname"]." </li>";
            		while ($row3 = mysqli_fetch_array ($tenant)){
						echo "<li> Rented By Secondary Tenant ID #".$row3["Tenant_ID"]
							.": ".$row3["Fname"]." ".$row3["Lname"]." </li>";

            		}
					
            	}
			
			echo "</ul></section>";


            //}
			

			mysqli_close($con);
		?>


   </body>
   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>