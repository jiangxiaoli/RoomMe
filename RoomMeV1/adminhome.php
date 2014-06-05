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
	//mysql_select_db("$database") or die("Cannot select DB");

?>


<html>
  <head>
      <!--Searching Result Cmpe 180-38 Team 6 -->

    	<meta charset="UTF-8" />
    	<title>RoomMe - Admin Home</title>
    	<link href="styles.css" rel="stylesheet" type="text/css" />
    	<script src="sorttable.js"></script>

    	<link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
    	<link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
    	<link href="jQueryAssets/jquery.ui.tabs.min.css" rel="stylesheet" type="text/css">
      <script src="jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
      <script src="jQueryAssets/jquery-ui-1.9.2.tabs.custom.min.js" type="text/javascript"></script>
      <script type="text/javascript">
        $(function() {
          $( "#Tabs1" ).tabs(); 
        });
      </script>
  </head>
 <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

  <nav>
      <ul>
        <li><a href="homepage.html">RoomMe Home</a></li>
      </ul>
    </nav>

  <?php
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        if ($user_id == 1000) {
          echo "
          	<br/>
          	<h2 id='pagetype'>Admin Home Page</h2>
            <h2>Manage RoomeMe Database</h2>

              <div id='Tabs1'>
                <ul>
                  <li><a href='#tab-housing'>Housing</a></li>
                  <li><a href='#tab-room'>Room</a></li>
                  <li><a href='#tab-landlord'>Landlord</a></li>
                  <li><a href='#tab-tenant'>Tenant</a></li>                
                </ul>
              <div id='tab-housing'>

                <!-- Add button-->
                <a href='posthousing.php?user_id=1000'>
                <input type='submit' value='Add Housing'/></a>

                      <p>Housing List</p>
                      <table class='resultlist sortable'>
                        <thead>
                          <th>ID</th>
                          <th>Street Address</th>
                          <th>City</th>
                          <th>Miles</th>
                          <th>Price</th>
                          <th>Bd</th>
                          <th>Ba</th>
                        </thead>
          			  <tbody> ";
              
  			  	$table= "housing";
  				
  					//execute query
  					$query = "SELECT * FROM $table";
  					$result = mysqli_query($con, $query);
  					
                  if (mysqli_num_rows($result) == 0){
                      echo "<h4> No Data </h4>";
                  }
                  else {
                      while( $row = mysqli_fetch_array ($result)) {
                          $Housing_ID = $row['Housing_ID'];
                          $Street_Address = $row["Street_Address"];
                          $City = $row["City"];
                          $Distance = $row["Distance_to_school"];
                          $Price = $row["Price"];
                          $num_Bedr = $row["No_of_Bedrooms"];
                          $num_Batr = $row["No_of_Bathrooms"];
                          echo "                              
                              <tr>
                                  <td><a href='housing_detail.php?Housing_ID=$Housing_ID&user_id=1000'>$Housing_ID</a></td>
                                  <td> $Street_Address</td>
                                  <td> $City</td>
                                  <td> $Distance</td>
                                  <td> $Price</td>
                                  <td> $num_Bedr</td>
                                  <td> $num_Batr</td>
                              </tr>
                              
                              ";
                      }
                  }
                  //mysqli_close($con);
                
                echo "
            			</tbody>
                     </table>

                     </div>
                      <div id='tab-room'>
                        <a href='postaroom.php?user_id=1000'>
                        <input type='submit' value='Add a Room'/></a>

                        <p>Room List</p>
                        
                        <table class='resultlist sortable'>
                          <thead>
                            <th>ID</th>
                            <th>Price</th>
                            <th>Room Type</th>
                            <th>Bath Type</th>
                            <th>Cap.</th>
                            <th>In #</th>
                          </thead>
            			  <tbody> ";
            			
  					//execute query
  					//$con = mysqli_connect($host,$username,$password, $database);
            $query = "SELECT * FROM Rooms, Housing WHERE In_Housing = Housing_ID";
  					$result = mysqli_query($con, $query);
  					
  					
                  if (mysqli_num_rows($result) == 0){
                      echo "<h4> No Data </h4>";
                  }
                  else {
                      while( $row = mysqli_fetch_array ($result)) {
                          $Rooms_ID = $row['Rooms_ID'];
                          $Price = $row["Price"];
                          $Room_Type = $row["Room_Type"];
                          $Bathroom_Type = $row["Bathroom_Type"];
                          $Capacity = $row["Capacity"];
                          $In_Housing = $row["In_Housing"];
                          echo" <tr>
                                  <td> <a href=\"room_detail.php?Rooms_ID=$Rooms_ID&user_id=1000\">$Rooms_ID</a></td>
                                  <td> $Price</td>
                                  <td> $Room_Type</td>
                                  <td> $Bathroom_Type</td>
                                  <td> $Capacity</td>
                                  <td> $In_Housing</td>
                              </tr>";
                      }
                  }
                  //mysqli_close($con);
                
                echo "
          			  </tbody>
                   </table>
                      
                    </div>
                    <div id='tab-tenant'>

                      <a href='tenantsignup.html?user_id=$user_id'>
                      <input type='submit' value='Add New Tenant'/></a>

                      <p>Tenant List</p>
                      
                      <table class='resultlist sortable'>
                        <thead>
                          <th>ID</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Major</th>
                          <th>Gender</th>
                          <th>Age</th>
                        </thead>
          			  <tbody> ";
                			
        					//execute query
        					//$con = mysqli_connect($host,$username,$password, $database);
                  $query = "SELECT * FROM Tenant";
        					$result = mysqli_query($con, $query);

                  if (mysqli_num_rows($result) == 0){
                    echo "<h4> No Data </h4>";
                  }
                  else {
                    while( $row = mysqli_fetch_array ($result)) {
                       $Tenant_ID = $row['Tenant_ID'];
                       $Fname = $row["Fname"];
                       $Lname = $row["Lname"];
                       $Major = $row["Major"];
                       $Gender = $row["Gender"];
                       $Age = $row["Age"];
                       echo" 
                       <tr>
                          <td> <a href='Tenant_detail.php?Tenant_ID=$Tenant_ID&user_id=1000'>$Tenant_ID</a></td>
                          <td> $Fname</td>
                          <td> $Lname</td>
                          <td> $Major</td>
                          <td> $Gender</td>
                          <td> $Age</td>
                        </tr>";
                     }
                   }
                   //mysqli_close($con);



                  echo "
                    </tbody>
                    </table>
                                  
                    </div>
                    <div id='tab-landlord'>
                      <a href='landlordsignup.html?user_id=$user_id'>
                      <input type='submit' value='Add New Landlord'/></a>


                      <p>Landlord List</p>
                         <table class='resultlist sortable'>
                          <thead>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                          </thead>
                          <tbody>
                          ";

                      //execute query
                      $con = mysqli_connect($host,$username,$password, $database);
                      $query = "SELECT * FROM Landlord where Landlord_ID<>1000";
                      //exclude admin so they cannot delete themselves
                      $result = mysqli_query($con, $query);
                      
                      
                            if (mysqli_num_rows($result) == 0){
                                echo "<h4> No Data </h4>";
                            }
                            else {
                                while( $row = mysqli_fetch_array ($result)) {
                                    $Landlord_ID = $row['Landlord_ID'];
                                    $Fname = $row["Fname"];
                                    $Lname = $row["Lname"];
                                    $Email = $row["Email"];
                                    $Phone_number = $row["Phone_number"];
                                    
                                    echo" <tr>
                                            <td> <a href='Landlord_detail.php?Landlord_ID=$Landlord_ID&user_id=1000'>$Landlord_ID</a></td>
                                            <td> $Fname</td>
                                            <td> $Lname</td>
                                            <td> $Email</td>
                                            <td> $Phone_number</td>
                                        </tr>";
                                }
                            }
                          //mysqli_close($con);

                   echo "
                       </tbody>
                         </table>             
                          </div>
                     </div> ";

          }//end id check
          else {//if not admin
              echo "
              </br> 
              </br>

              <section><h2>For ADMIN Only</h2>
              <h2 id='pagetype'>Admin Home</h2>

              <p>This page is for RoomMe admin only.<br/>
              Please login to view your user home page <a href='signin.html'>here</a>.</p></section>";
          }
        }//end isset
        else {//if not logged in
            echo "
            </br> 
            </br>

            <h2>For ADMIN Only</h2>
            <h2 id='pagetype'>Admin Home</h2>
            <section>
            <p>Please <a href='signin.html'>login</a> to access Admin Home.</p></section>";
        }

      


  ?>


  </body>
 
   <footer>
  &copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>

</html>

						