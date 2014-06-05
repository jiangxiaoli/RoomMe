<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	PHP for Post Housing Page
   	Cmpe 180-38
   	Team 6
    -->
	<meta charset="UTF-8" />
	<title>Post Room</title>
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
	$user_id = $_POST['user_id'];
	$innerrooms_id = $_POST['rooms_id'];
	$price = $_POST['price'];
	$min_term = $_POST['min_term'];
	$start_date = date($_POST['start_date']);
	$room_type = mysql_real_escape_string($_POST['room_type']);
	$bathroom_type = $_POST['bathroom_type'];
	$capacity = $_POST['capacity'];
	$parking = mysql_real_escape_string($_POST['parking']);
	$laundry = mysql_real_escape_string($_POST['laundry']);
	$smoking = mysql_real_escape_string($_POST['smoking']);
	$pets = mysql_real_escape_string($_POST['pets']);
	$description = mysql_real_escape_string($_POST['description']);
	$habits = mysql_real_escape_string($_POST['habits']);
	$in_housing = $_POST['in_housing'];

	if ($user_id == 1000) {
		echo "<nav><ul><li><a href='adminhome.php?user_id=1000'>AdminHome</a></li></ul></nav>";
	}
	else {
		echo "<nav>
		<ul>
			<li><a href='homepage.html'>RoomMe Home/Search</a></li>
			<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
			<li><a href='postroom.php?user_id=$user_id'>Post a Room</a></li>
		</ul>
	</nav>

	</br>	
	</br>";
	}

	echo "

	<h2>For PRIMARY TENANTS Only</h2>
	<h2 id='pagetype'>Post a Room</h2>";

	if (isset($_GET['room_id'])) {
		$room_id = $_GET['room_id'];
		$sql = "Update Rooms SET price=". $price . ",min_term='$min_term', start_date='$start_date' "
			.",room_type='$room_type', bathroom_type='$bathroom_type', capacity=" . $capacity
			. ", parking='$parking',smoking='$smoking',pets='$pets',description='$description',"
			. "habits='$habits' where rooms_id=$room_id";

		if (!mysqli_query($con,$sql)) {
			die("Error: " . mysqli_error($con));
		}
		echo "<section><p>Room #$room_id successfully updated. Go back to your "
		."<a href='userhome.php?user_id=$user_id'>home page</a>.<br/></section>";
	}
	else {
		//integer or number variables do not need to be quoted
		//string type variables need to be in '' quotes
		$sql="INSERT INTO Rooms (rooms_id, price, min_term, start_date, room_type, bathroom_type,". 
			"capacity, parking, laundry, smoking, pets, description, habits, in_housing)".
			" VALUES (" . $in_housing.$innerrooms_id . "," . $price . "," . $min_term . ",'$start_date',"
						. "'$room_type','$bathroom_type'," . $capacity . ",'$parking',"
						. "'$laundry','$smoking','$pets','$description','$habits','$in_housing')";

		if (!mysqli_query($con,$sql)) {
			die("Error: " . mysqli_error($con));
		}
		echo "<section><p>Room added successfully to the RoomMe database.<br/>";
		echo "The ID for your room is #$in_housing".$innerrooms_id . "."
		. " Go back to your <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";
	}	
	mysqli_close($con);
	?>

   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>