<?php
session_start();
function clear($message)
{
	if(!get_magic_quotes_gpc())
		$message = addslashes($message);
	
	$message = strip_tags($message);
	$message = htmlentities($message);
	return trim($message);
}
if(!$_SESSION['login'])
{
	header('Location: adduser.php');
	exit;
}
else
{
	$name = clear($_SESSION['login'][0]); 
	$password = clear($_SESSION['login'][1]);
	mysql_connect('localhost','root','root');
	mysql_select_db('sampledb');
	$sql = mysql_query("SELECT name FROM user WHERE name = '$name' AND password = '$password'");
	if($row = mysql_fetch_array($sql))
		echo 'Welcome '.$row['name'];
	else
	{
		header('Location: signup.php');
		exit;
	}
}
?>