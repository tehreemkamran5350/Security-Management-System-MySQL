
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html>
<head>
<title>permissionList</title>
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
	$_SESSION["editPerm"]=$_REQUEST["edit"];
	$sql = "SELECT * FROM permission where permissionid=$e";
	$result = mysqli_query($conn, $sql);
	$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){		
				while($row = mysqli_fetch_assoc($result)) {	
					$_SESSION["permission"]=$row["name"];
					$_SESSION["description"]=$row["description"];
				}
				Header('Location:Permission.php');
}
}
if(isset($_REQUEST["delete"]) == true){
	  
	$d=$_REQUEST["delete"];
	$sql = "DELETE FROM Permission WHERE permissionid=$d";

if ($conn->query($sql) === TRUE) {
     echo "<script>alert('permission deleted successfull');</script>";
	// Header('Location:Permission_List.php');
} else {
    echo "<script>alert('Error deleting record:');</script>" . $conn->error;
}
	 
}

echo'<table>';
echo'<tr>';
    echo'<th>PermissionId</th>';
	echo'<th>Name</th>';
    echo'<th>Desription</th> ';
	echo'<th>CreatedBy</th>';
    echo'<th>CreatedOn</th> ';
	
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["permissionid"].'</td>';
					echo'<td>'.$row["name"].'</td>';
					echo'<td>'.$row["description"].'</td>';
					echo'<td>'.$row["createdby"].'</td>';
					echo'<td>'.$row["createdon"].'</td>';
					
					$id=$row["permissionid"];
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
<form action='Permission.php'>
<input type=submit name="btn1" value="Add Permission">

</form>
 </body>
</html>