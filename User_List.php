<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>

<html>
<head>
<title>userList</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}


.topnav {
    overflow: hidden;
    background-color: #333;
}

/* Style the topnav links */
.topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* Style the content */
.content {
    background-color: #ddd;
    padding: 10px;
    height: 200px; 
}
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    
}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto auto auto auto auto;
  grid-gap: 10px;
  background-color: white;
  padding: 1px;
}
.grid-container > div {
  background-color: gainsboro;
  
  padding: 0px 0;
  
}
.item1 {
  grid-row: 1/4;
  
}
.item2 {
  grid-row: 1/4;
  
}
h1 {
    color: white;
     background-color:rgb(60, 60, 60)
}
table, th, td {
    border: 1px solid black;
</style>
</head>
<body>
<form>
<?php
if(isset($_SESSION["user"]) == true){
	if($_SESSION["isadmin"]==1){
echo'<div class="topnav">';
  echo'<a href="home.php">Home</a>';
	  echo'<a href="User_List.php" >User Management</a>';
	     echo'<a href="Role_List.php" >Role Management</a>';
	    echo'<a href="Permission_List.php" >Permissions Management</a>';
	   echo'<a href="Role_Perm_List.php">Role-Permissions Assignment</a>';
	echo'<a href="User_Role_List.php">User-Role Assignment</a>';
	echo'<a href="Login_History.php">Login History</a>';
	  echo' <a href="login.php" >Logout</a>';
echo'</div>';
echo'<br><br>';
if(isset($_REQUEST["edit"]) == true)
{	
	$e=$_REQUEST["edit"];
	$_SESSION["edit"]=$_REQUEST["edit"];
	$sql = "SELECT * FROM users where userid=$e";
	$result = mysqli_query($conn, $sql);
	$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					$_SESSION["login"]=$row["login"];
					$_SESSION["password"]=$row["password"];
					$_SESSION["name"]=$row["name"];
					$_SESSION["email"]=$row["email"];
					$_SESSION["adminType"]=$row["isadmin"];					
					$_SESSION["countryid"]=$row["countryid"];
				}
				Header('Location:User.php');
}
}
if(isset($_REQUEST["delete"]) == true){
	$d=$_REQUEST["delete"];
	
	$sql = "DELETE FROM users WHERE userid=$d";

if ($conn->query($sql) === TRUE) {
     echo "<script>alert('Record deleted successfull');</script>";
} else {
    echo "<script>alert('Error deleting record:');</script>" . $conn->error;
}

}
echo'<table>';
echo'<tr>';
    echo'<th>UserId</th>';
    echo'<th>Login</th> ';
    echo'<th>Password</th>';
	echo'<th>Name</th>';
    echo'<th>Email</th> ';
    echo'<th>Country</th>';
	echo'<th>CreatedBy</th>';
    echo'<th>CreatedOn</th> ';
	
    echo'<th>IsAdmin</th>';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM USERS";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["userid"].'</td>';
					echo'<td>'.$row["login"].'</td>';
					echo'<td>'.$row["password"].'</td>';
					echo'<td>'.$row["name"].'</td>';
					echo'<td>'.$row["email"].'</td>';
					$ctry=$row['countryid'];
					$q="Select * from country where id=$ctry";
					$country = mysqli_query($conn, $q);
					$d = mysqli_fetch_assoc($country);
					echo "<td>".$d['name']."</td>";
					echo'<td>'.$row["createdby"].'</td>';
					echo'<td>'.$row["createdon"].'</td>';
					
					if($row["isadmin"]==1)
					{
						echo'<td>Yes</td>';
					}
					else
						echo'<td>No</td>';
						$id=$row["userid"];
					echo"<td><button type='submit' value='$id' name='edit'> edit </button></td>";
					echo"<td><button type='submit' value='$id' name='delete' onclick='return(confirm(\"Do you want to delete this record?\"));'> delete </button></td>";
					echo'</tr>';
					
				}
			}
echo'</table>';

	}
else
	Header('Location:login.php');
	}
else
	Header('Location:login.php');
?>
</form>
<br>
<form action='User.php'>
<br>
<input type=submit name="btn1" value="add user">

</form>
 </body>
</html>