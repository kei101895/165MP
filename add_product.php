<?php

require 'connect.php';
require 'core.php';

if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['available'])){

	$name = $_POST['name'];
	$description = $_POST['description'];
	$number_available = $_POST['available'];
	$check_exists = false;

	if(!empty($name) && !empty($description) && !empty($number_available)){
		$query = "SELECT name, id FROM consoles;";
		$console_id = 1;
		if ($query_run = pg_query($conn, $query)){
			while ($existing_product = pg_fetch_assoc($query_run)){
				if ($existing_product['name'] == $name){
					$check_exists = true;
					break;
				}
				$console_id = $console_id + 1;
			}
			if ($check_exists){
				echo 'Product already exists! Please try again.';
			} else{
				$query = "INSERT INTO consoles VALUES (".$console_id.", '".$name."', '".$description."', 'AVAILABLE',".$number_available.");";
				if (pg_query($conn, $query)){
					echo 'Successfully added '.$name.' to products!';
				}
			}
		}
		
	} else{
		echo 'Please fill in all details!';
	}
	
}

?>

<a href = "index.php">Back</a>

<form action="<?php echo $current_file; ?>" method="POST"> <br>
Name: <input type="text" name="name">
<br><br> Description: <br> <textarea name="description" cols="35" rows="3" maxlength="50"></textarea>
<br><br> Number available: <input type="number" name="available" min = "1">
<br><br> <input type = "submit" value="Add product">

</form>