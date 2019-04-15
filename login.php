<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>

<html>
<head>
<title>login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
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
h1 {
    color: white;
     background-color:rgb(60, 60, 60)
}
</style>


</head>
<body>

<h1>Security Management</h1>


<form >
<div class="grid-container">
<?php
$_SESSION["user"]=null;
$_SESSION["psw"]=null;
$_SESSION["isadmin"]=null;
?>
  <div class="item1"><h1>Login</h1>
Username:<br>
<input type='text' name="user" id="txtUserName'"><br><br>
Password:<br>
<input type='password' name="psw" id="txtPassword"><br>
<br>
<input type='submit' name="btn1" value="Login" id="btnLogin"></div>
<?php
if(isset($_REQUEST["btn1"])==true ){
	$id=0;
	$u=$_REQUEST["user"];
$p=$_REQUEST["psw"];
$flag = true;
if($u=="" || $p==""){
	echo "<script>alert('name and password required')</script>";
	Header('Location:login.php');
	}
	else{
			$sql = "SELECT * FROM USERS";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {
					if ($row[login] == $u && $row[password] == $p)
					{
						$flag=false;
						$_SESSION["user"]=$u;
						$_SESSION["psw"]=$p;
						$_SESSION["isadmin"]=$row["isadmin"];
						$id=$row["userid"];
					}
				}
				}
			}					
	if (!$flag)
	{
		$d=date("Y-m-d h:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO loginhistory (userid,login, logintime, machineip)
		VALUES ('$id','$u','$d','$ip')";
		$conn->query($sql);
		Header('Location:home.php');
	}
	else
		Header('Location:login.php');
}
?>

		
</form>
  
</body>
</html>
