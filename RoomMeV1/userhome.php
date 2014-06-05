<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - User Home Page</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe</h1>
	</header>

	<nav>
		<ul>

	<?php
			//pass user_id
			if (isset($_GET['user_id'])) {
				$user_id = $_GET['user_id'];

				if ($user_id == 1000) {
					//is admin
					header("location:adminhome.php?user_id=$user_id");
				}
				else if ($user_id -1000 > 1000) {
					//is a tenant
					echo "
				<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
				<li><a href='postaroom.php?user_id=$user_id'>Post a Room</a></li>";
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
	
	<h2 id='pagetype'>User Home Page</h2>
	<section id='usertype'>";
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
				
				//if landlord
				if ($rows1 > 0) {
					echo "<h2>User Type</h2>"
						. "<p>Your ID is #$user_id. You are a landlord.</p>"
						. "</section>";

					$sql_landlord = "SELECT housing_id, street_address, city, state, zip_code from Housing where owned_by = $user_id";
					$result_houses = mysqli_query($con, $sql_landlord);
					$row_num = $result_houses->num_rows;

					if ($row_num == 0) {
						//no housing owned
						echo "<section id='auserlist'>"
						. 	"<h2>Owned House List</h2>";
						echo "<p>No houses owned.<br/>To add a housing, plase use 'Post Housing' in the upper "
						.	"right of the navigation bar.</p>";
						echo "</section>";

					}
					else {
						echo "<section id='auserlist'>"
						. 	"<h2>Owned House List</h2>";
						echo "<p id='note'><b>Note 1:</b> Only housing without an assigned primary tenant can be"
						." deleted. If you wish to delete a housing, please delete the primary tenant first."
						.	"<br/><b>Note 2:</b> Only tenants not subleasing rooms in a housing can be deleted."
						." If you wish to delete a primary tenant, but do not see the option to do so, please"
						." contact the primary tenant or the admin to remove postings of rooms belonging to that"
						." housing.<br/><b>Note 3:</b> Deleting a tenant does NOT ask for confirmation and "
						."CANNOT be undone!<br/><b/>Note 4:</b> To add a housing, plase use 'Post Housing' in"
						." the upper right of the navigation bar.</p>";
						echo "<ul>";
						//loop through each row returned from sql query
						while ($i = mysqli_fetch_array($result_houses)) {
							$housing_id = $i['housing_id'];
							$street_address = $i['street_address'];
							$city = $i['city'];
							$state = $i['state'];
							$zip_code = $i['zip_code'];
							echo "<li><a href='updatehousing.php?user_id=$user_id&Housing_ID=$housing_id'><input type='button' id='update' value='Update Housing'></a>";
							
							//find the primary tenant for this housing
							$sql_primary = "select Tenant.Tenant_ID,fname,lname,Primary_Tenant.Tenant_ID from Tenant join "
									."Primary_Tenant on Tenant.Tenant_ID=Primary_Tenant.Tenant_ID where "
									."Primary_Tenant.Rents_Housing = $housing_id";
							$result_primary = mysqli_query($con, $sql_primary);
							$m = mysqli_fetch_array($result_primary);
							$primary_tenant_id = $m['Tenant_ID'];
							$p_fname = $m['fname'];
							$p_lname = $m['lname'];

							if ($primary_tenant_id == "") {
								echo "<a href='manage.php?user_id=$user_id&Housing_ID=$housing_id'><input type='button' id='delete' value='Delete Housing'></a></br>"
								. "ID: $housing_id</br>"
								. "$street_address, $city, $state $zip_code<br/>";
								echo "<b>Primary Tenant:</b> none&nbsp;"
									."<form id='add_tenant' action='managetenants.php' method='get'>"
									."<input type='hidden' name='user_id' value='$user_id'>"
									."<input type='hidden' name='housing_id' value='$housing_id'>"
									."<input type='hidden' name='choose_option' value='add'>"
									."<label for='tenant_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
									."Tenant ID: </label>"
									."<input type='number' name='tenant_id' min='2001' max='2999' step='1' placeholder='2###' required='required'>"
									."<input type='submit' class='add' value='Add Tenant'></form></li><br/>";		
							}
							else {	
								echo "<br/>ID: $housing_id</br>"
								. "$street_address, $city, $state $zip_code<br/>";
								echo "<b>Primary Tenant:</b> $p_fname $p_lname (#$primary_tenant_id)&nbsp;";

								//check if primary tennat can be deleted
								//primary tenant cannot have subleased rooms
								$p_sql = "SELECT Rooms_ID from Rooms Join Primary_Tenant on In_Housing=Rents_Housing where Tenant_ID=$primary_tenant_id";
								$result_p = mysqli_query($con, $p_sql);
								$num_of_rooms = $result_p->num_rows;

								if ($num_of_rooms == 0) {
									//can delete tenant
									echo "<a href='managetenants.php?user_id=$user_id&tenant_id=$primary_tenant_id&housing_id=$housing_id&choose_option=delete'><input type='button' id='delete' value='Delete Tenant'></a>";
								}
								//otherwise, there are rooms subleased by this primary tenant and cannot delete

								echo "<form id='update_tenant' action='managetenants.php' method='get'>"
									."<input type='hidden' name='user_id' value='$user_id'>"
									."<input type='hidden' name='housing_id' value='$housing_id'>"
									."<input type='hidden' name='choose_option' value='update'>"
									."<label for='tenant_id'>&nbsp;&nbsp;&nbsp;"
									."New Tenant ID: </label>"
									."<input type='number' name='tenant_id' min='2001' max='2999' step='1' placeholder='2###' required='required'>"
									."<input type='submit' value='Update Tenant'></form>";
									//."<input type='button' id='update' value='Update/Change'></a>";

								echo "</li><br/>";	
							}
						}//end while
						echo "</ul></section>";

					}//end else
				}

				//if primary tenant
				else if ($rows2 > 0) {
					$eachrow = mysqli_fetch_array($result2);
					$renting_house = $eachrow['Rents_Housing'];
					
					echo "<h2>User Type</h2>"
						. "<p>Your ID is #$user_id. You are a primary tenant renting housing #$renting_house.<br/>";

					$sql_address = "SELECT street_address, city, state, zip_code from Housing where housing_id = $renting_house";
					$result_address = mysqli_query($con, $sql_address);
					$j = mysqli_fetch_array($result_address);
					$add_1 = $j['street_address'];
					$add_2 = $j['city'];
					$add_3 = $j['state'];
					$add_4 = $j['zip_code'];

					echo "Housing Address: $add_1, $add_2, $add_3 $add_4</p>"
						. "</section>";

					$sql_rentable = "SELECT rooms_id from Rooms where in_housing = $renting_house";
					$rentable_result = mysqli_query($con, $sql_rentable);
					$row_num = $rentable_result->num_rows;

					if ($row_num == 0) {
						echo "<section id='auserlist'>"
						. 	"<h2>Subleased Rooms List</h2>";
						echo "<p>You are not subleasing any rooms.<br/>"
							."To add a room, please use 'Post a Room' in the upper right of the navigation bar.</p></section>";

					}
					else {			
						echo "<section id='auserlist'>"
						. 	"<h2>Subleased Rooms List</h2>";
						echo "<p id='note'><b>Note1 :</b> Only rooms without assigned tenants can be deleted. If you wish to delete a room, please delete all secondary tenants first.<br/><b>Note 2:"
							."</b> To add a room, please use 'Post a Room' in the upper right of the navigation"
							." bar.<br/><b>Note 3:</b> Deletion of room occupants does NOT ask for confirmation"
							." and CANNOT be undone!</p>";
						echo "<ul>";
						//loop through each row returned from sql query
						while ($i = mysqli_fetch_array($rentable_result)) {
							$rooms_id = $i['rooms_id'];
							echo "<li><a href='updateroom.php?user_id=$user_id&Room_ID=$rooms_id'><input type='button' id='update' value='Update Room'></a>";

							//excludes the current user as an item in roommmate list
							$sql_roommates = "select fname,lname,tenant.tenant_id from tenant join secondary_tenant on tenant.tenant_id"
								. " = secondary_tenant.tenant_id where renting_room = $rooms_id and tenant.tenant_id<>$user_id";
							$result_roommates = mysqli_query($con, $sql_roommates);
							$no_roommies = $result_roommates->num_rows;

							

							//roommates found
							if ($no_roommies > 0) {
								$a = 1;
								echo "<br/>ID: " . $rooms_id . "<br/>";
								while ($roommates = mysqli_fetch_array($result_roommates)) {
									$roomie_f = $roommates['fname'];
									$roomie_l = $roommates['lname'];
									$roomie_id = $roommates['tenant_id'];
									echo "<b>Occupant #$a:</b> $roomie_f $roomie_l (#$roomie_id)&nbsp;";
									echo "<a href='managetenants.php?user_id=$user_id&tenant_id=$roomie_id&room_id=$rooms_id&choose_option=delete'><input type='button' id='delete' value="
										."'Delete Tenant'></a><br/>";
									/*echo "<form id='update_tenant' action='managetenants.php' method='get'>"
									."<input type='hidden' name='user_id' value='$user_id'>"
									."<input type='hidden' name='room_id' value='$rooms_id'>"
									."<input type='hidden' name='choose_option' value='update'>"
									."<label for='tenant_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
									."&nbsp;&nbsp;&nbsp;&nbsp;Update Tenant ID: </label>"
									."<input type='number' name='tenant_id' min='2001' max='2999' step='1' placeholder='2###' required='required'>"
									."<input type='submit' id='update' value='Update Tenant'></form>";*/
									$a++;
								}
							}
							else {
								echo "<a href='manage.php?user_id=$user_id&Room_ID=$rooms_id'><input type='button' id='delete' value='Delete Room'></a>";
								echo "<br/>ID: " . $rooms_id . "<br/>";
								echo "Status: unoccupied &nbsp;";
							}


							echo "<form id='add_tenant' action='managetenants.php' method='get'>"
								."<input type='hidden' name='user_id' value='$user_id'>"
								."<input type='hidden' name='room_id' value='$rooms_id'>"
								."<input type='hidden' name='choose_option' value='add'>"
								."<label for='tenant_id'>"
								."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Additional Tenant ID:"
								." </label>"
								."<input type='number' name='tenant_id' min='2001' max='2999' step='1' placeholder='2###' required='required'>"
								."<input type='submit' id='add' value='Add Tenant'></form></li><br/>";
							echo "</li></br>";
							
						}//end while
						echo "</ul>";
						echo "</section>";
					}//end else
					
				}

				//if secondary tenant
				else if ($rows3 > 0) {
					$eachrow = mysqli_fetch_array($result3);
					$renting_room = $eachrow['Renting_Room'];

					//get housing_id for the room
					$sql_housing = "SELECT Housing_ID from Housing join Rooms on in_housing=Housing_ID where rooms_id = $renting_room";
					$result_housing = mysqli_query($con, $sql_housing);
					$k = mysqli_fetch_array($result_housing);
					$rooms_in_house = intval($k['Housing_ID']);

					//get housing address
					$sql_address = "SELECT street_address, city, state, zip_code from Housing where housing_id = $rooms_in_house";
					$result_address = mysqli_query($con, $sql_address);
					$j = mysqli_fetch_array($result_address);
					$add_1 = $j['street_address'];
					$add_2 = $j['city'];
					$add_3 = $j['state'];
					$add_4 = $j['zip_code'];

					//based on current number schema
					$room_no = $renting_room-($rooms_in_house*10); 

					echo "<h2>User Type</h2>"
						. "<p>Your ID is #$user_id. You are a secondary tenant renting room #$renting_room.<br/><br/>"
						. "Room #$room_no in Housing #$rooms_in_house<br/>"
						. "Housing Address: $add_1, $add_2, $add_3 $add_4<br/><br/>"
						. "<b>Please contact your primary tenant to update the system if you no longer reside at the above address.</b></p>";
					echo "</section>";

					echo "<section id='auserlist'>"
						. 	"<h2>Roommate List</h2>";

					//find the primary tenant for this housing
					$sql_primary = "SELECT tenant_id from Primary_Tenant where Rents_Housing=$rooms_in_house";
					$result_primary = mysqli_query($con, $sql_primary);
					$m = mysqli_fetch_array($result_primary);
					$primary_tenant_id = $m['tenant_id'];
					//get primary tenant name
					$sql_prim_name = "SELECT fname, lname from Tenant where tenant_id=$primary_tenant_id";
					$result_prim_name = mysqli_query($con, $sql_prim_name);
					$n = mysqli_fetch_array($result_prim_name);
					$p_fname = $n['fname'];
					$p_lname = $n['lname'];

					//select all rooms in the same housing
					$sql_rooms = "SELECT Rooms_ID from Rooms where in_housing = $rooms_in_house";
					$result_rooms = mysqli_query($con, $sql_rooms);
					$row_num = $result_rooms->num_rows;

					if ($row_num == 0) {
						//the primary tenant must also reside in the same housing
						echo "<ul><li><b>Primary:</b> $p_fname $p_lname (#$primary_tenant_id)</li></ul>";
					}
					else {
						//if there are more than one room, then use rooms to find tenant_id
						//then use tenant_id to display roommates names
						//also include primary tenant
						echo "<ul><li><b>Primary:</b> $p_fname $p_lname (#$primary_tenant_id)</li>";

						while ($l = mysqli_fetch_array($result_rooms)) {
							$room_id = $l['Rooms_ID'];
							//excludes the current user as an item in roommmate list
							$sql_roommates = "select fname,lname,tenant.tenant_id from tenant join secondary_tenant on tenant.tenant_id"
								. " = secondary_tenant.tenant_id where renting_room = $room_id and tenant.tenant_id<>$user_id";
							$result_roommates = mysqli_query($con, $sql_roommates);
							$no_roommies = $result_roommates->num_rows;

							//roommates found
							if ($no_roommies > 0) {
								while ($roommates = mysqli_fetch_array($result_roommates)) {
									$roomie_f = $roommates['fname'];
									$roomie_l = $roommates['lname'];
									$roomie_id = $roommates['tenant_id'];
									echo "<li>$roomie_f $roomie_l (#$roomie_id)</li>";
								}	
							}
						}
						echo "</ul></section>";
					}
					
				}
				//registered tenant but not leasing a house or room yet
				else if ($rows4 > 0) {
					echo "<h2>User Type</h2>"
						. "<p>Your ID is #$user_id. You are a tenant.<br/> You have not yet been added as a primary tenant or"
						. " secondary tenant. Please contact a landlord or primary tenant to be added.</p></section>";
					
				}
				mysqli_close($con);
			}
			//login not successful
			else {
				echo " 
				<li><a href='homepage.html'>RoomMe Home</a></li></ul></nav><br/><br/>";
				echo "<section><p>You are not logged in. Please login <a href='signin.html'>here</a>.</p></section>";
			}

			
		?>
	
   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>