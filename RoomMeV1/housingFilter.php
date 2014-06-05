<?php
	//database settings
	$host="localhost";
	$username="root";
	$password="root";
	$database="roomme";
	$table = "housing";
	//connect to database
	$con = mysqli_connect($host,$username,$password, $database);
	if (mysqli_connect_errno($con)) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	} 
	
	$query = "SELECT * FROM $table";
	$counter = 0;
	if(!empty($_GET)){
		$min_no_of_bedrooms =$_GET['min_no_of_bedrooms'];
		$max_no_of_bedrooms =$_GET['max_no_of_bedrooms'];
		$min_no_of_bathrooms = $_GET['min_no_of_bathrooms'];
		$max_no_of_bathrooms = $_GET['max_no_of_bathrooms'];
		$max_capacity = $_GET['max_capacity'];
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
	
	// construct query string
	
		if (($min_no_of_bedrooms != "") && ($max_no_of_bedrooms != "")){
			$query .= " WHERE No_of_Bedrooms BETWEEN $min_no_of_bedrooms AND $max_no_of_bedrooms";
			$counter++;
		}
		if (($min_no_of_bathrooms != "") && ($max_no_of_bathrooms != "")){
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .=" No_of_Bathrooms BETWEEN $min_no_of_bathrooms AND $max_no_of_bathrooms";
			$counter++;
		}

		if (($min_price != "") && ($max_price != "")){
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Price BETWEEN $min_price AND $max_price ";
			$counter++;
		}
	
		if ($city != ""){
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " City = '$city'";
			$counter++;
		}
		if ($state != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " State = '$state'";
			$counter++;
		}
				
		if ($zip_code != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Zip_code = $zip_code";
			$counter++;
		}		
	
		if ($distance != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Distance_to_school <= $distance";
			$counter++;
		}
		if ($max_capacity != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Max_capacity <= $max_capacity";
			$counter++;
		}
    
    
		if ($start_date != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Start_date <= '$start_date'";
			$counter++;
		}
		if ($parking != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Parking = '$parking'";
			$counter++;
		}
		if ($laundry != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Laundry = '$laundry'";
			$counter++;
		}
		if ($smoking != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Smoking ='$smoking'";
			$counter++;
		}
		if ($pets != "") {
			if($counter >= 1){
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " Pets ='$pets'";
			$counter++;
		}
	}
	//echo "Counter is $counter";
	//echo "<section> Query:  $query </section>";
			
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
		<p> <b>Your Searching Setting: </b><br>
		<?php 
				//echo $query;
				echo "City: $city<br>";
				echo "State: $state<br>
					  Zip Code: $zip_code<br>
	   				  Distance to School: $distance<br>
	   				  Start Date Since: $start_date<br>
					  Price:  min: $min_price  max:$max_price <br>
					  Bedrooms: min: $min_no_of_bedrooms  max: $max_no_of_bedrooms<br>
					  Bathrooms: min: $min_no_of_bathrooms max: $max_no_of_bathrooms<br>
					  Max Capacity: $max_capacity <br>
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
		<th>ID</th>
	   	<th>Location.Street</th>
		<th>Cityt</th>
		<th>State</th>
		<th>Zip Code</th>
	   	<th>Distance to School</th>
		<th>Price</th>
		<th>Bedrooms</th>
		<th>Bathrooms</th>
		<th>Max Capacity</th>
		<th>Parking</th>
		<th>Laundry</th>
		<th>Smoking</th>
		<th>Pets</th>
	  </thead>
	  </tbody>
	  <?php
		if (mysqli_num_rows($result) == 0){
			echo "<h4> No Data </h4>";
		}
		else {
			while( $row = mysqli_fetch_array ($result)) {
				$Housing_ID = $row['Housing_ID'];
				$Street_Address = $row["Street_Address"];
				$city = $row['City'];
				$state = $row['State'];
				$zip_code = $row['Zip_code'];
				$Distance = $row["Distance_to_school"];
				$Price = $row["Price"];
				$num_Bedr = $row["No_of_Bedrooms"];
				$num_Batr = $row["No_of_Bathrooms"];
				$max_capacity = $row["Max_capacity"];
				$parking = $row['Parking'];
				$laundry = $row['Laundry'];
				$smoking = $row['Smoking'];
				$pets = $row['Pets'];
				echo" <tr>
						<td> <a href=\"roomdetail.php?Housing_ID=$Housing_ID\">$Housing_ID</a></td>
						<td> $Street_Address</td>
						<td> $city</td>
						<td> $state</td>
						<td> $zip_code</td>
						<td> $Distance</td>
						<td> $Price</td>
						<td> $num_Bedr</td>
						<td> $num_Batr</td>
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
