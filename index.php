<?php

require 'core.php';
require 'connect.php';

if (loggedin()){
	$query = "SELECT username, admin FROM users WHERE id = ".$_SESSION['user_id'].";";
	$query_result = pg_query($conn, $query);
	$truncate_query = "TRUNCATE TABLE temp_order_details;";
	pg_query($conn, $truncate_query);
	$name = pg_fetch_result($query_result, 0, 'username');
	$admin = pg_fetch_result($query_result, 0, 'admin');
	echo '<br><h3>Welcome, '.$name.'. </h3><br>';
	echo '<a href = "shop.php">Shop for gaming stuff!!!!!!</a> <br><br>';
	echo '<a href = "view_profile.php">View profile</a> <br><br>';
	if ($admin == 'y'){
		echo '[admin]<br>';
		echo '<a href = "add_product.php">Add product</a> <br><br>';
		echo '<a href = "edit_product.php">Edit product</a> <br>[/admin]<br><br>';
	}
	echo '<a href = "logout.php">Log out</a>';

} else {
	include 'login.php';
}

?>