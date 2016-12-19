<?php

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($username) && !empty($password)){
	
		$password_hash = md5($password);
		
		$query = "SELECT id FROM users WHERE username = '".$username."' AND password = '".$password_hash."';";
		if ($query_run = pg_query($conn, $query)){
			$query_rows = pg_num_rows($query_run);
			if ($query_rows == 0){
				echo 'Invalid username/password combination.';
			} else if($query_rows == 1) {
				$user_id = pg_fetch_result($query_run, 0, 'id');
				$_SESSION['user_id'] = $user_id;
				header('Location: index.php');
			}
		} 
		
	} else{
		echo 'Please fill up all fields.';
	}
}

?>

<h3> Welcome to this very simple database program :D yay</h3>

<form action="<?php echo $current_file; ?>" method="POST">
Username: <input type="text" name="username">
Password: <input type="password" name="password">
<input type = "submit" value="Log in">

</form>