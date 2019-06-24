<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>
<?php

	// check if user is logged in
	if(!isset($_SESSION['admin_id'])){
		header('Location: admin-login.php');
	}

	$errors = array();

	$name = '';
	$phone = '';
	$email = '';
	$password = '';
	$password_confirm = '';

	// check if the form is submitted
	if(isset($_POST['submit'])){
		$name = $_POST['full_name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_confirm = $_POST['password_confirm'];

		// checking required fields
		$req_fields = array('full_name', 'email', 'phone', 'password', 'password_confirm');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// check validity of email
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    	    $errors[] = 'Email is not valid';
    	}

    	// Checking if email already exist
    	$email = mysqli_real_escape_string($connection, $_POST['email']); // Sanitizing email
    	$query = "SELECT * FROM admin WHERE email = '{$email}' LIMIT 1";

    	$result_set = mysqli_query($connection, $query);

    	if($result_set){
    	    if(mysqli_num_rows($result_set) == 1){
    	        $errors[] = 'Email is already exist';
    	    }
    	}

    	// Cheking the password confirmation
    	if($password != $password_confirm){
    		$errors[] = "Password is not match with the confirmation";
    	}

    	if(empty($errors)){
            // If no error record adds to to the table
            $name = mysqli_real_escape_string($connection, $_POST['full_name']); // Sanitizing full_name
            $phone = mysqli_real_escape_string($connection, $_POST['phone']); // Sanitizing phone
            $email = mysqli_real_escape_string($connection, $_POST['email']); // Sanitizing email
            $password = mysqli_real_escape_string($connection, $_POST['password']); // Sanitizing password
            $hashed_password = sha1($password);

            $query = "INSERT INTO admin
                     (email, password, phone, name, last_login, is_deleted) VALUES
                     ('{$email}', '{$hashed_password}', '{$phone}', '{$name}', NOW(), 0)";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: admin-dashboard.php?admin_add=true');
            }else{
                $errors[] = 'Failed to add the new record';
            }
        }
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/styles.css">

	<title>Admin Registration</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
			<div class="container-fluid">
            	<a class="navbar-brand" href="../index.php">STUDENT PORTAL</a>
            	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-responsive" aria-controls="navbar-responsive"aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
            	</button>

            	<div class="collapse navbar-collapse" id="navbar-responsive">
                	<ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Back</a></li>
                    	<li class="nav-item"><a class="btn btn-secondary btn-block" href="logout.php">Log Out</a></li>
                	</ul>
            	</div>
        	</div>
		</nav>
	</header>

	<main class="container padding">
		<div class="row">
			<div class="col-sm-12 col-md-6 mx-auto">
				<div class="card card-signin my-5">
					<img src="../assets/admin.jpg" class="card-img-top" alt="Student Image">
					<div class="card-body">
						<h3 class="card-title text-center">Admin Registration</h3>
						<form action="admin-registration.php" method="post">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name">Full Name</label>
									<input type="text" name="full_name" class="form-control" <?php echo 'value="'.$name.'"'; ?> placeholder="Enter full name">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="name">Email</label>
									<input type="email" name="email" class="form-control" <?php echo 'value="'.$email.'"'; ?> placeholder="Enter email address">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="phone">Phone</label>
									<input type="text" name="phone" class="form-control" <?php echo 'value="'.$phone.'"'; ?> placeholder="Enter phone number">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="phone">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Enter new password">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="phone">Confirm</label>
									<input type="password" name="password_confirm" class="form-control" placeholder="Confirm the password">
								</div>

								<div class="form-group">
 							 		<?php
 					  					// Display errors
 						       			if(isset($errors) && !empty($errors)){
 						       				echo '<div class="alert alert-danger" role="alert">';
 				       						echo '<p class="error">'.$errors[0].'</p>';
 				       						echo '</div>';
 			    						}
   					     			?>
        						</div>
							</div>
							<button type="submit" class="btn btn-primary text-uppercase btn-block" name="submit">Sign Up</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>

	<footer class="footer">
        <div class="container-fluid padding bg-light">
            <div class="row text-center">
                <div class="col-12 pt-3">
                    <p>&copy; 2019 Student Portal</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

<?php mysqli_close($connection) ?>