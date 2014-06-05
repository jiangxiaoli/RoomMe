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

	$username = $_POST['username'];
	$password = $_POST['password'];

	// To protect MySQL injection (more detail about MySQL injection)
	/*$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);*/

	$query = "SELECT Landlord_ID AS user_id FROM Landlord WHERE username='$username'and password='$password'
	union SELECT Tenant_ID AS user_id FROM Tenant WHERE username='$username'and password='$password'";

	//$sql = "SELECT tenant_id FROM tenant WHERE username='$username' and password='$password'";
	//$sql1 = "SELECT landlord_id FROM landlord WHERE username='$username' and password='$password'";
	//$sql2 = "SELECT admin_id FROM admin WHERE username='$username' and password='$password'"; 
	$result = mysqli_query($con, $query);

	if (mysqli_num_rows($result) == 0){
        echo "<h4> user not found </h4>";
    } else {
		$row = mysqli_fetch_array ($result);
		$user_id = $row['user_id'];

		//admin 
		if ($user_id == 1000){
			$_SESSION['username']="username"; 
			$_SESSION['password']="password";  
			header("location:adminhome.php?user_id=$user_id"); 
		} else {
			$_SESSION['username']="username"; 
			$_SESSION['password']="password";  
			//echo "userid: $user_id ";
			header("location:userhome.php?user_id=$user_id"); 

		} 	
    }

 

	/*$result1 = mysql_query($sql1);
	$result2 = mysql_query($sql2); 

	// Mysql_num_row is counting table row
	$count = mysql_num_rows($result);
	$count1 = mysql_num_rows($result1);
	$count1 = mysql_num_rows($result2);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count == 1){

	// Register $myusername, $mypassword and redirect to file "login_success.php"
	$user_id = mysql_result($result,0);
	$_SESSION['username']="username";
	$_SESSION['password']="password"; 
	header("location:userhome.php?user_id=$user_id");

	}
	else if ($count1 == 1){
	$user_id = mysql_result($result1,0);
	$_SESSION['username']="username";
	$_SESSION['password']="password"; 
	header("location:userhome.php?user_id=$user_id");
	}
	else if ($count2 == 1){ 
	$user_id = mysql_result($result2,0); 
	$_SESSION['username']="username"; 
	$_SESSION['password']="password";  
	header("location:adminhome.php?user_id=$user_id"); 
	} 
	else {
	echo "Wrong Username or Password";
	header("location:fail.html");
	}
	*/
	mysqli_close();


?>