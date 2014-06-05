<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	PHP for manage tenant Page
   	Cmpe 180-38
   	Team 6
    -->
	<meta charset="UTF-8" />
	<title>RoomMe - Managing Tenants</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe</h1>
	</header>
	<nav>
		<ul>


	<?php
		if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];

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



		if ($user_id -1000 > 1000) {
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

		if ($user_id == 1000) {//deleting landlord or tenant
			echo "</ul></nav><section><h2>Deleting User</h2>";
			if (isset($_GET['Landlord_ID'])) {
				$landlord_id = $_GET['Landlord_ID'];
				$sql = "DELETE from Landlord where Landlord_ID=$landlord_id";
				if(mysqli_query($con, $sql)) {
					echo "<p>Landlord with ID #$landlord_id successfully deleted. Go back to <a href='adminhome.php?user_id=1000'>admin home</a>.</p>";
				}
				else {
					echo "<p>Error with database: Please <a href='adminhome.php?user_id=1000'>go back</a> and try again.</p>";
				}
			}
			else if (isset($_GET['Tenant_ID'])) {
				$tenant_id = $_GET['Tenant_ID'];
				$sql = "DELETE from Tenant where Tenant_ID=$tenant_id";
				if (mysqli_query($con, $sql)) {
					echo "<p>Tenant with ID #$tenant_id successfully deleted. Go back to <a href='adminhome.php?user_id=1000'>admin home</a>.</p>";
				}
				else {
					echo "<p>Error with database: Please <a href='adminhome.php?user_id=1000'>go back</a> and try again.</p>";
				}

			}


			echo "</section>";
		}
		else {	
		echo"
		</ul>
	</nav>

	</br>	
	</br>

	<h2 id='pagetype'>User Home Page</h2>
	<section>";
	//html above
	

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

					//get variables from form
					$housing_id = $_GET['housing_id'];
					$tenant_id = $_GET['tenant_id'];
					$choose_option = $_GET['choose_option'];

					//check if tenant is in tenant table
					$sql_tenant = "SELECT tenant_id from Tenant where tenant_id=$tenant_id";
					$result_tenant = mysqli_query($con, $sql_tenant);
					$exists = $result_tenant->num_rows;

					if ($choose_option == 'add') {
						if ($exists == 0) {
						echo "<section><h2>Adding Tenant</h2>"
						.	"<p>Error: Cannot add tenant #$tenant_id to Housing #$housing_id.<br/>"
						.	"There is no tenant with ID #$tenant_id. Please check your input "
						."and try again, or contact an admin for assistance.<br/><br/>"
						."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
						}
						else {
							//this tenant exists as user of roomme
							$sql_p_tenant = "SELECT tenant_id from Primary_Tenant where tenant_id=$tenant_id";
							$result_p_tenant = mysqli_query($con, $sql_p_tenant);
							$row_num = $result_p_tenant->num_rows;

							$sql_s_tenant = "SELECT tenant_id from Secondary_Tenant where tenant_id=$tenant_id";
							$result_s_tenant = mysqli_query($con, $sql_s_tenant);
							$row_num2 = $result_s_tenant->num_rows;

							if (($row_num == 0) && ($row_num2 == 0)) {
								//tenant is not p_tenant or s_tenant = can be added
								$sql_add_t = "INSERT INTO Primary_Tenant (Tenant_ID,Rents_Housing) VALUES ($tenant_id,$housing_id)";
								if (!mysqli_query($con, $sql_add_t)) {
									echo "<section><h2>Adding Tenant</h2><p>Error with database: Please contact an admin for assistance or <a href='userhome.php?user_id=$user_id'>go back</a> and try again.</p>
										</section>";
								}
								else {
									echo "<section><h2>Adding Tenant</h2><p>Primary Tenant #$tenant_id added successfully to Housing #$housing_id."
											." <a href='userhome.php?user_id=$user_id'>Manage another</a></p></section>";	
								}
							}
							else if ($row_num == 0) {
								//not p_tenant but is s_tenant
								echo "<section><h2>Adding Tenant</h2>"
								."<p>Error: Cannot add tenant #$tenant_id to Housing #$housing_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."a secondary tenant renting the room of another housing. Please check your input "
								."and try again, or contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
							else if ($row_num2 == 0) {
								//not s_tenant but exists as p_tenant already
								echo "<section><h2>Adding Tenant</h2>"
								."<p>Error: Cannot add tenant #$tenant_id to Housing #$housing_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."a primary tenant of another housing. Please check your input and try again, or "
								."contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
						}//end tenant exists
					}//end add option
					else if ($choose_option == 'update') {
						if ($exists == 0) {
						echo "<section><h2>Updating Tenant</h2>"
						.	"<p>Error: Cannot update primary tenant of Housing #$housing_id to tenant "
						.	"#$tenant_id.<br/>"
						.	"There is no tenant with ID #$tenant_id. Please check your input "
						."and try again, or contact an admin for assistance.<br/><br/>"
						."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
						}
						else {
							//this tenant exists as user of roomme
							$sql_p_tenant = "SELECT tenant_id from Primary_Tenant where tenant_id=$tenant_id";
							$result_p_tenant = mysqli_query($con, $sql_p_tenant);
							$row_num = $result_p_tenant->num_rows;

							$sql_s_tenant = "SELECT tenant_id from Secondary_Tenant where tenant_id=$tenant_id";
							$result_s_tenant = mysqli_query($con, $sql_s_tenant);
							$row_num2 = $result_s_tenant->num_rows;

							if (($row_num == 0) && ($row_num2 == 0)) {
								//tenant is not p_tenant or s_tenant = can be updated to this housing
								$sql_add_t = "UPDATE Primary_Tenant SET Tenant_ID=$tenant_id where "
									."Rents_Housing=$housing_id";
								if (!mysqli_query($con, $sql_add_t)) {
									echo "<section><h2>Updating Tenant</h2><p>Error with database: Please contact an admin for assistance or <a href='userhome.php?user_id=$user_id'>go back</a> and try again.</p></section>";
								}
								else {
									echo "<section><h2>Updating Tenant</h2><p>Primary Tenant of Housing #$housing_id successfully updated to #$tenant_id."
											." <a href='userhome.php?user_id=$user_id'>Manage another</a></p></section>";	
								}
							}
							else if ($row_num == 0) {
								//not p_tenant but is s_tenant
								echo "<section><h2>Updating Tenant</h2>"
								."<p>Error: Cannot update primary tenant of Housing #$housing_id to #$tenant_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."a secondary tenant renting the room of another housing. Please check your input "
								."and try again, or contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
							else if ($row_num2 == 0) {
								//not s_tenant but exists as p_tenant already
								echo "<section><h2>Updating Tenant</h2>"
								."<p>Error: Cannot update primary tenant of Housing #$housing_id to #$tenant_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."a primary tenant of another housing. Please check your input and try again, or "
								."contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
						}
					}//end update option
					else if ($choose_option == 'delete') {
						if ($exists == 0) {
							echo "<section><h2>Deleting Tenant</h2>"
							.	"<p>Error: Cannot delete primary tenant #$tenant_id from Housing #$housing_id."
							.	"<br/>There is no tenant with ID #$tenant_id. Please check your input "
							."and try again, or contact an admin for assistance.<br/><br/>"
							."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
						}
						else {
							//this tenant exists as user of roomme
							//check to see if there are rooms subleased or posted by primary tenant
							$sql_delete = "SELECT * from Rooms where In_Housing=$housing_id";
							$result_delete = mysqli_query($con, $sql_delete);
							$deleteable = $result_delete->num_rows;

							if ($deleteable == 0) {
								//no rooms being subleased - can delete
								$sql_to_delete = "DELETE from Primary_Tenant where Rents_Housing=$housing_id";
								if (!mysqli_query($con, $sql_to_delete)) {
									echo "<section><h2>Deleting Tenant</h2>Error with database: Please contact an admin for assistance or <a href=user_id=$user_id'>go back</a> and try again.</p></section>";
								}
								else {
									echo "<section><h2>Deleting Tenant</h2><p>Primary Tenant of Housing #$housing_id successfully deleted. There is now no primary tenant assigned to this housing."
											." <a href='userhome.php?user_id=$user_id'>Manage another</a></p></section>";	
								}
							}
							else {
								//there are rooms being subleased
								echo "<section><h2>Deleting Tenant</h2><p>Error: You cannot remove a primary tenant from a housing when there are rooms belonging to it that are being subleased. Please contact an admin or your primary tenant to have them removed.</p></section>";
							}	
						}
					}//end delete option
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

					$tenant_id = $_GET['tenant_id'];
					$room_id = $_GET['room_id'];
					$choose_option = $_GET['choose_option'];

					//check if tenant is in tenant table
					$sql_tenant = "SELECT tenant_id from Tenant where tenant_id=$tenant_id";
					$result_tenant = mysqli_query($con, $sql_tenant);
					$exists = $result_tenant->num_rows;

					if ($choose_option == 'add') {
						//add tenant
						if ($exists == 0) {
							echo "<section><h2>Adding Tenant</h2>"
							.	"<p>Error: Cannot add tenant #$tenant_id to Room #$room_id.<br/>"
							.	"There is no tenant with ID #$tenant_id. Please check your input "
							."and try again, or contact an admin for assistance.<br/><br/>"
							."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";	
						}
						else {
							$sql_p_tenant = "SELECT tenant_id from Primary_Tenant where tenant_id=$tenant_id";
							$result_p_tenant = mysqli_query($con, $sql_p_tenant);
							$row_num = $result_p_tenant->num_rows;

							$sql_s_tenant = "SELECT tenant_id from Secondary_Tenant where tenant_id=$tenant_id";
							$result_s_tenant = mysqli_query($con, $sql_s_tenant);
							$row_num2 = $result_s_tenant->num_rows;

							if (($row_num == 0) && ($row_num2 == 0)) {
								$sql_add = "INSERT INTO Secondary_Tenant (Tenant_ID, Renting_Room) VALUES"
								.	"($tenant_id, $room_id)";
								if (!mysqli_query($con, $sql_add)) {
									echo "<section><h2>Adding Tenant</h2>Error with database: Please contact an admin"
									." for assistance or <a href='userhome.php?user_id=$user_id'>go back</a> "
									."and try again.</p></section>";
								}
								else {
									echo "<section><h2>Adding Tenant</h2><p>Tenant #$tenant_id added successfully to"
									." Room #$room_id. <a href='userhome.php?user_id=$user_id'>Manage another</a>"
									."</p></section>";	
								}
							}
							else if ($row_num == 0) {
								echo "<section><h2>Adding Tenant</h2>"
								."<p>Error: Cannot add tenant #$tenant_id to Room #$room_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."renting another room. Please check your input "
								."and try again, or contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
							else if ($row_num2 == 0) {
								echo "<section><h2>Adding Tenant</h2>"
								."<p>Error: Cannot add tenant #$tenant_id to Room #$room_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."the primary tenant of another housing. Please check your input and try again, or "
								."contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
						}
					}//end add
					/*else if ($choose_option == 'update') {
						//update tenant
						if ($exists == 0) {
							echo "<section><h2>Updating Tenant</h2>"
							.	"<p>Error: Cannot update tenant of Room #$room_id to #$tenant_id.<br/>"
							.	"There is no tenant with ID #$tenant_id. Please check your input "
							."and try again, or contact an admin for assistance.<br/><br/>"
							."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";	
						}
						else {
							$sql_p_tenant = "SELECT tenant_id from Primary_Tenant where tenant_id=$tenant_id";
							$result_p_tenant = mysqli_query($con, $sql_p_tenant);
							$row_num = $result_p_tenant->num_rows;

							$sql_s_tenant = "SELECT tenant_id from Secondary_Tenant where tenant_id=$tenant_id";
							$result_s_tenant = mysqli_query($con, $sql_s_tenant);
							$row_num2 = $result_s_tenant->num_rows;	

							if (($row_num == 0) && ($row_num2 == 0)) {
								$sql_update = "UPDATE Secondary_Tenant SET Tenant_ID=$tenant_id where Renting_Room="
								."$room_id";
								if (!mysqli_query($con,$sql_update)) {
									echo "<section><h2>Updating Tenant</h2><p>Error with database: Please contact an admin"
									." for assistance or <a href='userhome.php?user_id=$user_id'>go back</a> "
									."and try again.</p></section>";
								}
								else {
									echo "<section><h2>Updating Tenant</h2><p>Tenant for Room #$room_id updated"
									." successfully to #$tenant_id. <a href='userhome.php?user_id=$user_id'>Manage another</a>"
									."</p></section>";	
								}	
							}
							else if ($row_num == 0) {
								echo "<section><h2>Updating Tenant</h2>"
								."<p>Error: Cannot update tenant of Room #$room_id to #$tenant_id.<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."renting another room. Please check your input "
								."and try again, or contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
							else if ($row_num2 == 0) {
								echo "<section><h2>Updating Tenant</h2>"
								."<p>Error: Cannot update tenant of Room #$room_id to #$tenant_id<br/>"
								."The tenant with ID #$tenant_id is currently listed as "
								."the primary tenant of another housing. Please check your input and try again, or "
								."contact an admin for assistance.<br/><br/>"
								."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";
							}
						}
					}//end update*/
					else if ($choose_option == 'delete') {
						//delete tenant
						if ($exists == 0) {
							echo "<section><h2>Deleting Tenant</h2>"
							.	"<p>Error: Cannot delete tenant #$tenant_id from Room #$room_id.<br/>"
							.	"There is no tenant with ID #$tenant_id. Please check your input "
							."and try again, or contact an admin for assistance.<br/><br/>"
							."<a href='userhome.php?user_id=$user_id'>Go back</a></p></section>";	
						}
						else {
							$sql_delete = "Delete from Secondary_Tenant where Tenant_ID=$tenant_id and"
								." Renting_Room=$room_id";
							if (!mysqli_query($con,$sql_delete)) {
								echo "<section><h2>Deleting Tenant</h2>Error with database: Please contact"
								." an admin for assistance or <a href='userhome.php?user_id=$user_id'>go back"
								."</a> and try again.</p></section>";
							}
							else {
								echo "<section><h2>Deleting Tenant</h2><p>Tenant #$tenant_id successfully deleted"
								." from Room #$room_id. <a href='userhome.php?user_id=$user_id'>Manage another</a>"
								."</p></section>";	
							}	
						}
					}//end delete
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
						. "Housing Address: $add_1, $add_2, $add_3 $add_4</p>";
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
						echo "<ul><li>Primary: $p_fname $p_lname (#$primary_tenant_id)</li></ul>";
					}
					else {
						//if there are more than one room, then use rooms to find tenant_id
						//then use tenant_id to display roommates names
						//also include primary tenant
						echo "<ul><li>Primary: $p_fname $p_lname (#$primary_tenant_id)</li>";

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
						echo "</ul>";
					}
					
				}
				//registered tenant but not leasing a house or room yet
				else if ($rows4 > 0) {
					echo "<h2>User Type</h2>"
						. "<p>Your ID is #$user_id. <br/> You have not yet been added as a primary tenant or"
						. " secondary tenant. Please contact a landlord or primary tenant to be added.</p>";
					
				}
			
				mysqli_close($con);}
			}
			//login not successful
			else {
				echo "<div><p>You are not logged in. Please login <a href='signin.html'>here</a>. </p></div>";
			}
			//echo "</section>";

			
		?>

   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>