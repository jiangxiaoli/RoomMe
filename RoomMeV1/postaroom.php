<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	Post Housing Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Post Room</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
   </head>


   <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

<?php
		if (isset($_GET['user_id'])) {
			$user_id = $_GET['user_id'];

			if ( ($user_id-1000 < 1000) && ($user_id != 1000)) {
				//is a landlord
				//1000 is for admin
				echo "
				<nav>
					<ul>
						<li><a href='homepage.html'>RoomMe Home/Search</a></li>
						<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
						<li><a href='posthousing.php?user_id=$user_id'>Post Housing</a></li>
					</ul>
				</nav>

				<br/>
				<br/>
				<h2 id='pagetype'>Post a Room</h2>
				<h2>This page is for primary tenants only.</h2>
				<p>Go back to <a href='userhome.php?user_id=$user_id'>User Home</a> page</p>";

			}
			else {
				//is a primary tenant - show page
		echo "
	<nav>
		<ul>
			<li><a href='homepage.html'>RoomMe Home/Search</a></li>
			<li><a href='userhome.php?user_id=$user_id'>User Home</a></li>
			<li><a href='postaroom.php?user_id=$user_id'>Post a Room</a></li>
		</ul>
	</nav>

	</br>	
	</br>

	<h2>For PRIMARY TENANTS Only</h2>
	<h2 id='pagetype'>Post a Room</h2>

	<form id='postroom' name='postroom' action='postroom.php' method='post' class='postroom'>
			<h4>Please fill out the form below</h4>
			<h5>All fields except those in 'Others' are required.</h5>
			<fieldset id='RoomInfo'>
				<h4>General</h4>
				<input type='hidden' name='user_id' value='$user_id'>
				<label for='in_housing'>Housing ID   <span>(Provided by your landlord.)</span></label>
				<input name='in_housing' type='number' placeholder='5###' min='5000' max='10000' required='required' />
				<br/>
				<lable for='rooms_id'>Room #   <span>(Please provide a number for this room listing.)</span></label><br/>
				<input name='rooms_id' type='number' min='1' max='100' step='1' value='1' required='required' />
				<br/><br/>
				<h4>Lease Details</h4>

				<label for='price'>Price ($)</label>
				<input name='price' type='number' min='0' max='10000' required='required' />
				<br/>

				<label for='min_term'>Minimum Lease Term (in months)</label>
				<input name='min_term' type='number' min='0' max='100' value='12' required='required'/>
				<br/>

				<label for='start_date'>Available Start Date</label>
				<input name='start_date' type='date' placeholder='yyyy-mm-dd' required='required' />
				<br/><br/>

				<h4>Room Type</h4>
				<label for='room_type'>Room Type</label>
				<select name='room_type' required='required'>
					<option value='Single Bedroom'>Single Bedroom</option>
					<option value='Shared Bedroom'>Shared Bedrom</option>
					<option value='Living Room'>Living Room</option>
				</select>
				<br/>

				<label for='bathroom_type'>Bathroom Type</label>
				<select name='bathroom_type' required='required'>
					<option value='Individual'>Individual</option>
					<option value='Shared'>Shared</option>
				</select>
				<br/>

				<label for='capacity'>Available Capacity (# of roommates)</label>
				<input name='capacity' type='number' min='1' max='100' value='1' step='1' required='required'/>
				<br/>
				<br/>

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

				<label>Roommate Habits (optional)</label><br/>
					<textarea name='habits' placeholder='list any preferences or exclusion criteria for potential roommates'></textarea>

			</fieldset>

			<input type='submit' value='Post Room'/>
			<input type='reset' value='Reset Fields'/>

		</form>";
			}//end user type	
		}//end isset
		else {
			echo "
			<nav>
			<ul>
				<li><a href='homepage.html'>RoomMe Home/Search</a></li>
			</ul>
			</nav>

			</br>	
			</br>

			<h2>For PRIMARY TENANTS Only</h2>
			<h2 id='pagetype'>Post a Room</h2>

			<section><p>Please <a href='signin.html'>login</a> to post housing.</p></section>";
		}

		
	?>

   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>