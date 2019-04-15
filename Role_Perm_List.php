
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html>
<head>
<title>rolePermissionList</title>
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
	$sql = "SELECT * FROM role_permission where id=$e";
	$result = mysqli_query($conn, $sql);
	$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
			
				while($row = mysqli_fetch_assoc($result)) {	
					$_SESSION["permission"]=$row["permissionid"];
					$_SESSION["role"]=$row["roleid"];
				}
				Header('Location:Role_Permission.php');
}
}
if(isset($_REQUEST["delete"]) == true){
	$d=$_REQUEST["delete"];
	$sql = "DELETE FROM role_permission WHERE id=$d";

if ($conn->query($sql) === TRUE) {
     echo "<script>alert('record deleted successfully');</script>";
} else {
    echo "<script>alert('Error deleting record:');</script>" . $conn->error;
}
	 
}

echo'<table>';
echo'<tr>';
    echo'<th>Role Permission Id</th>';
	echo'<th>Role</th>';
	echo'<th>Permission</th>';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM role_permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["id"].'</td>';
					$rid=$row["roleid"];
					$s = "SELECT * FROM roles where roleid=$rid";
					$rslt = mysqli_query($conn, $s);
					$records = mysqli_num_rows($rslt);					
					if ($records > 0){
					while($data = mysqli_fetch_assoc($rslt)){
					echo'<td>'.$data["name"].'</td>';
					}
					}
					$pid=$row["permissionid"];
					$sq = "SELECT * FROM permission where permissionid=$pid";
					$rs = mysqli_query($conn, $sq);
					$recordsF = mysqli_num_rows($rs);					
					if ($recordsF > 0){
					while($perm = mysqli_fetch_assoc($rs)){
					echo'<td>'.$perm["name"].'</td>';
					}
					}
					$id=$row["id"];
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
<form action='Role_Permission.php'>
<input type=submit name="btn1" value="Add Role">

</form>
 </body>
</html>