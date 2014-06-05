
<html>
	<head>
   <!-- 
    Landlord Sign up php
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Landlord Sign Up Page</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

	<nav>
		<ul>
			


	<!--<center>
		<h2>LANDLORD Sign Up</h2>-->

	
	<?php
	$host="localhost";
	$dbusername = "root";
	$dbpassword = "root";
	$database = "roomme";

	//Connect to database
	$con = mysqli_connect($host,$dbusername,$dbpassword,$database);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
	}

	if (isset($_GET['user_id'])) {
		//then it is update
		echo "<li><a href='homepage.html'>RoomMe Home</a></li>
			<li><a href='adminhome.php?user_id=1000'>AdminHome</a></li>
		</ul>
	</nav>

	</br>	
	</br>

	<h2 id='pagetype'>Updating Landlord</h2>";
		$user_id=$_GET['user_id'];

		if(isset($_GET['landlord_id'])) {
			//update
			$landlord_id = $_GET['landlord_id'];
			$username = mysql_real_escape_string($_POST['username']);
			$password = mysql_real_escape_string($_POST['password']);
			$fname = mysql_real_escape_string($_POST['fname']);
			$lname = mysql_real_escape_string($_POST['lname']);
			$email = $_POST['email'];
			$phone_number = mysql_real_escape_string($_POST['phone_number']);

			$sql = "UPDATE Landlord set username='$username', password='$password', fname='$fname', lname='$lname'"
				.", email='$email', phone_number='$phone_number' where landlord_id=$landlord_id";
			if (!mysqli_query($con,$sql)) {
				//var_dump(mysqli_query($con,$sql));
				echo "<section><p>Error with database: please try again later. Return to <a href='adminhome.php?user_id=1000'>admin home</a>.</p></section>";
			}
			else {
				echo "<section><p>Landlord with ID #$landlord_id successfully updated. Return to <a href='adminhome.php?user_id=1000'>admin home</a>.</p></section>";
				
			}
		}
		
	}
	else {//else it is new signup
		echo "<li><a href='homepage.html'>RoomMe Home</a></li>
			<li><a href='userhome.php'>User Home</a></li>
		</ul>
	</nav>

	</br>	
	</br>

	<h2 id='pagetype'>Landlord Sign Up</h2>";

		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		$fname = mysql_real_escape_string($_POST['fname']);
		$lname = mysql_real_escape_string($_POST['lname']);
		$email = $_POST['email'];
		$phone_number = mysql_real_escape_string($_POST['phone_number']);

		//default first assignable tenant_id
			$landlord_id = 1001;
			//query DB to see if it already exists
			//if yes, increment housing_id until it is unique)
			do {
				if ($result = mysqli_query($con, "SELECT * from landlord where landlord_id = " . $landlord_id)) {
					$rows = $result->num_rows;
				}
				
				if ($rows > 0 ) {
					$landlord_id += 1;
				}
			} while ($rows > 0);

		//integer or number variables do not need to be quoted
		//string type variables need to be in '' quotes
		$sql="INSERT INTO landlord (landlord_id, username, password, fname, lname, email, phone_number)"
			. " VALUES (" . $landlord_id . ",'$username','$password','$fname','$lname',"
			. "'$email','$phone_number')";

		
		if (!mysqli_query($con,$sql)) {
			die("Error: " . mysqli_error($con));
		}

		echo "<section><h2>Account created</h2></section>";

	}//end else

	mysqli_close($con);

	?>


	</body>

	<footer>
		&copy; Team 6, Cmpe 180-38, SJSU, 2014
	</footer>


</html>