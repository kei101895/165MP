<?php

require 'connect.php';
require 'core.php';

?>

<html>
<a href = "index.php">Back</a>

<table width = "300" border = "1" cellpadding = "1" cellspacing = "1">

<?php
$query = 'SELECT id, name FROM consoles;';
$query_run = pg_query($conn, $query);
while ($product = pg_fetch_assoc($query_run)){
	echo '<tr>';
	echo "<td align=\"center\">".$product['name']."</td>";
	echo "<td align=\"center\"> <form action=\"edit_product_details.php\" method=\"POST\">
	<input type=\"hidden\" name=\"id\" value=\"".$product['id']."\">
	<input type = \"submit\" value=\"Edit\">
	</form>";
	echo '<tr>';
}
?>

</html>