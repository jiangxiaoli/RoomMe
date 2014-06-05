<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Update Room</title>
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
				if (($user_id -1000 < 1000) && ($user_id - 1000 != 0)) {
					//is a landlord
					echo "<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>";
				
				}
				else {
					//is a tenant or admin
					echo "<li><a href='homepage.html'>RoomMe Home</a></li>
				<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
				<li><a href='postaroom.php?user_id=$user_id'>Post a Room</a></li>";
				
				}
	
	echo "		
		</ul>
	</nav>

	</br>	
	</br>
	
	<h2 id='pagetype'>Update Room</h2>";
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

						//calculate the room # within housing
						$innerroom_id = $room_id - $renting_house*10;

						$sql = "SELECT * from Rooms where Rooms_ID=$room_id";
						$detail_result = mysqli_query($con,$sql);
						$num_rooms = $detail_result->num_rows;

						if ($num_rooms == 0) {
							echo "<section><p>Error: A room with ID #$room_id does not exist. Please go "
							."back to your <a href='userhome.php?user_id=$user_id'>home page</a>"
							." and try again.</p></section>";
						}
						else {
							$i = mysqli_fetch_array($detail_result);

							$rentable = $i['In_Housing'];
							/*if ($rentable != $renting_house) {
								//check if primary tenant is renting the house to which the room belongs
								echo "<section><p>Room ID #$housing_id does not belong to the housing that you are "
									."renting. You do not have permission to update this housing. Please go back"
									." to your <a href='userhome.php?user_id=$user_id'>home page</a> to try again."
									. "</p></section>";
							}
							else */if ($rentable == $renting_house or $user_id ==1000){

							//get and set variables
							$price = $i['Price'];
							$min_term = $i['Min_term'];
							$start_date = $i['Start_date'];
							$room_type = $i['Room_Type'];
							$bathroom_type = $i['Bathroom_Type'];
							$capacity = $i['Capacity'];
							$parking = $i['Parking'];
							$laundry = $i['Laundry'];
							$smoking = $i['Smoking'];
							$pets = $i['Pets'];
							$description = $i['Description'];
							$habits = $i['Habits'];
							
							echo "
							<form id='postroom' name='postroom' action='postroom.php?room_id=$room_id&user_id=$user_id' method='post' class='postroom'>
							<h4>Please update existing information below</h4>
							<h5>All fields except those in 'Others' are required.</h5><br/>
							
								<fieldset id='RoomInfo'>
									<h4>General</h4>
									<label for='in_housing'>Housing ID   <span>(Leave as is)</span></label>
									<input name='in_housing' type='number' placeholder='5###' min='5000' max='10000' required='required' readonly value='$rentable'/>
									<br/>
									<label for='rooms_id'>Room #   <span>(Leave as is)</span></label>
									<input name='rooms_id' type='number' min='1' max='100' step='1' readonly value='$innerroom_id' required='required' />
									<br/><br/>
									<input name='user_id' type='hidden' value='$user_id'>

									<h4>Lease Details</h4>

									<label for='price'>Price ($)</label>
									<input name='price' type='number' min='0' max='10000' required='required'
									value='$price' />
									<br/>

									<label for='min_term'>Minimum Lease Term (in months)</label>
									<input name='min_term' type='number' min='0' max='100' value='$min_term' required='required'/>
									<br/>

									<label for='start_date'>Available Start Date</label>
									<input name='start_date' type='date' placeholder='yyyy-mm-dd' required='required' 
									value='$start_date'/>
									<br/><br/>

									<h4>Room Type</h4>
									<label for='room_type'>Room Type</label>
									<select name='room_type' required='required'>";

									if ($room_type == 'Single Bedroom') {
										echo "
										<option value='Single Bedroom' selected='selected'>Single Bedroom</option>
										<option value='Shared Bedroom'>Shared Bedrom</option>
										<option value='Living Room'>Living Room</option>";
									}
									else if ($room_type == 'Shared Bedroom') {
										echo "
										<option value='Single Bedroom'>Single Bedroom</option>
										<option value='Shared Bedroom' selected='selected'>Shared Bedrom</option>
										<option value='Living Room'>Living Room</option>";
									}
									else {
										echo "
										<option value='Single Bedroom'>Single Bedroom</option>
										<option value='Shared Bedroom'>Shared Bedrom</option>
										<option value='Living Room' selected='selected'>Living Room</option>";
									}

									echo "
									</select>
									<br/>

									<label for='bathroom_type'>Bathroom Type</label>
									<select name='bathroom_type' required='required'>";

									if ($bathroom_type == 'Individual') {
										echo "<option value='Individual' selected='selected'>Individual</option>
										<option value='Shared'>Shared</option>";
									}
									else {
										echo "<option value='Individual'>Individual</option>
										<option value='Shared' selected='selected'>Shared</option>";
									}
									echo "
										<option value='Individual'>Individual</option>
										<option value='Shared'>Shared</option>
									</select>
									<br/>

									<label for='capacity'>Available Capacity (# of roommates)</label>
									<input name='capacity' type='number' min='1' max='100' value='$capacity' step='1' required='required'/>
									<br/>
									<br/>

								<h4>Facilities / Rules</h4>
								<label>Parking</label>";

								if ($parking == 'y') {
									echo "<input type='radio' name='parking' value='y' checked='checked'>Yes
									<input type='radio' name='parking' value='n'>No<br/>";
								}
								else {
									echo "<input type='radio' name='parking' value='y'>Yes
									<input type='radio' name='parking' value='n' checked='checked'>No<br/>";
								}

								echo "<label>Laundry</label>";
								if ($laundry == 'y') {
									echo "<input type='radio' name='laundry' value='y' checked='checked'>Yes
									<input type='radio' name='laundry' value='n'>No<br/>";
								}
								else {
									echo "<input type='radio' name='laundry' value='y'>Yes
									<input type='radio' name='laundry' value='n' checked='checked'>No<br/>";
								}
								echo "<label>Smoking</label>";
								if ($smoking == 'y') {
									echo "<input type='radio' name='smoking' value='y' checked='checked'>Yes
									<input type='radio' name='smoking' value='n'>No<br/>";
								}
								else {
									echo "<input type='radio' name='smoking' value='y'>Yes
									<input type='radio' name='smoking' value='n' checked='checked'>No<br/>";
								}
								echo "<label>Pets</label>";
								if ($pets == 'y') {
									echo "<input type='radio' name='pets' value='y' checked='checked'>Yes
									<input type='radio' name='pets' value='n'>No<br/>";
								}
								else {
									echo "<input type='radio' name='pets' value='y'>Yes
									<input type='radio' name='pets' value='n' checked='checked'>No<br/>";
								}
				echo "
				<h4>Others</h4>
				<label>Short Description (optional)</label><br/>
					<textarea name='description' placeholder='insert a description'>$description</textarea>
				<br/>

				<label>Roommate Habits (optional)</label><br/>
					<textarea name='habits' placeholder='list any preferences or exclusion criteria for potential roommates'>$habits</textarea>

			</fieldset>

			<input type='submit' value='Update Room'/>
			<input type='reset' value='Reset'/>
						</form>";
							} 

							else if ($rentable != $renting_house) {
								//check if primary tenant is renting the house to which the room belongs
								echo "<section><p>Room ID #$housing_id does not belong to the housing that you are "
									."renting. You do not have permission to update this housing. Please go back"
									." to your <a href='userhome.php?user_id=$user_id'>home page</a> to try again."
									. "</p></section>";
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
					echo "<section><p>You do not have permission for this page. Go back to your"
					." <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";						
				}
				mysqli_close($con);	
			}//end if
			else {
				//not logged in
				echo "<section><p>You do not have permission for this page. Go back to your"
					." <a href='userhome.php?user_id=$user_id'>home page</a>.</p></section>";					
			}
			
		?>
	
   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>