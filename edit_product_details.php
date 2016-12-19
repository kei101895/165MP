<a href = "edit_product.php">Back</a>
<a href = "index.php">Home</a>

<?php

require 'connect.php';
require 'core.php';

if(isset($_POST['id'])){
	if(isset($_POST['new_name']) && isset($_POST['new_description']) && isset($_POST['new_available'])){
		$id = $_POST['id'];
		$new_name = $_POST['new_name'];
		$new_description = $_POST['new_description'];
		$new_available = $_POST['new_available'];
		$query = "UPDATE consoles SET name = '".$new_name."', description = '".$new_description."', number_available = ".$new_available." WHERE id = ".$id.";";
		if ($query_run = pg_query($conn, $query)){
			echo "Successfully updated ".$new_name."!";
			$query = "UPDATE consoles SET status = CASE WHEN number_available > 0 THEN 'AVAILABLE' ELSE 'UNAVAILABLE' END;";
			pg_query($conn, $query);
		} else{
			echo pg_result_error();
		}
		
		
	} else{
		$query = "SELECT name, description, number_available FROM consoles WHERE id = ".$_POST['id'].";";
		if ($query_run = pg_query($conn, $query)){
			$name = pg_fetch_result($query_run, 0, 'name');
			$description = pg_fetch_result($query_run, 0, 'description');
			$number_available = pg_fetch_result($query_run, 0, 'number_available');
			
			echo "<form action=\"".$current_file."\" method=\"POST\"> <br>
				Name: <input type=\"text\" name=\"new_name\" value=\"".$name."\">
				<br><br> Description: <br> <textarea name=\"new_description\" cols=\"35\" rows=\"3\" maxlength=\"50\">".$description."</textarea>
				<br><br> Number available: <input type=\"number\" name=\"new_available\" min = \"1\" value=".$number_available.">
				<input type=\"hidden\" name=\"id\" value=\"".$_POST['id']."\">
				<br><br> <input type = \"submit\" value=\"Edit product\">

				</form>";

		}
	}
}

?>