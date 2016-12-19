<?php

$connect_error = 'Could not connect!';

if(!$conn = pg_connect("host=localhost port=5432 dbname=shirabe user=postgres password=securepassword")){
	die($connect_error);
} else{
	
}

?>
