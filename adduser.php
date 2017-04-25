<form action="#" method="post">
	Username:<input name="name" type="text" id="name" size="15" />
	Password:<input type="password" name="password" size="15" />
	<input type="submit" name="submit" value="Sign Up" />
</form>
<?php
if ($_POST['submit'])
{
	mysql_connect('localhost','root','root');
	mysql_select_db('sampledb');
	$name = $_POST['name']; 
	$password = $_POST['password'];
	$sql = mysql_query("SELECT * FROM user WHERE name = '$name'");
	if (!mysql_fetch_array($sql))
	{
		$password = sha1($_POST['password']);
		$sql2 = "INSERT INTO user (name, password) VALUES ('$name', '$password')";
		mysql_query($sql2);
		mysql_close();
		echo 'You have been entered into our database.';
	}
	else
		echo 'Name already in use.';
}
?>