<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html>
<head>
<title>UserRoleManangement</title>
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
<h1>User Role Management</h1>
<form>
<?php

$user=0;
$role=0;
$ruid=0;
$rname="";
$uname="";
if(isset($_SESSION["edit"])==true ){
			$ruid=$_SESSION["edit"];
			$user=$_SESSION["userid"];		
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
				$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){		
				while($row = mysqli_fetch_assoc($result)) {					
				if($user==$row["userid"]){					
					$uname=$row["login"];					
				}
				}
				}	
}
if(isset($_SESSION["clear"])==true ){
			$rname="";
			$uname="";
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
user:<br>
 <select  name="usersid">
 <?php
 $sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){			
			if($uname)
				{
					 echo "<option value='$user'>$uname</option>";
				}
				while($row = mysqli_fetch_assoc($result)) {	
				
				if($uname!=$row["login"]){
					$id=$row["userid"];
					$name=$row["login"];
					 echo "<option value='$id'>$name</option>";
				}
				}				
				}
    ?>
</select><br>
   <input type=submit id="save" value="save" name="save">
	
	<?php
	$flagS=false;
	if($ruid>0 && isset($_REQUEST["save"])==true ){
			$flag1=true;
		$flag2=true;
		$flagS=true;
		$u=$_REQUEST["usersid"];
		$r=$_REQUEST["roles"];
		$sql="UPDATE user_role SET roleid='$r', userid='$u' WHERE id=$ruid";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('record has been edited');</script>";
	Header('Location:User_Role_List.php');
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
		$u=$_REQUEST["usersid"];
		$r=$_REQUEST["roles"];
				$s = "SELECT * FROM user_role";
			$rslt = mysqli_query($conn, $s);
			$records = mysqli_num_rows($rslt);					
			if ($records > 0){			
				while($data = mysqli_fetch_assoc($rslt)) {	
					 if($data["userid"]==$u && $data["roleid"]==$r)
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
		$sql = "INSERT INTO user_role (roleid, userid)
		VALUES ('$r','$u')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('new record has been added');</script>";
	Header('Location:User_Role_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
	}
	
	else
		Header('Location:User_Role.php');
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