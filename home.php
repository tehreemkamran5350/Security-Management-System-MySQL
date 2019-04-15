<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html lang="en">
<head>
<title>home</title>
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
dl {
   
    margin: 1%;
    padding: 2%;
    overflow: hidden;

    background-color: gainsboro;
}

</style>



</head>
<body>
<form>
<?php

if(isset($_SESSION["user"]) == true){
	$ulogin=$_SESSION["user"];
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
  echo'<h1 style="background-color:gainsboro;" align="center">Welcome Admin</h1>';
}
else if($_SESSION["isadmin"]==0)
{
	echo'<div class="topnav">';
      echo'<a href="home.php">Home</a>';       
     echo'<a href="login.php">Logout</a>';
    echo"</div>";
	echo'<h1 style="background-color:gainsboro;" align="center">Welcome User</h1>';
	$uid=0;
	$sql = "SELECT * FROM users where login='$ulogin'";
	$result = mysqli_query($conn, $sql);
	$Found = mysqli_num_rows($result);	
			if ($Found > 0){
				while($row = mysqli_fetch_assoc($result)) {	
					$uid=$row['userid'];
				}
}
$rid=0;
	$sql = "SELECT * FROM user_role where userid=$uid";
	$result = mysqli_query($conn, $sql);
	$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {	
					$rid=$row['roleid'];
					$s = "SELECT * FROM roles where roleid=$rid";
					$rs = mysqli_query($conn, $s);
					$record = mysqli_num_rows($rs);					
					if ($record > 0){
						echo"<dl>";
						while($data = mysqli_fetch_assoc($rs)) {	
						echo"<dt><b>Role:		</b>".$data['name']."</dt>";
						$pid=0;
						$sq = "SELECT * FROM role_permission where roleid=$rid";
						$res = mysqli_query($conn, $sq);
						$records = mysqli_num_rows($res);					
						if ($records > 0){
			
							while($perm = mysqli_fetch_assoc($res)) {	
							$pid=$perm['permissionid'];
							$q = "SELECT * FROM permission where permissionid=$pid";
							$rsl = mysqli_query($conn, $q);
						$recordF = mysqli_num_rows($rsl);					
						if ($recordF > 0){
			
						while($arr = mysqli_fetch_assoc($rsl)) {	
						echo"<dt><b>Permission:		</b>".$arr['name']."</dt>";
						}
							}
						}
						}
					}
					echo"</dl>";
				}
	}
}
}
}
?>
</form>
</body>
</html>