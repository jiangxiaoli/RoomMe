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
	
	$campus = $_GET['campus'];

?>


<html>
  <head>
      <!--Searching Result Cmpe 180-38 Team 6 -->

    	<meta charset="UTF-8" />
    	<title>RoomMe - Result List</title>
    	<link href="styles.css" rel="stylesheet" type="text/css" />
    	<style>
    		.resultlist {
    				     margin: 10px;
    					 color: blue; 
    					 background: #E0F8F7;
    					 padding: 20px 30px 20px 30px;
    					 text-align: center;
    					}
    		.resultlist th {
    		  padding: 0 10px 0 10px;
    		}
    		table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):after { 
    						content: " \25B4\25BE" 
    					}
    	</style>
    	<script src="sorttable.js"></script>

    	<link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
    	<link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
    	<link href="jQueryAssets/jquery.ui.tabs.min.css" rel="stylesheet" type="text/css">
      <script src="jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
      <script src="jQueryAssets/jquery-ui-1.9.2.tabs.custom.min.js" type="text/javascript"></script>
  </head>
 <body>
	<header>
	    <h1>RoomMe Application</h1>
	</header>

	<nav>
		<ul>
			<li><a href="homepage.html">RoomMe Home</a></li>
			<li><a href="userhome.php">User Home</a></li>
			<li><a href="postroom.html">Post a Room</a></li>
			<li><a href="signup.html">Sign up</a></li>
		</ul>
	</nav>
	<br>
	<br>
	<p><h2 id="pagetype">Searching Result</h2></p>

     <div id="Tabs1">
          <ul>
            <li><a href="#tab-housing">Housing</a></li>
            <li><a href="#tab-room">Room</a></li>
            <li><a href="#tab-roomie">Rommie</a></li>
          </ul>
       <div id="tab-housing">
            
            <!-- maybe link to php? with the parameter ?campus=-->
            <a href="filter_housing.html?campus=$campus">
            <input type="submit" value="Housing Filter"/></a>
            
            <p>Housing List</p>
            
            <table class="resultlist sortable">
              <thead>
                <th>ID</th>
                <th>Location.Street</th>
                <th>Distance to School</th>
                <th>Price</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
              </thead>
			  <tbody>
              <?php
			  		$table= "housing";
				
					//execute query
					$query = "SELECT * FROM $table WHERE Campus = '$campus'";
					$result = mysqli_query($con, $query);
					
					
                if (mysqli_num_rows($result) == 0){
                    echo "<h4> No Data </h4>";
                }
                else {
                    while( $row = mysqli_fetch_array ($result)) {
                        $Housing_ID = $row['Housing_ID'];
                        $Street_Address = $row["Street_Address"];
                        $Distance = $row["Distance_to_school"];
                        $Price = $row["Price"];
                        $num_Bedr = $row["No_of_Bedrooms"];
                        $num_Batr = $row["No_of_Bathrooms"];
                        echo" 
                            
                            <tr>
                                <td><a href=\"housing_detail.php?Housing_ID=$Housing_ID\"> $Housing_ID</a></td>
                                <td> $Street_Address</td>
                                <td> $Distance</td>
                                <td> $Price</td>
                                <td> $num_Bedr</td>
                                <td> $num_Batr</td>

                            </tr>
                            

                            ";
                    }
                }
                mysqli_close($con);
              ?>
			</tbody>
         </table>

         </div>
          <div id="tab-room">
            <a href="filter_room.html?campus=$campus">
            <input type="submit" value="Room Filter"/></a>

            <p>Room List</p>
            
            <table class="resultlist sortable">
              <thead>
                <th>Room ID</th>
                <th>Price</th>
                <th>Room Type</th>
                <th>Bathroom Type</th>
                <th>Capacity</th>
                <th>In Housing</th>
              </thead>
			  <tbody>
              <?php				
					//execute query
					$con = mysqli_connect($host,$username,$password, $database);
          $query = "SELECT * FROM Rooms, Housing WHERE In_Housing = Housing_ID AND Campus = '$campus'";
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
                                <td> <a href=\"room_detail.php?Rooms_ID=$Rooms_ID\">$Rooms_ID</a></td>
                                <td> $Price</td>
                                <td> $Room_Type</td>
                                <td> $Bathroom_Type</td>
                                <td> $Capacity</td>
                                <td> $In_Housing</td>
                            </tr>";
                    }
                }
                mysqli_close($con);
              ?>
			  <tbody>
         </table>
            
          </div>
          <div id="tab-roomie">
            <a href="filter_roomie.html?campus=$campus">
            <input type="submit" value="Roomie Filter"/></a>

            <p>Roomie List</p>
            
            <table class="resultlist sortable">
              <thead>
                <th>Tenant ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Major</th>
                <th>Gender</th>
                <th>Age</th>
              </thead>
			  <tbody>
              <?php				
      					//execute query
      					$con = mysqli_connect($host,$username,$password, $database);
                $query = "SELECT * FROM Tenant WHERE School = '$campus'";
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
                              echo" <tr>
                                      <td> $Tenant_ID</td>
                                      <td> $Fname</td>
                                      <td> $Lname</td>
                                      <td> $Major</td>
                                      <td> $Gender</td>
                                      <td> $Age</td>
                                  </tr>";
                          }
                      }
                    mysqli_close($con);
              ?>
			 </tbody>
         </table>            
            
          </div>
     </div>
	
    <p>&nbsp;</p>
	
    
    <p><h6><a href="homepage.html"> Back to Home Page</a></h6>

    <script type="text/javascript">
    $(function() {
    	$( "#Tabs1" ).tabs(); 
    });
    </script>

  </body>
 
   <footer>
  &copy; Team 6, Cmpe 180-38, SJSU, 2014
   </footer>

</html>

						