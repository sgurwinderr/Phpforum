<?php
ob_start();
session_start();
$log = $_GET['log'];
function clear($message)
{
	if(!get_magic_quotes_gpc())
		$message = addslashes($message);
	$message = strip_tags($message);
	$message = htmlentities($message);
	return trim($message);
}
if($log == 'off')
{
	unset($_SESSION['login']);
	setcookie('login', '', time() - 86400);
	session_destroy();
	session_regenerate_id(true);
	ob_end_clean();
	echo 'Logged out';
}
else if ($_POST['submit'])
{
	mysql_connect('localhost','root','root');
	mysql_select_db('sampledb');
	$username = clear($_POST['username']);
	$password = clear($_POST['password']);
	$password = sha1($_POST['password']);
	$result = mysql_query("SELECT name FROM user WHERE name = '$username' AND password = '$password'");
	if($output = mysql_fetch_array($result))
	{
		session_regenerate_id(true);
		ob_end_clean();
		echo 'Successfully Logged In!';
		echo 'Welcome ' . $output['name'];
		echo '<a href="?log=off">log off</a>';
		$_SESSION['login'] = array($username, $password);
	}
	else
		echo 'Login failed';
}
else
{
	ob_end_clean();
?>
<form method=post action="#">
	<input id="username" name="username" type="text" value="User Name" size="15" />
	<input id="password"name="password" type="password" value="Password" size="15" />
	<input type="submit" id="submit" name="submit" value="Log In" />
</form>
<?php } ?>