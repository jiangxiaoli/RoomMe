<?php
	//database settings
	$host="localhost";
	$username="root";
	$password="root";
	$database="roomme";
	$table = "tenant";
	
	//connect to database
	$con = mysqli_connect($host,$username,$password, $database);
	if (mysqli_connect_errno($con)) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	} 
	
	$query = "SELECT * FROM $table";
	$i = 0;
	if(!empty($_GET)){
		$school =$_GET['school_search'];
		$major =$_GET['major_search'];
		$min_age = $_GET['age_search_min'];
		$max_age = $_GET['age_search_max'];
		$home_country = $_GET['home_country'];
		$smoking = $_GET['smoking'];
		$pets = $_GET['pets'];
		
		if($school != ""){
			$query .=" WHERE School='$school'";
			$i++;
		}
		if($major != ""){
			if($i >= 1){
				$query .= " AND";
			}
			else {
				$query .= " WHERE";
			}
			$query .= " Major = '$major'";
			$i++;
		}
		if (($min_age != "") && ($max_age != "")){
			if($i >= 1){
				$query .= " AND";
			}
			else {
				$query .= " WHERE";
			}
			$query .= " Age BETWEEN $min_age AND $max_age ";
			$i++;
		}
		if($home_country != ""){
			if($i >= 1){
				$query .= " AND";
			}
			else {
				$query .= " WHERE";
			}
			$query .= " Home_country = '$home_country'";
			$i++;
		}
		if ($smoking != "") {
			if($i >= 1){
				$query .= " AND";
			}
			else{
				$query .= " WHERE";
			}
			$query .= " Smoking ='$smoking'";
			$i++;
		}
		if ($pets != "") {
			if($i >= 1){
				$query .= " AND";
			}
			else {
				$query .= " WHERE";
			}
			$query .= " Pets ='$pets'";
			$i++;
		}
	}
		
	//execute query		
	//echo Query:  $query";		
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
		<p><b> Your Advanced Searching Setting:</b><br>
		<?php 
				//echo $query;
				echo "School: $school<br>
					  Major: $major<br>
					  Age:  min: $min_age  max:$max_age <br>
					  Home Country: $home_country <br>
					  Smoking: $smoking<br>
					  Pets: $pets<br>
				";
			?>
		</p>
	</section>
	<br>
	<p><h2 id="pagetype">Searching Result</h2></p>
	<table class="resultlist sortable" >
	  <thead>
		<th>Tenant_ID</th>
		<th>School</th>
		<th>Major</th>
		<th>Age</th>
		<th>Gender</th>
		<th>Home_Country</th>
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
				$Tenant_ID = $row['Tenant_ID'];
				$school = $row['School'];
				$major= $row['Major'];
				$age = $row['Age'];
				$gender= $row['Gender'];
				$home_country = $row['Home_country'];
				$smoking = $row['Smoking'];
				$pets = $row['Pets'];
				echo" <tr>
						<td> <a href=\"roomdetail.php?Tenant_ID=$Tenant_ID\">$Tenant_ID</a></td>
						<td> $school</td>
						<td> $major</td>
						<td> $age</td>
						<td> $gender</td>
						<td> $home_country</td>
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
