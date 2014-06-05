<!DOCTYPE html>
<html>

   <head>
   <!-- 
   	User Home Page
   	Cmpe 180-38
   	Team 6
    -->

	<meta charset="UTF-8" />
	<title>RoomMe - Updating Users</title>
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
				if ($user_id == 1000) {
					//if admin
					echo "<li><a href='homepage.html'>RoomMe Home</a></li>";
					echo "<li><a href='adminhome.php?user_id=1000'>AdminHome</a></li></ul></nav>";
					echo "<section>";

					if (isset($_GET['Landlord_ID'])) {
						$type = 'landlord';
						$landlord_id = $_GET['Landlord_ID'];
					}
					else if (isset($_GET['Tenant_ID'])) {
						$type = 'tenant';
						$tenant_id = $_GET['Tenant_ID'];
					}

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

					if ($type == 'landlord') {
						$sql = "SELECT * FROM Landlord where landlord_id=$landlord_id";
						$result = mysqli_query($con, $sql);
						$i = mysqli_fetch_array($result);
						
							//set variables to prepopulate form
							$user = $i['Username'];
							$pass = $i['Password'];
							$email = $i['Email'];
							$fname = $i['Fname'];
							$lname = $i['Lname'];
							$phone = $i['Phone_number'];

						//display landlord form
						echo "<h2>Updating Landlord</h2>";
						echo "<form action='landlordsignup.php?user_id=$user_id&landlord_id=$landlord_id' method='post'>
		
						<fieldset id='LandlordInfo'>
							<label for='username'>Username</label>
							<input name='username' type='text' required='required' value='$user'/>
							<br/></br/>

							<label for='password'>Password</label>
							<input name='password' type='text' required='required' value='$pass'/>
							<br/></br/>

							<label for='email'>Email</label>
							<input name='email' type='text' placeholder='test@something.xyz' required='required' value='$email'/>
							<br/></br/>

							<label for='fname'>First Name</label>
							<input name='fname' type='text' required='required' value='$fname'/>
							<br/></br/>

							<label for='lname'>Last Name</label>
							<input name='lname' type='text' required='required' value='$lname'/>
							<br/></br/>

							<label for='phone_number'>Phone Number</label>
							<input name='phone_number' id='phone_number' type='text' placeholder='##########' required='required' value='$phone'/>
							<br/></br/>

						</fieldset>

						<input type='submit' value='Update Info'>
						<input type='reset' value='Reset Fields'>
					</form>";


					}
					else if ($type == 'tenant') {
						$sql = "SELECT * FROM tenant where tenant_id=$tenant_id";
						$result = mysqli_query($con, $sql);
						$i = mysqli_fetch_array($result);
						
							//set variables to prepopulate form
							$user = $i['Username'];
							$pass = $i['Password'];
							$email = $i['Email'];
							$fname = $i['Fname'];
							$lname = $i['Lname'];
							$phone = $i['Phone_number'];
							$school = $i['School'];
							$age = $i['Age'];
							$major = $i['Major'];
							$gender = $i['Gender'];
							$country = $i['Home_country'];
							$smoking = $i['Smoking'];
							$pets = $i['Pets'];

						//display tenant form
						echo "<h2>Updating Tenant</h2>";
						echo "<form action='tenantsignup.php?user_id=$user_id&tenant_id=$tenant_id' method='post'>
						<fieldset id='TenantInfo'>
							<label for='username'>Username</label>
								<input name='username' type='text' required='required' value='$user'/>
							<br/></br/>

							<label for='password'>Password</label>
								<input name='password' type='text' required='required' value='$pass'/>
							<br/></br/>

							<label for='email'>Email</label>
								<input name='email' type='text' required='required' value='$email'/>
							<br/></br/>

							<label for='fname'>First Name</label>
								<input name='fname' type='text' required='required' value='$fname'/>
							<br/></br/>

							<label for='lname'>Last Name</label>
								<input name='lname' type='text' required='required' value='$lname'/>
							<br/></br/>

							<label for='phone_number'>Phone Number</label>
								<input name='phone_number' id='phone_number' type='number' placeholder='##########' min='1000000000' required='required' value='$phone'/>
							<br/></br/>

							<label for='school'>Located Near</label>
								<input name='school' type='text' placeholder='School Name (ie. SJSU)' required='required' value='$school'/>
							<br/><br/>

							<label for='major'>Major</label>
								<input name='major' type='text' required='required' value='$major' />
							<br/><br/>

							<label for='age'>Age</label>
								<input name='age' type='number' required='required' value='$age'/>
							<br/><br/>

							<label>Gender</label>";

							if ($gender=='F') {
								echo "<input type='radio' name='gender' value='F' checked>Female
								<input type='radio' name='gender' value='M'>Male<br/>";
							}
							else {
								echo "<input type='radio' name='gender' value='F'>Female
								<input type='radio' name='gender' value='M' checked>Male<br/>";
							}

							echo "
							<br/>

							<label>Smoking</label>";
							if ($smoking=='y') {
								echo "<input type='radio' name='smoking' value='y' checked>Yes
								<input type='radio' name='smoking' value='n'>No<br/>";
							}
							else {
								echo "<input type='radio' name='smoking' value='y'>Yes
								<input type='radio' name='smoking' value='n' checked='checked'>No<br/>";
							}
							echo "
							<br/>
							
							<label>Pets</label>";

							if ($pets =='y') {
								echo "<input type='radio' name='pets' value='y' checked>Yes
								<input type='radio' name='pets' value='n'>No<br/>";
							}
							else {
								echo "<input type='radio' name='pets' value='y'>Yes
								<input type='radio' name='pets' value='n' checked='checked'>No<br/>";
							}
							echo "
							<br/>

							<label for='home_country'>Home Country</label>
								<input name='home_country' type='text' value='$country' />
							<br/><br/>

						</fieldset>
						<input type='submit' value='Update Info'>
						<input type='reset' value='Reset Fields'>
						</form>";
					}
					echo "</section>";

					mysqli_close($con);
				}
			}	
			else {
				//not logged in
				echo "<li><a href='homepage.html'>RoomMe Home</a></li></nav></ul>"
				."<section><h2>Updating Users</h2><p>You do not have permission for this page. Go back to RoomMe "
				."<a href='homepage.html'>home page</a>.</p></section>";					
			}
			
		?>
	
   </body>

   <footer>
	&copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>
</html>