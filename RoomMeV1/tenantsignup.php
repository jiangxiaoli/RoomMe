<html>

	<head>
   <!-- 
    Landlord Sign up php
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Tenant Sign Up Page</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

	<nav>
		<ul>
			<li><a href="homepage.html">RoomMe Home</a></li>
			<li><a href="userhome.php">User Home</a></li>

<?php

	//Get user input
	// $userreg=$_POST['user'];
	// $passreg=$_POST['pass'];

	//Create local variables
	$host="localhost";
	$dbusername = "root";
	$dbpassword = "root";
	$database = "roomme";

	//Connect to database
	$con = mysqli_connect($host,$dbusername,$dbpassword,$database);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	}

	if (!$con) {
	    die('Connect Error (' . mysqli_connect_errno() . ') '
	        . mysqli_connect_error());
	}
	
	if (isset($_GET['user_id'])) {
		//then it is update
		echo "<li><a href='homepage.html'>RoomMe Home</a></li>
			<li><a href='adminhome.php?user_id=1000'>AdminHome</a></li>
		</ul>
	</nav>

	</br>	
	</br><h2 id='pagetype'>Updating Tenant</h2>";
		$user_id=$_GET['user_id'];

		if (isset($_GET['tenant_id'])) {
			$tenant_id = $_GET['tenant_id'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$phone_number = mysql_real_escape_string($_POST['phone_number']);
			$school = mysql_real_escape_string($_POST['school']);
			$major = mysql_real_escape_string($_POST['major']);
			$age = $_POST['age'];
			$gender = $_POST['gender'];
			$smoking = $_POST['smoking'];
			$pets = $_POST['pets'];
			$home_country = mysql_real_escape_string($_POST['home_country']);	

			$sql = "Update Tenant set username='$username', password='$password', email='$email'"
				.", fname='$fname', lname='$lname', phone_number='$phone_number',school='$school'"
				.", major='$major', age=$age, gender='$gender',smoking='$smoking',pets='$pets',"
				."home_country='$home_country' where tenant_id=$tenant_id";
			if (!mysqli_query($con,$sql)) {
				//var_dump(mysqli_query($con,$sql));
				echo "<section><p>Error with database: please try again later. Return to <a href='adminhome.php?user_id=1000'>admin home</a>.</p></section>";
			}
			else {
				echo "<section><p>Tenant with ID #$tenant_id successfully updated. Return to <a href='adminhome.php?user_id=1000'>admin home</a>.</p></section>";
				
			}	
		}
		



	}
	else {
		echo "


		</ul>
	</nav>

	</br>	
	</br>

	<h2 id='pagetype'>TENANT Sign Up</h2>";

	//set variables to field values
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$phone_number = mysql_real_escape_string($_POST['phone_number']);
	$school = mysql_real_escape_string($_POST['school']);
	$major = mysql_real_escape_string($_POST['major']);
	$age = $_POST['age'];
	$gender = $_POST['gender'];
	$smoking = $_POST['smoking'];
	$pets = $_POST['pets'];
	$home_country = mysql_real_escape_string($_POST['home_country']);
	//$habits = mysql_real_escape_string($_POST['habits']);

	//default first assignable tenant_id
	$tenant_id = 2001;
		//query DB to see if it already exists
		//if yes, increment housing_id until it is unique)
		do {
			if ($result = mysqli_query($con, "SELECT * from tenant where tenant_id = " . $tenant_id)) {
				$rows = $result->num_rows;
			}
			
			if ($rows > 0 ) {
				$tenant_id += 1;
			}
		} while ($rows > 0);

	//integer or number variables do not need to be quoted
	//string type variables need to be in '' quotes
	$sql="INSERT INTO tenant (tenant_id, username, password, fname, lname, school, "
		. "email, phone_number, age, major, gender, home_country, smoking, pets)"
		. " VALUES (" . $tenant_id . ",'$username','$password','$fname','$lname',"
		. "'$school','$email','$phone_number'," . $age . ",'$major','$gender','$home_country',"
		. "'$smoking','pets')";

	if (!mysqli_query($con,$sql)) {
		die("Error: " . mysqli_error($con));
	}
	echo "<section><h2> Account created </h2></section>";
}

	

	mysqli_close($con);

	?>
	
	</body>

	<footer>
		&copy; Team 6, Cmpe 180-38, SJSU, 2014
	</footer>


</html>