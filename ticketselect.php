<?
session_start();

if (isset($_GET['field']) && isset($_SESSION['active']) && $_SESSION['active']) {
	include 'inc/db.php';

	$field = $_GET['field'];

	if (isset($_GET['val'])) {
		$value = $_GET['val'];
	}
	else {
		$value = "";
	}

	$query = "select id, name from $field;";

	$rs = mysql_query($query) or die(mysql_error());

	while ($line = mysql_fetch_array($rs)) {
		echo '<option';

		if ($value == $line['id']) {
			echo ' selected';
		}

		echo ' value="' . $line['id'] . '">' . $line['name'] . '</option>';
	}

	include 'inc/dbc.php';
}
