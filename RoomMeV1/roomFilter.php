<?php
	//database settings
	$host="localhost";
	$username="root";
	$password="root";
	$database="roomme";
	$table1 = "rooms";
	$table2 = "housing";

	//connect to database
	$con = mysqli_connect($host,$username,$password, $database);
	if (mysqli_connect_errno($con)) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	} 

	// Initialize query string
	$query = "SELECT A.Rooms_ID, A.Price, A.Room_Type, A.Bathroom_Type, A.Start_date, A.Capacity, A.Parking, A.Laundry,			A.Smoking, A.Pets, B.Street_Address, B.City, B.State, B.Zip_code, B.Distance_to_school 
			FROM $table1 A,	$table2 B WHERE A.In_Housing = B.Housing_ID";
	if(!empty($_GET)){
		$room_type =$_GET['roomtype'];
		$bathroom_type =$_GET['bathroomtype'];
		$capacity = $_GET['max_capacity'];
		$min_price = $_GET['min_price'];
		$max_price = $_GET['max_price'];
		$start_date = $_GET['start_date'];
		$city = $_GET['city'];
		$state = $_GET['state'];
		$zip_code = $_GET['zip_code'];
		$distance = $_GET['distance'];
		$parking = $_GET['parking'];
		$laundry = $_GET['laundry'];
		$smoking = $_GET['smoking'];
		$pets = $_GET['pets'];
		
		if($room_type != ""){
			$query .= " AND A.Room_Type = '$room_type'";
		}
		if($bathroom_type != ""){
			$query .= " AND A.Bathroom_Type = '$bathroom_type'"; 
		}
		if(($min_price != "") && ($max_price != "")){
			$query .= " AND A.Price BETWEEN $min_price AND $max_price";
		}
		if ($capacity != "") {
			$query .= " AND A.Capacity <= $capacity";
		}
		if ($city != ""){
			$query .= " AND B.City = '$city'";
		}
		if ($state != ""){
			$query .= " AND B.State = '$state'";
		}
		if($zip_code != ""){
			$query .=" AND B.Zip_code = $zip_code";
		}
		if($distance != "")	{
			$query .= " AND B.Distance_to_school <= $distance";
		}				
		if ($start_date != ""){
			$query .= " AND A.Start_date <= '$start_date'";
		}		
		if ($parking != "") {
			$query .= " AND A.Parking = '$parking'";
		}		 
		if ($laundry != "")	{
			$query .= " AND A.Laundry = '$laundry'";
		}
		if ($smoking != ""){
			$query .= " AND A.Smoking = '$smoking'";
		}
		if ($pets != ""){
			$query .= "AND A.Pets = '$pets'";
		}		
	}
	//echo "Query:  $query";
	//execute query
	$result = mysqli_query($con, $query);
	mysqli_close($con);
?>

<html>
  <head>
  <!--Searching Result Cmpe 180-38 Team 6 -->

	<meta charset="UTF-8" />
	<title>Result List</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
	<style>
		.resultlist {
				     margin: 10px;
					 color: blue; 
					 background: #E0F8F7;
					 padding: 20px 30px 20px 30px;
					 text-align: center;
					}
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
			<li><a href="userhome.php">User Home</a></li>
			<li><a href="postroom.html">Post a Room</a></li>
			<li><a href="signup.html">Sign up</a></li>
		</ul>
	</nav>
	<br>
	<section> 
		<p><b> Your Searching Setting:</b><br>
		<?php 
				//echo $query;
				echo "Room Type: $room_type<br>
					  Bathroom Type: $bathroom_type<br>
					  Max Capacity: $capacity <br>
					  Price:  min: $min_price  max:$max_price <br>
					  Start Date Since: $start_date<br>
					  State: $state<br>
					  Zip Code: $zip_code<br>
	   				  Distance to School: $distance<br> 
					  Parking: $parking <br>
					  Laundry: $laundry<br>
					  Smoking: $smoking<br>
					  Pets: $pets<br>
				";
			?>
		</p>
	</section>
	<br>
	<p><h2 id="pagetype">Searching Result</h2></p>
	<table class="resultlist sortable">
	  <thead>
		<th>ROOM_ID</th>
		<th>Room_Type</th>
		<th>Bathroom_Type</th>
		<th>Start_Date</th>
		<th>Street</th>
		<th>City</th>
		<th>State</th>
		<th>Zip Code</th>
	   	<th>Distance to School</th>
		<th>Price</th>
		<th>Capacity</th>
		<th>Parking</th>
		<th>Laundry</th>
		<th>Smoking</th>
		<th>Pets</th>
	  </thead>
	  <tbody>
	  <?php
		if (mysqli_num_rows($result) == 0){
			echo "<h4> No Data </h4>";
		}
		else {
			while( $row = mysqli_fetch_array ($result)) {
				$Rooms_ID = $row['Rooms_ID'];
				$roomtype = $row['Room_Type'];
				$bathtoomtype = $row['Bathroom_Type'];
				$start_date = $row['Start_date'];
				$Street_Address = $row['Street_Address'];
				$city = $row['City'];
				$state = $row['State'];
				$zip_code = $row['Zip_code'];
				$Distance = $row["Distance_to_school"];
				$Price = $row["Price"];
				$max_capacity = $row['Capacity'];
				$parking = $row['Parking'];
				$laundry = $row['Laundry'];
				$smoking = $row['Smoking'];
				$pets = $row['Pets'];
				echo" <tr>
						<td> <a href=\"roomdetail.php?Rooms_ID=$Rooms_ID\">$Rooms_ID</a></td>
						<td> $roomtype</td>
						<td> $bathtoomtype</td>
						<td> $start_date</td>
						<td> $Street_Address</td>
						<td> $city</td>
						<td> $state</td>
						<td> $zip_code</td>
						<td> $Distance</td>
						<td> $Price</td>
						<td> $max_capacity</td>
						<td> $parking</td>
						<td> $laundry</td>
						<td> $smoking</td>
						<td> $pets</td>
					</tr>";
			}
		}
		
	  ?>
	  </tbody>
	</table>
	<p><h6><a href="homepage.html"> Back to Home Page</a></h6>
 </body>
</html>
