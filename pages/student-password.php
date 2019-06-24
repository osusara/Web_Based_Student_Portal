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

	// EDIT STUDENT PASSWORD
	// Check if the form is submited
	if(isset($_POST['submit'])){

		$student_id = $_POST['student_id'];
		$password = $_POST['password'];
		$password_confirm = $_POST['password_confirm'];

		// Checking required fields
		$req_fields = array('student_id', 'password', 'password_confirm');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// Checking max length
		$max_len_fields = array('password' => 45);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// Cheking the password confirmation
    	if($password != $password_confirm){
    		$errors[] = "Password is not match with the confirmation";
    	}

		// If no error
		if(empty($errors)){

			// record add to the table
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$password_confirm = mysqli_real_escape_string($connection, $_POST['password_confirm']);
			$hashed_password = sha1($password);

			$query = "UPDATE student SET
						password = '{$hashed_password}'
						WHERE student_id = {$student_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if($result){
				header('Location: student-details.php?user_password_edit=true');
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
            	<a class="navbar-brand" href="../index.php">STUDENT PORTAL</a>
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
						<h3 class="card-title text-center">Update Student Password</h3>
						<form action="student-password.php" method="post">
							<div class="form-row">
								<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
								<div class="form-group col-md-12">
									<label for="name">Full Name</label>
									<input type="text" name="full_name" class="form-control" <?php echo 'value="'.$name.'"'; ?> disabled>
								</div>
								<div class="form-group col-md-12">
									<label for="address">Address</label>
									<input type="text" name="address" class="form-control" <?php echo 'value="'.$address.'"'; ?> disabled>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control" <?php echo 'value="'.$email.'"'; ?> disabled>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="phone">Phone</label>
									<input type="text" name="phone" class="form-control" <?php echo 'value="'.$phone.'"'; ?> disabled>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label for="password">New Password</label>
									<input type="password" id="password" name="password" class="form-control">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label for="password">Password Confirm</label>
									<input type="password" id="password" name="password_confirm" class="form-control">
								</div>

								<div class="form-group col-sm-12 col-md-12">
    								<div class="form-check">
      									<input class="form-check-input" id="showpassword" name="showpassword" type="checkbox" id="showpassword">
      									<label class="form-check-label" for="gridCheck">Show Password</label>
    								</div>
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
							<button type="submit" class="btn btn-primary text-uppercase btn-block" name="submit">Change Password</button>
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

    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
    	
    	    $(document).ready(function(){
            $('#showpassword').click(function(){
                if($('#showpassword').is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
            });
        });

    </script>
</body>
</html>

<?php mysqli_close($connection) ?>