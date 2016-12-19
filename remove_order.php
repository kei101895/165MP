<?php

require 'connect.php';
require 'core.php';

if (isset($_POST['name']) && isset($_POST['quantity'])) {
	$name = $_POST['name'];
	$quantity = $_POST['quantity'];
	$query = "DELETE FROM temp_order_details WHERE product_name = '".$name."' AND quantity = ".$quantity.";";
	//$query = "DELETE FROM temp_order_details WHERE product_name = '".$name."' AND quantity = ".$quantity." LIMIT 1;";
	//$query = "DELETE FROM temp_order_details WHERE product_name = '".$name."' AND quantity = ".$quantity." AND ctid IN (SELECT ctid FROM logtable LIMIT 1);";
	if (pg_query($conn, $query)){
		header('Location: '.$http_referer);
	}

}

?>