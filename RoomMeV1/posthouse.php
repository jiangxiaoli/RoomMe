<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	Post Housing Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Post Housing</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

<?php
	
	//database settings
	$host="localhost";
	$username="root";
	$password="root";
	$database="roomme";

	//connect to database
	$con =mysqli_connect($host,$username,$password,$database);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	}

	//set variables to field values
	//$user_id = $_POST['user_id'];
	$campus = mysql_real_escape_string($_POST['campus']);
	$street_address = mysql_real_escape_string($_POST['street_address']);
	$city = mysql_real_escape_string($_POST['city']);
	$state = mysql_real_escape_string($_POST['state']);
	$zip_code = $_POST['zip_code'];
	$distance_to_school = $_POST['distance_to_school'];
	$price = $_POST['price'];
	$min_term = $_POST['min_term'];
	$start_date = date($_POST['start_date']);
	$no_of_bedrooms = $_POST['no_of_bedrooms'];
	$no_of_bathrooms = $_POST['no_of_bathrooms'];
	$max_capacity = $_POST['max_capacity'];
	$parking = mysql_real_escape_string($_POST['parking']);
	$laundry = mysql_real_escape_string($_POST['laundry']);
	$smoking = mysql_real_escape_string($_POST['smoking']);
	$pets = mysql_real_escape_string($_POST['pets']);
	$description = mysql_real_escape_string($_POST['description']);
	$owned_by = $_POST['owned_by'];
	$user_id = $_GET['user_id'];
	//$user_id = $owned_by;

	if ($user_id == 1000) {
		echo "<nav><ul>";
		echo "<li><a href='adminhome.php?user_id=$user_id'>Admin Home</a></li></ul></nav>";

	}
	else {
		echo "
				<nav>
					<ul>
						<li><a href='homepage.html'>RoomMe Home/Search</a></li>
						<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
						<li><a href='posthousing.php?user_id=$user_id'>Post Housing</a></li>
					</ul>
				</nav>
	</br>	
	</br>";
	}
	
	echo "
	<h2>For LANDLORDS Only</h2>
	<h2 id='pagetype'>Post Housing</h2>";

	
	if (isset($_GET['housing_id'])) {
		$housing_id = $_GET['housing_id'];
		$sql="Update Housing Set campus='$campus', street_address='$street_address', city='$city',"
		. "state='$state', zip_code=" . $zip_code . ",distance_to_school=". $distance_to_school . ","
		. "price=" . $price . ", min_term=" . $min_term . ", start_date='$start_date', "
		. "no_of_bedrooms=" . $no_of_bedrooms . ", no_of_bathrooms=" . $no_of_bathrooms . ", "
		. "max_capacity=" . $max_capacity . ", parking='$parking', laundry='$laundry', smoking='$smoking'"
		. ", pets='$pets', description='$description', owned_by=" . $owned_by . " where housing_ID=$housing_id";

		if (!mysqli_query($con,$sql)) {
			die("Error: " . mysqli_error($con));
		}
		echo "<section><p>Housing #$housing_id succesfully updated. ";
		if ($user_id != 1000) {
			echo "Go back to your <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";	
		}
		else {
			echo "Return to <a href='adminhome.php?user_id=$user_id'>admin home</a></p></section>";
		}
		
	}
	else {
		//default first assignable housing_id
		$housing_id = 5001;
		//query DB to see if it already exists
		//if yes, increment housing_id until it is unique)
		do {
			if ($result = mysqli_query($con, "SELECT * from Housing where housing_id = " . $housing_id)) {
				$rows = $result->num_rows;
			}
			
			if ($rows > 0 ) {
				$housing_id += 1;
			}
		} while ($rows > 0);
		//integer or number variables do not need to be quoted
		//string type variables need to be in '' quotes
		$sql="INSERT INTO Housing (housing_id, campus, street_address, city, state, zip_code, "
			. "distance_to_school, price, min_term, start_date, no_of_bedrooms, no_of_bathrooms, "
			. "max_capacity, parking, laundry, smoking, pets, description, owned_by)"
			. " VALUES (" . $housing_id . ",'$campus','$street_address','$city','$state',"
			. $zip_code . "," . $distance_to_school . "," . $price . "," . $min_term . ","
			. "'$start_date'," . $no_of_bedrooms . "," . $no_of_bathrooms . "," . $max_capacity . ","
			. "'$parking','$laundry','$smoking','$pets','$description','$owned_by')";

		if (!mysqli_query($con,$sql)) {
			die("Error: " . mysqli_error($con));
		}
		echo "<section><p>Housing added successfully to the RoomMe database.<br/>";
		echo "The ID for your housing post is " . $housing_id . ". ";
		echo "Go back to your <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";
	}
	mysqli_close($con);

	
	
	
	?>

   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>
