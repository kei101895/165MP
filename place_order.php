<?php

require 'connect.php';
require 'core.php';

$query_temp = "SELECT * from temp_order_details;";
if ($query_temp_run = pg_query($conn, $query_temp)){
	while ($order = pg_fetch_assoc($query_temp_run)){
		$query = "INSERT INTO order_details VALUES (".$order['order_id'].", '".$order['product_name']."', ".$order['quantity'].");";
		pg_query($query);
		
		$query = "SELECT name, number_available FROM consoles WHERE name = '".$order['product_name']."';";
		$query_run = pg_query($conn, $query);
		$new_available = pg_fetch_result($query_run, 0, 'number_available') - $order['quantity'];
		$query = "UPDATE consoles SET number_available = ".$new_available." WHERE name = '".pg_fetch_result($query_run, 0, 'name')."';";
		pg_query($conn, $query);
		$query = "UPDATE consoles SET status = CASE WHEN number_available > 0 THEN 'AVAILABLE' ELSE 'UNAVAILABLE' END;";
		pg_query($conn, $query);
		$order_id = $order['order_id'];
		
	}
	$query = "INSERT INTO orders VALUES (".$order_id.", ".$_SESSION['user_id'].");";
	if (pg_query($conn, $query)){
		echo '<h3> Successful order! yay </h3> <br>';
		echo "<a href = \"index.php\">Home</a>";
	}
}

?>