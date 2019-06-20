<?php session_start() ?>
<?php require_once('includes/connection.php') ?>
<?php require_once('includes/functions.php') ?>
<?php 

	// check for submission
	if(isset($_POST['student-submit'])){

		$errors = array();

		// check if email and password entered
		if(!isset($_POST['student-email']) || strlen(trim($_POST['student-email'])) < 1){
			$errors[] = 'Email can not be empty';
		}

		if(!isset($_POST['student-password']) || strlen(trim($_POST['student-password'])) < 1){
			$errors[] = 'Password can not be empty';
		}

		// check if there are no any error in the form
		if(empty($errors)){

			// sanitize and save values to variables
			$email = mysqli_real_escape_string($connection, $_POST['student-email']);
			$password = mysqli_real_escape_string($connection, $_POST['student-password']);
			$hashed_password = sha1($password); // encrypt the password

			// database query
			$query = "SELECT * FROM student WHERE email='{$email}' AND password='{$hashed_password}' LIMIT 1";
			$result = mysqli_query($connection, $query);

			// call the function to verify the qurey
			verify_query($result);

			// when query is success
			if(mysqli_num_rows($result) == 1){

				// valid student found
				$student = mysqli_fetch_assoc($result);
				$_SESSION['student_id'] = $student['student_id'];
				$_SESSION['student_name'] = $student['name'];

				// update last login
				$query = "UPDATE student SET last_login = NOW() WHERE student_id = {$_SESSION['student_id']} LIMIT 1";
				$result = mysqli_query($connection, $query);

				verify_query($result);

				// redirect to student's home
				header('Location: student-dashboard.php');
			}else{

				// email/password incorrect
				$errors[] = 'Email or Password is incorrect';
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

    <title>Student Login</title>
</head>
<body>

	<header>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
			<div class="container-fluid">
            	<a class="navbar-brand" href="index.php">STUDENT PORTAL</a>
            	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-responsive" aria-controls="navbar-responsive"aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
            	</button>

            	<div class="collapse navbar-collapse" id="navbar-responsive">
                	<ul class="navbar-nav ml-auto">
                    	<li class="nav-item"><a class="nav-link btn" href="index.php">Back</a></li>
                	</ul>
            	</div>
        	</div>
		</nav>
	</header>

	<div class="container padding text-center">
		<div class="row">

			<div class=" col-sm-12 col-md-4 mx-auto">
				<div class="card card-signin my-5">
					<div class="card-body">
						<h3 class="card-title text-center">Student Login</h3>
						<form action="student-login.php" method="post">
							<div class="form-group">
					    		<input type="email" class="form-control" id="" aria-describedby="emailHelp" name="student-email" placeholder="Enter Email">
					    	</div>
					    	<div class="form-group">
								<input type="password" id="" name="student-password" class="form-control" aria-describedby="passwordHelpBlock"  placeholder="Enter Password">
					    	</div>
 						   	
 						   	<div class="form-group">
 						 		<?php
 				  					// Display errors
 					       			if(isset($errors) && !empty($errors)){
 						   				echo '<div class="alert alert-danger" role="alert">';
 				       					echo '<p class="error">'.$errors[0].'</p>';
 				       					echo '</div';
 			    					}
   					     		?>
        					</div>
        					<button type="submit" class="btn btn-primary btn-block text-uppercase" name="student-submit">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer class="footer">
        <div class="container-fluid padding bg-dark text-light">
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