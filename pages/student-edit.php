<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>

<?php

	// Check if a user logged in
	if(!isset($_SESSION['admin_id'])){
		header('Location: admin-login.php');
	}

	$errors = array();

	$student_id = '';
	$name = '';
	$address = '';
	$phone = '';
	$email = '';

	// VIEW STUDENT
	// Check if the student_id is set
	if(isset($_GET['student_id'])){

		// Get student information
		$student_id = mysqli_real_escape_string($connection, $_GET['student_id']);
		$query = "SELECT * FROM student WHERE student_id = {$student_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if($result_set){
			if(mysqli_num_rows($result_set) == 1){

				// Student found
				$result = mysqli_fetch_assoc($result_set);
				$name = $result['name'];
				$address = $result['address'];
				$phone = $result['phone'];
				$email = $result['email'];
			}else{

				// Student not found
				header('Location: student-details.php?err=not_found');
			}
		}else{

			// Query failed
			header('Location: student-details.php?err=query_failed');
		}
	}

	// EDIT STUDENT
	// Check if the form is submited
	if(isset($_POST['submit'])){

		$student_id = $_POST['student_id'];
		$name = $_POST['full_name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];

		// Checking required fields
		$req_fields = array('student_id', 'full_name', 'address', 'phone', 'email');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// Checking max length
		$max_len_fields = array('full_name' => 45, 'address' => 45, 'phone' => 45, 'email' => 45);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// Checking validation of email
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = 'Email is not valid';
		}

		// Checking if email already exist
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM student WHERE email = {$email} AND student_id != {$student_id} LIMIT 1";

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
			$address = mysqli_real_escape_string($connection, $_POST['address']);
			$phone = mysqli_real_escape_string($connection, $_POST['phone']);

			$query = "UPDATE student SET
						name = '{$name}',
						address = '{$address}',
						phone = '{$phone}',
						email = '{$email}'
						WHERE student_id = {$student_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if($result){
				header('Location: student-details.php?user_edit=true');
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

	<title>Edit Student</title>
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
                		<li class="nav-item"><a class="nav-link" href="student-details.php">Back</a></li>
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
					<img src="../assets/student.jpg" class="card-img-top" alt="Student Image">
					<div class="card-body">
						<h3 class="card-title text-center">Update Student Details</h3>
						<form action="student-edit.php" method="post">
							<div class="form-row">
								<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
								<div class="form-group col-md-12">
									<label for="name">Full Name</label>
									<input type="text" name="full_name" class="form-control" <?php echo 'value="'.$name.'"'; ?> placeholder="Enter full name">
								</div>
								<div class="form-group col-md-12">
									<label for="address">Address</label>
									<input type="text" name="address" class="form-control" <?php echo 'value="'.$address.'"'; ?> placeholder="Enter permenant address">
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
									<a href="student-password.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary btn-block">Change Password</a>
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