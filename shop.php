<?php
require 'connect.php';
require 'core.php';
?>

<a href = "index.php">Back</a>

<?php

$query = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1;";
if ($query_run = pg_query($conn, $query)){
	$query_rows = pg_num_rows($query_run);
	
	if ($query_rows == 0){
		$order_id = 1;
	} else if ($query_rows == 1) {
		$order_id = pg_fetch_result($query_run, 0, 'order_id') + 1;
	}
		
}

if (isset($_POST['quantity'])) {
	if (!empty($_POST['quantity'])) {
		if(!($_POST['quantity'] > $_POST['available'])){
			
			$temp_query = "INSERT INTO temp_order_details VALUES (".$order_id.", '".$_POST['name']."', ".$_POST['quantity'].");";
			pg_query($temp_query);
			
			echo '<br>';

		} else {
			echo 'Not enough of the product! Lower the quantity.';
		}
		
	} else{
		echo 'Please supply a quantity before clicking "Add to cart".';
	}
	
}

$query = "SELECT * FROM temp_order_details;";
if ($query_run = pg_query ($conn, $query)){
	$query_rows = pg_num_rows($query_run);
	
	if ($query_rows > 0){
		echo "<h3> CART: </h3>";
		echo "<table width = \"400\" border = \"1\" cellpadding = \"1\" cellspacing = \"1\">";
		echo "<tr>";

		echo "<th>Product</th>";
		echo "<th>Quantity</th>";
		echo "<th> </th>";
		
		echo "<tr>";
		
		while ($temp_order = pg_fetch_assoc($query_run)) {
			echo "<tr>";
			echo "<td align=\"center\"> ".$temp_order['product_name']."</td>";
			echo "<td align=\"center\"> ".$temp_order['quantity']."</td>";
			echo "<td align=\"center\">
			<form action=\"remove_order.php\" method=\"POST\">
			<input type = \"hidden\" name=\"name\" value=\"".$temp_order['product_name']."\">
			<input type = \"hidden\" name=\"quantity\" value=\"".$temp_order['quantity']."\">
			<input type = \"submit\" value=\"Remove\">
			</form> </td>";
			echo "<tr>";
		}
		
		echo "</table>";
		
		echo "<form action=\"place_order.php\" method=\"POST\">
			<input type = \"submit\" value=\"Place order\">
			</form>";
		
	} else {
		echo '<br>No items in cart. <br>';
	}
}




?>

<table width = "800" border = "1" cellpadding = "1" cellspacing = "1">

<tr>

<th>Product</th>
<th>Description</th>
<th>Status</th>
<th>Number available</th>
<th> </th>

<tr>
<?php
$query = "SELECT * FROM consoles;";
$query_run = pg_query($conn, $query);
while ($product = pg_fetch_assoc($query_run)) {

	if ($product['status'] == 'AVAILABLE'){

		echo "<tr>";
		
		echo "<td align=\"center\"> ".$product['name']."</td>";
		echo "<td align=\"center\">".$product['description']."</td>";
		echo "<td align=\"center\">".$product['status']."</td>";
		echo "<td align=\"center\">".$product['number_available']."</td>";
		
		echo "<td align=\"center\" width=\"15%\"> 
		<form action=\"".$current_file."\" method=\"POST\">
		Quantity: <input type=\"number\" name=\"quantity\" min = \"1\" max ".$product['number_available'].">
		<input type=\"hidden\" name=\"id\" value=\"".$product['id']."\">
		<input type=\"hidden\" name=\"name\" value=\"".$product['name']."\">
		<input type=\"hidden\" name=\"available\" value=\"".$product['number_available']."\">
		<input type = \"submit\" value=\"Add to cart\">
		</form>";
		
		echo "<tr>";
		
	}

}
?>

</table>