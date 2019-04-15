<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html>
<head>
<title>userManangement</title>
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
<h1> User Management</h1>
<form>
<?php
$n="";
$lg="";
$ps="";
$em="";
$a="";
$op=0;
$na="";
$usid=0;
if(isset($_SESSION["edit"])==true ){
			$usid=$_SESSION["edit"];
			$lg=$_SESSION["login"];		
		$ps=$_SESSION["password"];	
		$em=$_SESSION["email"];
		$n=$_SESSION["name"];
		if($_SESSION["adminType"]==1){
			$a=1;
		}
		$op=$_SESSION["countryid"];
		}
		
		
	 $sql = "SELECT * FROM COUNTRY";
	
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){		
				while($row = mysqli_fetch_assoc($result)) {				
				if($op==$row["id"]){				
					$na=$row["name"];					
				}
				}
				}	
	if(isset($_SESSION["clear"])==true ){
			$lg="";
			$ps="";
			$n="";
			$em="";
			$a=0;
}		
		
		?>
Login:<br>
  <input type=text id="login" name="login" value="<?php echo $lg; ?>" required><br>
  Password:<br>
<input type=password id="pswd" name="pswd" value="<?php echo $ps; ?>" required><br>
 Name:<br>
<input type=text id="name" name="name" value="<?php echo $n; ?>" required><br>
 Email:<br>
  <input type=text id="email" name="email" value="<?php echo $em; ?>" required><br>
 Country:<br>
 <select  id="cmbCountries" name="cmbCountries">
 <?php
 $sql = "SELECT * FROM COUNTRY";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);
			if ($recordsFound > 0){
			
			if($na)
				{
					 echo "<option value='$op'>$na</option>";
				}
				while($row = mysqli_fetch_assoc($result)) {	
				
				if($na!=$row["name"]){
					$id=$row["id"];
					$name=$row["name"];
					 echo "<option value='$id'>$name</option>";
				}
				}				
				}
    ?>
</select><br>
isAdmin<input type="checkbox" name="admin" <?php echo ($a==1 ? 'checked' : '');?> ><br>
   <input type=submit id="save" value="save" name="save">
    <input type=submit id="clear" value="clear" name="clear">
	
	<?php
	$flagS=false;
	
	if($usid>0 && isset($_REQUEST["save"])==true ){
			$flag1=true;
		$flag2=true;
		$flagS=true;
		$u=0;
		$c=0;
		$l=$_REQUEST["login"];
		$p=$_REQUEST["pswd"];
		$e=$_REQUEST["email"];
		$n=$_REQUEST["name"];
		 $cmb=$_REQUEST["cmbCountries"];
		$d=date("Y-m-d h:i:s");
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$login)
					 {
						 $u=$row["userid"];	
					 }
				}	
			}	
		if(isset($_REQUEST["admin"]) == true)
		{
			$c=1;
		}
		 
		$sql="UPDATE users SET login='$l', password='$p', name='$n', email='$e', countryid='$cmb',isadmin='$c' WHERE userid=$usid";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('record has been edited');</script>";
	Header('Location:User_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
		$usid=0;
		$_SESSION["edit"]=null;	
	}
	if(!$flagS){
	if(isset($_REQUEST["save"])==true )
	{
		$flag1=true;
		$flag2=true;
		$u=0;
		$c=0;
		$l=$_REQUEST["login"];
		$p=$_REQUEST["pswd"];
		$e=$_REQUEST["email"];
		$n=$_REQUEST["name"];
		 $cmb=$_REQUEST["cmbCountries"];
		$d=date("Y-m-d h:i:s");
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$login)
					 {
						 $u=$row["userid"];						
					 }
					 if($row["login"]==$l)
					 {
						 $flag1=false;						 
					 }
					 if($row["email"]==$e)
					 {					 
						 $flag2=false;						
					 }
				}	
			}	
			if(!$flag1)
			{
				echo "<script>alert('login already exists');</script>";
			}
			else if(!$flag2)
			{
				echo"<script>alert('email already exists')</script>";
			}
			else if($flag1==true && $flag2=true){
		if(isset($_REQUEST["admin"]) == true)
		{
			$c=1;
		}
		$sql = "INSERT INTO USERS (login, password, name, email, countryid, createdby, createdon, isadmin)
		VALUES ('$l','$p','$n','$e','$cmb','$u','$d','$c')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('new record has been added');</script>";
	Header('Location:User_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
	}
	
	else
		Header('Location:User.php');
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