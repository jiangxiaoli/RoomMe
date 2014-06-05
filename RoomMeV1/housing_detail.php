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
	
	$housing_ID = $_GET['Housing_ID'];
	

	?>
<html>

   <head>
   <!-- 
   	housing detail Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Housing Details</title>
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

	<h2 id="pagetype">House Details Page</h2>

		<?php
			//execute query
			$query = "SELECT * FROM housing WHERE Housing_ID = '$housing_ID'";
			$result = mysqli_query($con, $query);
			
			//if (mysqli_num_rows($result) == 0){
            //        echo "<h4> Room not found </h4>";
            //} else{

			$row = mysqli_fetch_array ($result);


			echo "<section>";
            echo "<h2>Housing ID: $housing_ID </h2> ";

			//admin is able to see update and delete button
			$user_id = $_GET['user_id'];
			if ($user_id == 1000){
				echo "

				<h2>

				<a href=\"updatehousing.php?user_id=1000&Housing_ID=$housing_ID\">
                <input type=\"submit\" value=\"Update\"/></a>

                <a href=\"deletehousing.php?user_id=1000&Housing_ID=$housing_ID\">
                <input type=\"submit\" value=\"Delete\"/></a>

                <a href=\"adminhome.php?user_id=1000\">
                <input type=\"submit\" value=\"Back to AdminHome\"/></a>

				";
			}

                echo "</h2>
          			  <ul>"
                	."<li> Campus: ".$row['Campus']."</li>" 
                	."<li> Address: ".$row["Street_Address"]. ", ".$row["City"].", ".$row["State"]." ".$row["Zip_code"]."</li>"
                	."<li> Distance to School: ". $row["Distance_to_school"]."</li>"
                	."<li> Price: $".$row['Price']."</li>"
                	."<li> Minimum Term: ".$row["Min_term"]." months </li>"
                	."<li> Avaiable Start date: ".$row["Start_date"]."  </li>"
                	."<li> Number of Bedrooms: ".$row["No_of_Bedrooms"]." </li>"
                	."<li> Number of Bathrooms: ".$row["No_of_Bathrooms"]." </li>"
                	."<li> Max Capacity: ".$row["Max_capacity"]." </li>"
                	."<li> Parking: ".$row["Parking"]." </li>"
                	."<li> Laundry: ".$row["Laundry"]." </li>"
                	."<li> Smoking: ".$row["Smoking"]." </li>"
                	."<li> Pets: ".$row["Pets"]." </li>"
                	."<li> Description: ".$row["Description"] . "<br/>"
                	." --------------------------------------------------</li>";

             $landlord_ID=$row["Owned_by"];
             //echo "id:".$landlord_ID;

	            //who's landlord 
				$query2 = "SELECT * FROM landlord WHERE Landlord_ID = '$landlord_ID' ";
				$landlord = mysqli_query($con,$query2); 
				$row2 = mysqli_fetch_array ($landlord);

				echo "<li> Owned By Landlord ID #".$row2["Landlord_ID"].": ".$row2["Fname"]." ".$row2["Lname"]." </li>";

				//who's primary tenant in the housing
				$query3 = "SELECT * FROM tenant, Primary_tenant WHERE Rents_Housing = '$housing_ID' AND "
						."Primary_tenant.Tenant_ID = tenant.Tenant_ID ";
				$tenant = mysqli_query($con,$query3);
				
				
				if (mysqli_num_rows($tenant) == 0){
                    echo "<li> House is unoccupied. </li>";
            	} else{
            		$row3 = mysqli_fetch_array ($tenant); 
					echo "<li> Rented By Tenant ID #".$row3["Tenant_ID"].": ".$row3["Fname"]." ".$row3["Lname"]." </li>";
            	}
			
			echo "</ul></section>";

			
			
			mysqli_close($con);
		?>



   </body>
   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>