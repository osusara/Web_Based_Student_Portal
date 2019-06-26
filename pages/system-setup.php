<?php

	// setting up the database
	$errors = array();

	$host = '';
	$username = '';
	$password = '';
	$name = '';

	// check if the form is submitted
	if(isset($_POST['submit'])){
		$host = $_POST['host'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$name = $_POST['name'];

		// checking required fields
		$req_fields = array('name', 'username', 'password', 'name');
		$errors = array_merge($errors, check_req_fields($req_fields));

    	if(empty($errors)){
            // If no error record adds to to the table
            $host = mysqli_real_escape_string($connection, $_POST['host']); // Sanitizing host
            $username = mysqli_real_escape_string($connection, $_POST['username']); // Sanitizing username
            $password = mysqli_real_escape_string($connection, $_POST['password']); // Sanitizing password
            $name = mysqli_real_escape_string($connection, $_POST['name']); // Sanitizing database name


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

	<title>System Setup</title>
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
                    	<li class="nav-item"><a class="nav-link" href="../index.php">Back</a></li>
                	</ul>
            	</div>
        	</div>
		</nav>
	</header>

	<main class="container padding">
        <div class="container text-center">
            <div class="row">
                <div class="col-6 mx-auto pt-4">
                    <hr>
                    <h1 class="display-4">System Setup</h1>
                    <hr>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-sm-12 col-md-6 mx-auto">
				<div class="card card-signin my-5">
					<div class="card-body">
						<form action="../include/connection.php" method="post">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Host</label>
									<input type="text" name="host" class="form-control" <?php echo 'value="'.$host.'"'; ?> placeholder="Enter Host Name" value="localhost">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label>Username</label>
									<input type="text" name="username" class="form-control" <?php echo 'value="'.$username.'"'; ?> placeholder="Enter Username" value="root">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label>Password</label>
									<input type="password" name="phone" class="form-control"  placeholder="Enter Password">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label>Database Name</label>
									<input type="text" name="name" class="form-control" <?php echo 'value="'.$name.'"'; ?> placeholder="Enter a New Database Name" value="student_portal">
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
							<button type="submit" class="btn btn-primary text-uppercase btn-block" name="submit">Setup Database</button>
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