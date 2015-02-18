<html>
<head>
<style>
	@import url('inc/theme.css');
</style>
</head>
<body>

<?
session_start();

if (isset($_GET['out'])) {
	$_SESSION['active'] = false;
	$_SESSION['usn'] = "";
	$_SESSION['role'] = "nobody";
	$_SESSION['canUpdate'] = false;

	session_destroy();
}

if (isset($_SESSION['active'])) {
	header("Location: index.php");
}

if (isset($_POST['username'])) {
	include "inc/db.php";

	$usn = $_POST['username'];
	$psw = $_POST['password'];

	$psw = md5($psw);

	var_dump($psw);

	$query = "select user_role.roleId as roleId from user inner join user_role on user.id = user_role.userId where username = '$usn' and password ='$psw';";

	$rs = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($rs) == 1) {
		$row = mysql_fetch_array($rs);

		if ($row['roleId'] == 1) {
			$_SESSION['canUpdate'] = true;
		}
		else {
			$_SESSION['canUpdate'] = false;
		}

		$_SESSION['active'] = true;
		$_SESSION['usn'] = $usn;
		$_SESSION['role'] = $row['roleId'];

		header("Location: index.php");
	}
	else {
		die("No such user!<script type='text/javascript'>setTimeout('window.location=\'/\';', 5000);</script>");
	}

}
else {
?>

<form method="post" action="login.php">
	<input type="text" name="username" placeholder="username" /><br />
	<input type="password" name="password" placeholder="password" /><br />
	<input type="submit" value="Log In" />
</form>

<?
}
?>

</body>
</html>
