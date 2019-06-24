<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>

<?php

	// Check if a user logged in
	if(!isset($_SESSION['admin_id'])){
		header('Location: admin-login.php');
	}

	$errors = array();

	$admin_id = '';
	$name = '';
	$phone = '';
	$email = '';

	// VIEW ADMIN
	// Check if the student_id is set
	if(isset($_GET['admin_id'])){

		// Get admin information
		$admin_id = mysqli_real_escape_string($connection, $_GET['admin_id']);
		$query = "SELECT * FROM admin WHERE admin_id = {$admin_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if($result_set){
			if(mysqli_num_rows($result_set) == 1){

				// admin found
				$result = mysqli_fetch_assoc($result_set);
				$name = $result['name'];
				$phone = $result['phone'];
				$email = $result['email'];
			}else{

				// admin not found
				header('Location: admin-details.php?err=not_found');
			}
		}else{

			// Query failed
			header('Location: admin-details.php?err=query_failed');
		}
	}

	// EDIT admin
	// Check if the form is submited
	if(isset($_POST['submit'])){

		$admin_id = $_POST['admin_id'];
		$name = $_POST['full_name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];

		// Checking required fields
		$req_fields = array('admin_id', 'full_name', 'phone', 'email');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// Checking max length
		$max_len_fields = array('full_name' => 45, 'phone' => 45, 'email' => 45);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// Checking validation of email
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = 'Email is not valid';
		}

		// Checking if email already exist
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM admin WHERE email = {$email} AND admin_id != {$admin_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if($result_set){
			if(mysqli_num_rows($result_set) == 1){
				$errors[] = "Email is already exist";
			}
		}

		// If no error
		if(empty($errors)){

			// record add to the table
			$name = mysqli_real_escape_string($connection, $_POST['full_name']);
			$phone = mysqli_real_escape_string($connection, $_POST['phone']);

			$query = "UPDATE admin SET
						name = '{$name}',
						phone = '{$phone}',
						email = '{$email}'
						WHERE admin_id = {$admin_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if($result){
				header('Location: admin-details.php?admin_edit=true');
			}else{
				$errors[] = 'Failed to edit the record';
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

	<title>Edit Admin</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
			<div class="container-fluid">
            	<a class="navbar-brand" href="../index.html">STUDENT PORTAL</a>
            	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-responsive" aria-controls="navbar-responsive"aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
            	</button>

            	<div class="collapse navbar-collapse" id="navbar-responsive">
                	<ul class="navbar-nav ml-auto">
                		<li class="nav-item"><a class="nav-link" href="admin-details.php">Back</a></li>
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
						<h3 class="card-title text-center">Update Admin Details</h3>
						<form action="admin-edit.php" method="post">
							<div class="form-row">
								<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
								<div class="form-group col-md-12">
									<label for="name">Full Name</label>
									<input type="text" name="full_name" class="form-control" <?php echo 'value="'.$name.'"'; ?> placeholder="Enter full name">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control" <?php echo 'value="'.$email.'"'; ?> placeholder="Enter email address">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="phone">Phone</label>
									<input type="text" name="phone" class="form-control" <?php echo 'value="'.$phone.'"'; ?> placeholder="Enter phone number">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<a href="admin-password.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-secondary btn-block">Change Password</a>
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
							<button type="submit" class="btn btn-primary text-uppercase btn-block" name="submit">Save Updates</button>
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