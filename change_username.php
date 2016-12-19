<a href = "view_profile.php">Back</a>
<a href = "index.php">Home</a>
<br> <br>

<?php

require 'connect.php';
require 'core.php';

$query = "SELECT username FROM users where id = ".$_SESSION['user_id'].";";
$query_run = pg_query($conn, $query);
$old_username = pg_fetch_result($query_run, 0, 'username');

if(isset($_POST['new_username'])){

	$query = "UPDATE users SET username = '".$_POST['new_username']."' WHERE id = ".$_SESSION['user_id'].";";
	if (pg_query($conn, $query)){
		echo "Changed username from ".$old_username." to ".$_POST['new_username']."! <br>";
	}

}

?>

<br>

Current username: 
<?php

$query = "SELECT username FROM users where id = ".$_SESSION['user_id'].";";
$query_run = pg_query($conn, $query);
$current_username = pg_fetch_result($query_run, 0, 'username');

echo $current_username;

?>

<br> <br>

<form action="<?php echo $current_file; ?>" method="POST">
New username: <input type="text" name="new_username">
<input type = "submit" value="Submit">
</form>