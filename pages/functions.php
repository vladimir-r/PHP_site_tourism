<?php
// Connect to DB
function connect($host='localhost',$user='root',$pass='',$dbname='travels'){
global $link;

$link=mysqli_connect($host,$user,$pass) or die('connection error');
mysqli_select_db($link,$dbname) or die('DB open error');
mysqli_set_charset($link,"utf8");
}
//**
//-------------


//insert in DB Users
function register($name,$pass,$email){
	global $link;
$name=trim(htmlspecialchars($name));
$pass=trim(htmlspecialchars($pass));
$email=trim(htmlspecialchars($email));
if ($name=="" || $pass=="" || $email=="") {
echo "<h3><span style='color:red;'>Fill All Required Fields!</span></h3>";
return false;
}
if (strlen($name)<3 || strlen($name)>30 ||
strlen($pass)<3 ||
strlen($pass)>30) 
{
echo "<h3><span style='color:red;'>Values Length Must Be Between 3 And 30!</span></h3>";
return false;
}
$ins='insert into users(login,pass,email,roleid) values("'.$name.'","'.md5($pass).'","'.$email.'",2)';
connect();
mysqli_query($link,$ins);
$err=mysqli_errno($link);
if ($err){
if($err==1062)
echo "<h3><span style='color:red;'>This Login Is Already Taken!</span></h3>";

else
echo "<h3><span style='color:red;'>Error code:".$err."!</span></h3>";

return false;
}
return true;
}
//**
//-----------

// Login
function login($name,$pass){
	global $link;
$name=trim(htmlspecialchars($name));
$pass=trim(htmlspecialchars($pass));
if ($name=="" || $pass=="")
{
echo "<h3><span style='color:red;'>

Fill All Required Fields!</span></h3>";

return false;
}
if (strlen($name)<3 || strlen($name)>30 ||
strlen($pass)<3 || strlen($pass)>30) {
echo "<h3><span style='color:red;'>Value Length Must Be Between 3 And 30!</span></h3>";
return false;
}
connect();
$sel='select * from users where login="'.$name.'" and pass="'.md5($pass).'"';
$res=mysqli_query($link,$sel);
if($row=mysqli_fetch_array($res,MYSQL_NUM)){
$_SESSION['ruser']=$name;
if($row[5]==1)
{

$_SESSION['radmin']=$name;
}

return true;
}
else
{

echo "<h3><span style='color:red;'>No Such User!</span></h3>";
return false;
}
}
//**
//--------


?>