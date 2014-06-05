<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	Post Housing Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Post Housing</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>
	

	<?php
		if (isset($_GET['user_id'])) {
			$user_id = $_GET['user_id'];

		if ($user_id-1000 > 1000) {
			//is a tenant
			echo "
			<nav>
				<ul>
					<li><a href='homepage.html'>RoomMe Home/Search</a></li>
					<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
					<li><a href='postaroom.php?user_id=$user_id'>Post a Room</a></li>
				</ul>
			</nav>

			<br/>
			<br/>
			<h2 id='pagetype'>Post Housing</h2>
			<h2>This page is for landlords only.</h2>
			<p>Go back to <a href='userhome.php?user_id=$user_id'>User Home</a> page</p>";
		}

		else {
		//is a landlord - show page	
			echo "
				<nav>
					<ul>
						<li><a href='homepage.html'>RoomMe Home/Search</a></li>
						<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
						<li><a href='posthousing.php?user_id=$user_id'>Post Housing</a></li>
					</ul>
				</nav>
	</br>	
	</br>

	<h2>For LANDLORDS Only</h2>
	<h2 id='pagetype'>Post Housing</h2>


		<form id='postroom' name='postroom' action='posthouse.php?user_id=$user_id' method='post' class='postroom'>
			<h4>Please fill out the form below</h4>
			<h5>All fields except those in 'Others' are required.</h5><br/>
			<fieldset id='RoomInfo'>
				<h4>Owner</h4>
				<label for='owned_by'>Your RoomMe ID (Owner's ID)</label>
				<input name='owned_by' type='number' placeholder='1###' min='1001' max='1999' step='1' 
					required='required' />
				<br/></br/>

				<h4>Campus</h4>

				<label for='campus'>Located Near</label>
				<input name='campus' type='text' placeholder='school name (ie. SJSU)' required='required' />
				<br/><br/>

				<h4>Address</h4>

				<label for='street_address'>Street Address</label>
				<input name='street_address' type='text' required='required'/>
				<br/>

				<label for='city'>City</label>
				<input name='city' type='text' required='required'/>
				<br/>

				<label for='state'>State (abbr.)</label>
				<input name='state' type='text' required='required' />
				<br />

				<label for='zip_code'>Zip Code</label>
				<input name='zip_code' type='text' placeholder='#####' required='required' />
				<br/>

				<label for='distance_to_school'>Approx. Distance from Campus (in miles)</label>
				<input name='distance_to_school' type='number' min='0' step='0.1' value='0.0' required='required' />

				<br/><br/>

				<h4>Lease Details</h4>

				<label for='price'>Price ($)</label>
				<input name='price' id='price' type='number' min='0' max='10000' required='required' />
				<br/>

				<label for='min_term'>Minimum Lease Term (in months)</label>
				<input name='min_term' name='term' type='number' min='0' max='100' value='12' required='required' />
				<br/>

				<label for='start_date'>Available Start Date</label>
				<input type='date' name='start_date' placeholder='yyyy-mm-dd' required='required' />
				<br/><br/>

				<h4>Room Type</h4>
				<label for='no_of_bedrooms'>Number of Bedrooms</label>
				<input type='number' name='no_of_bedrooms' min='0' max='20' step='1' value='1' required='required'/>
				<br/>

				<label for='no_of_bathrooms'>Number of Bathrooms</label>
				<input type='number' name='no_of_bathrooms' min='0' max='10' step='0.5' value='1' required='required'/>
				<br/>

				<label for='max_capacity'>Maximum Capacity</label>
				<input type='number' name='max_capacity' min='1' max='100' value='1' step='1' required='required'/>
				<br/><br/>

				<h4>Facilities / Rules</h4>
				<label>Parking</label>
					<input type='radio' name='parking' value='y'>Yes
					<input type='radio' name='parking' value='n' checked='checked'>No<br/>
				
				<label>Laundry</label>
					<input type='radio' name='laundry' value='y'>Yes
					<input type='radio' name='laundry' value='n' checked='checked'>No<br/>
				
				<label>Smoking</label>
					<input type='radio' name='smoking' value='y'>Yes
					<input type='radio' name='smoking' value='n' checked='checked'>No<br/>
				
				<label>Pets</label>
					<input type='radio' name='pets' value='y'>Yes
					<input type='radio' name='pets' value='n' checked='checked'>No<br/>
				<br/>

				<h4>Others</h4>
				<label>Short Description (optional)</label><br/>
					<textarea name='description' placeholder='insert a description'></textarea>
				<br/>

			</fieldset>

			<input type='submit' value='Post Housing'/>
			<input type='reset' value='Reset Fields'/>

		</form>";
			}	
		}
		else {
			echo "<nav>
				<ul>
					<li><a href='homepage.html'>RoomMe Home/Search</a></li>
				</ul>
			</nav><br/><br/>";
			echo "<h2>For LANDLORDS Only</h2>
			<h2 id='pagetype'>Post Housing</h2>";
			echo "<section><p>Please <a href='signin.html'>login</a> to post housing.</p></section>";
		}

		
	?>

   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>