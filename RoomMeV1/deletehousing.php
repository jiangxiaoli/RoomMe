<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Delete Housing</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

	<nav>
		<ul>

	<?php
			//pass user_id
			if (isset($_GET['user_id'])) {
				$user_id = $_GET['user_id'];

				//if ($user_id == 1000) {
					//is admin
				//	header("location:adminhome.php?user_id=$user_id");
				//}
				if ($user_id -1000 > 1000) {
					//is a tenant
					echo "
				<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>";
				}
				else {
					//is a landlord
					echo "
				<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
				<li><a href='posthousing.php?user_id=$user_id'>Post Housing</a></li>";
				}
	
	echo "		
		</ul>
	</nav>

	</br>	
	</br>
	
	<h2 id='pagetype'>Delete Housing</h2>";
	//html above
		
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

				//check if landlord
				$sql1="SELECT * from landlord WHERE landlord_id = $user_id";
				$result1 = mysqli_query($con,$sql1);
				$rows1 = $result1->num_rows;

				//check if primary tenant
				$sql2="SELECT * from primary_tenant WHERE tenant_id = $user_id";
				$result2 = mysqli_query($con,$sql2);
				$rows2 = $result2->num_rows;

				//check if secondary tenant
				$sql3="SELECT * from secondary_tenant WHERE tenant_id = $user_id";
				$result3 = mysqli_query($con,$sql3);
				$rows3 = $result3->num_rows;

				//check if tenant but not in primary_tenant or secondary_tenant tables (registered only)
				$sql4="SELECT * from Tenant WHERE tenant_id = $user_id";
				$result4 = mysqli_query($con,$sql4);
				$rows4 = $result4->num_rows;
				
				//if landlord (or admin)
				if ($rows1 > 0) {
					if (isset($_GET['Housing_ID'])) {
						$housing_id = $_GET['Housing_ID'];

						$sql = "SELECT * from Housing where Housing_ID=$housing_id";
						$detail_result = mysqli_query($con,$sql);
						$num_houses = $detail_result->num_rows;

						if ($num_houses == 0) {
							echo "<section><p>Error: A housing with ID #$housing_id does not exist. Please go "
							."back to your <a href='userhome.php?user_id=$user_id'>home page</a>"
							." and try again.</p></section>";
						}
						else {
							$i = mysqli_fetch_array($detail_result);

							$owned_by = $i['Owned_by'];
							if ($owned_by != $user_id && $user_id != 1000) {
								//check if landlord owns this housing
								echo "<section><p>Housing ID #$housing_id does not belong to you. You do not"
									." have permission to delete this housing. Please go back to your "
									. "<a href='userhome.php?user_id=$user_id'>home page</a> to try again."
									. "</p></section>";
							}
							else {
								$sql = "DELETE from Housing where Housing_ID =$housing_id";
								if ($result = mysqli_query($con,$sql)) {
									echo "<section><p>Housing #$housing_id succesfully deleted.";
									if ($user_id == 1000) {
										echo "Back to <a href='adminhome.php?user_id=$user_id'>admin home</a>.</p></section>";
									}
									else {


										echo " Please go"
										. " back to your <a href='userhome.php?user_id=$user_id'>home page</a>"
										. " to see this change.</p></section>";
									}
								}
								else {//deletion failed
									echo "<section><p>Error: There was a problem with the database. Please go "
									."back to your <a href='userhome.php?user_id=$user_id'>home page</a>"
									." and try again.</p></section>";
								}
							}
						}
					}//if housing not set
					else {
						echo "<section><p>There is an error with this page. Please go back to your "
						."<a href='userhome.php?user_id=$user_id'>home page</a> and try again.</p></section>";
					}
				}//end if

				//any other person
				else {
					echo "<p>You do not have permission for this page. Go back to your"
					." <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";						
				}
				mysqli_close($con);	
			}//end if
			else {
				//not logged in
				echo "<p>You do not have permission for this page. Go back to your"
					." <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";					
			}
			
		?>
	
   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>