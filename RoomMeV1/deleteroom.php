<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Delete Room</title>
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
				if ( ($user_id -1000 < 1000) && ($user_id - 1000 != 0)) {
					//is a landlord
					echo "
				<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>";
				}
				else {
					//is a tenant or admin
					echo "
				<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
				<li><a href='postaroom.php?user_id=$user_id'>Post a Room</a></li>";
				}
	
	echo "		
		</ul>
	</nav>

	</br>	
	</br>
	
	<h2 id='pagetype'>Delete Room</h2>";
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
				
				//if primary tenant
				if ($rows2 > 0 || $user_id == 1000) {
					if (isset($_GET['Room_ID'])) {
						$room_id = $_GET['Room_ID'];

						$eachrow = mysqli_fetch_array($result2);
						$renting_house = $eachrow['Rents_Housing'];

						$innerroom_id = $room_id - $renting_house*10;

						$sql = "SELECT * from Rooms where Rooms_ID=$room_id";
						$detail_result = mysqli_query($con,$sql);
						$num_houses = $detail_result->num_rows;

						if ($num_houses == 0) {
							echo "<section><p>Error: A room with ID #$room_id does not exist. Please go "
							."back to your <a href='userhome.php?user_id=$user_id'>home page</a>"
							." and try again.</p></section>";
						}
						else {
							$i = mysqli_fetch_array($detail_result);

							$rentable = $i['In_Housing'];
							
							/*if ($rentable != $renting_house) {
								//check if primary tenant is renting the house to which the room belongs
								echo "<section><p>Room ID #$room_id does not belong to the housing that you are "
									."renting. You do not have permission to update this housing. Please go back"
									." to your <a href='userhome.php?user_id=$user_id'>home page</a> to try again."
									. "</p></section>";
							}
							else {*/if ($rentable == $renting_house or $user_id ==1000){
								$sql = "DELETE from Rooms where Rooms_ID =$room_id";
								if ($result = mysqli_query($con,$sql)) {
									echo "<section><p>Room #$room_id succesfully deleted.";
									if ($user_id == 1000) {
										echo "Go back to <a href='adminhome.php?user_id=1000'>admin home</a></p></section>";
									}
									else {


										echo" Please go"
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