<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html>
<head>
<title>RolePermissionManangement</title>
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
	$login="";
	if($_SESSION["isadmin"]==1){
		$login=$_SESSION["user"];		
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
}
else
	Header('Location:login.php');
	}
else
	Header('Location:login.php');
?>

<div class="grid-container">
  <div class="item1" id="div1">
<div class="sidenav">
<h1>Role Permission Management</h1>
<form>
<?php

$perm=0;
$role=0;
$rpid=0;
$rname="";
$pname="";
if(isset($_SESSION["edit"])==true ){
			$ruid=$_SESSION["edit"];
			$perm=$_SESSION["permission"];		
		    $role=$_SESSION["role"];		
	 $sql = "SELECT * FROM roles";	
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){		
				while($row = mysqli_fetch_assoc($result)) {					
				if($role==$row["roleid"]){					
					$rname=$row["name"];					
				}
				}
				}	
				$sql = "SELECT * FROM permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){		
				while($row = mysqli_fetch_assoc($result)) {					
				if($perm==$row["permissionid"]){					
					$pname=$row["name"];					
				}
				}
				}	
}
if(isset($_SESSION["clear"])==true ){
			$rname="";
			$pname="";
}
		?>
		
Role:<br>
 <select  name="roles">
 <?php
 $sql = "SELECT * FROM roles";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){		
			if($rname)
				{
					 echo "<option value='$role'>$rname</option>";
				}
				while($row = mysqli_fetch_assoc($result)) {	
				
				if($rname!=$row["name"]){
					$id=$row["roleid"];
					$name=$row["name"];
					 echo "<option value='$id'>$name</option>";
				}
				}				
				}
    ?>
</select><br>
Permission:<br>
 <select  name="permissionCmb">
 <?php
 $sql = "SELECT * FROM permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){			
			if($pname)
				{
					 echo "<option value='$perm'>$pname</option>";
				}
				while($row = mysqli_fetch_assoc($result)) {	
				
				if($pname!=$row["name"]){
					$id=$row["permissionid"];
					$name=$row["name"];
					 echo "<option value='$id'>$name</option>";
				}
				}				
				}
    ?>
</select><br>
   <input type=submit id="save" value="save" name="save">
	
	<?php
	$flagS=false;
	if($rpid>0 && isset($_REQUEST["save"])==true ){
			$flag1=true;
		$flag2=true;
		$flagS=true;
		$p=$_REQUEST["permissionCmb"];
		$r=$_REQUEST["roles"];
		$sql="UPDATE role_permission SET roleid='$r', permissionid='$p' WHERE id=$rpid";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('record has been edited');</script>";
	Header('Location:Role_Perm_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
		$rpid=0;
		$_SESSION["edit"]=null;	
	}
	if(!$flagS){
	if(isset($_REQUEST["save"])==true )
	{
		$flag1=true;
		$p=$_REQUEST["permissionCmb"];
		$r=$_REQUEST["roles"];
				$s = "SELECT * FROM role_permission";
			$rslt = mysqli_query($conn, $s);
			$records = mysqli_num_rows($rslt);					
			if ($records > 0){			
				while($data = mysqli_fetch_assoc($rslt)) {	
					 if($data["permissionid"]==$p && $data["roleid"]==$r)
					 {
						 $flag1=false;						
					 }
				}	
			}	
			if(!$flag1)
			{
				echo "<script>alert('record already exists');</script>";
			}
			else if($flag1==true){
		$sql = "INSERT INTO role_permission (roleid, permissionid) VALUES ('$r','$p')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('new record has been added');</script>";
	Header('Location:Role_Perm_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
	}
	
	else
		Header('Location:Role_Permission.php');
	}
	}
?>
	
</form>
</div>
</div>
</div>
</form>
 </body>
</html>