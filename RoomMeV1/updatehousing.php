<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Update Housing</title>
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
	
	<h2 id='pagetype'>Update Housing</h2>";
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
							if ($owned_by != $user_id && $user_id!=1000) {
								//check if landlord owns this housing
								echo "<section><p>Housing ID #$housing_id does not belong to you. You do not"
									." have permission to update this housing. Please go back to your "
									. "<a href='userhome.php?user_id=$user_id'>home page</a> to try again."
									. "</p></section>";
							}
							else {

							//get and set variables
							$campus = $i['Campus'];
							$street_address = $i['Street_Address'];
							$city = $i['City'];
							$state = $i['State'];
							$zip_code = $i['Zip_code'];
							$distance_to_school = $i['Distance_to_school'];
							$price = $i['Price'];
							$min_term = $i['Min_term'];
							$start_date = $i['Start_date'];
							$no_of_bedrooms = $i['No_of_Bedrooms'];
							$no_of_bathrooms = $i['No_of_Bathrooms'];
							$max_capacity = $i['Max_capacity'];
							$parking = $i['Parking'];
							$laundry = $i['Laundry'];
							$smoking = $i['Smoking'];
							$pets = $i['Pets'];
							$description = $i['Description'];
							

							echo "
							<form id='posthouse' name='posthouse' action='posthouse.php?housing_id=$housing_id&user_id=$user_id' method='post' class='postroom'>
							<h4>Please update existing information below</h4>
							<h5>All fields except those in 'Others' are required.</h5><br/>
							<fieldset id='RoomInfo'>
								<h4>Owner</h4>
								<label for='owned_by'>Owner ID (Leave as is): </label>";


							if($user_id ==1000){
								echo "
								<input name='owned_by' type='number' placeholder='1###' min='1000' max='1999' step='1' 
									readonly value='$owned_by'>

								";
							} 
							else {
								echo "
								<input name='owned_by' type='number' placeholder='1###' min='1000' max='1999' step='1' 
									readonly value='$user_id'>
								";
							}


								
								
							echo "<br/></br/>

								<input name='user_id' type='hidden' value='$user_id'>

								<h4>Campus</h4>

								<label for='campus'>Located Near</label>
								<input name='campus' type='text' placeholder='school name (ie. SJSU)' required='required' value='$campus'/>
								<br/><br/>

								<h4>Address</h4>

								<label for='street_address'>Street Address</label>
								<input name='street_address' type='text' required='required' value='$street_address'/>
								<br/>

								<label for='city'>City</label>
								<input name='city' type='text' required='required' value='$city'/>
								<br/>

								<label for='state'>State (abbr.)</label>
								<input name='state' type='text' required='required' value='$state' />
								<br />

								<label for='zip_code'>Zip Code</label>
								<input name='zip_code' type='text' placeholder='#####' required='required' 
									value='$zip_code'/>

								<br/>

								<label for='distance_to_school'>Approx. Distance from Campus (in miles)</label>
								<input name='distance_to_school' type='number' min='0' step='0.1' value='0.0' required='required' value='$distance_to_school'/>

								<br/><br/>

								<h4>Lease Details</h4>

								<label for='price'>Price ($)</label>
								<input name='price' id='price' type='number' min='0' max='10000' required='required' 
									value='$price'/>
								<br/>

								<label for='min_term'>Minimum Lease Term (in months)</label>
								<input name='min_term' name='term' type='number' min='0' max='100' required='required' value='$min_term'/>
								<br/>

								<label for='start_date'>Available Start Date</label>
								<input type='date' name='start_date' placeholder='yyyy-mm-dd' required='required' 
									value='$start_date'/>
								<br/><br/>

								<h4>Room Type</h4>
								<label for='no_of_bedrooms'>Number of Bedrooms</label>
								<input type='number' name='no_of_bedrooms' min='0' max='20' step='1' value='1' required='required' value='$no_of_bedrooms'/>
								<br/>

								<label for='no_of_bathrooms'>Number of Bathrooms</label>
								<input type='number' name='no_of_bathrooms' min='0' max='10' step='0.5' value='1' required='required' value='$no_of_bathrooms'/>
								<br/>

								<label for='max_capacity'>Maximum Capacity</label>
								<input type='number' name='max_capacity' min='1' max='100' value='1' step='1' required='required' value='$max_capacity'/>
								<br/><br/>

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
								<br/>

								<h4>Others</h4>
								<label>Short Description (optional)</label><br/>
									<textarea name='description' placeholder='insert a description'>$description</textarea>
								<br/>

							</fieldset>

							<input type='submit' value='Update'/>
							<input type='reset' value='Reset'/>

						</form>";
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