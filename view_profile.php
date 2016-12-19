<?php

require 'connect.php';
require 'core.php';

echo '<a href = "index.php">Home</a> <br> <br>';

$query = "SELECT username FROM users WHERE id = ".$_SESSION['user_id'].";";
if ($query_run = pg_query($conn, $query)){
	$username = pg_fetch_result($query_run, 0, 'username');
}

echo "Hello, ".$username.". "; 
echo '<a href = "change_username.php">Change username</a>';

?>

<h3> Order history: </h3>

<table width = "600" border = "1" cellpadding = "1" cellspacing = "1">

<tr>

<th>Order ID</th>
<th>Product</th>
<th>Quantity</th>

<tr>

<?php
$query = "SELECT order_id FROM orders WHERE user_id = ".$_SESSION['user_id'].";";
$query_run = pg_query($conn, $query);
while ($query_result = pg_fetch_assoc($query_run)) {
	$order_id = $query_result['order_id'];
	$query_2 = "SELECT * FROM order_details WHERE order_id = ".$order_id.";";
	$query_run_2 = pg_query($conn, $query_2);
	while ($query_result_2 = pg_fetch_assoc($query_run_2)){
	
		echo "<tr>";
		
		echo "<td align=\"center\"> ".$query_result_2['order_id']."</td>";
		echo "<td align=\"center\">".$query_result_2['product_name']."</td>";
		echo "<td align=\"center\">".$query_result_2['quantity']."</td>";
		
		echo "<tr>";
		
	}

}
?>

</table>