<?php

    $messege = '';

    if(isset($_GET['logout'])){
        if($_GET['logout'] == 'yes'){
            $messege = 'Logout successfully';
        }
    }

    if(isset($_GET['system_setup'])){
        if($_GET['system_setup'] == 'true'){
            $messege = 'System successfully installed';
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

    <link rel="stylesheet" type="text/css" href="css/styles.css">

	<title>Welcome Page</title>
</head>
<body>
    <header>
        <div class="container-fluid text-center bg-light py-1">
            <h1 class=" display-2">STUDENT PORTAL</h1>
            <?php
                // Display messege
                if(isset($messege)){
                    echo '<h2 class="badge badge-pill badge-success">'.$messege.'</h2>';
                }
            ?>
        </div>
    </header>

	<div class="container-fluid padding text-center">
		<div class="row">

			<div class="col-sm-12 col-md-4 mx-auto">
				<div class="card card-signin my-5">
					<img src="assets/student.jpg" class="card-img-top" alt="Student Login Image">
					<div class="card-body">
						<p class="card-title text-center">Click here if you are a student</p>
						<a class="btn btn-primary btn-block text-uppercase" href="pages/student-login.php">Login as a Student</a>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4 mx-auto">
				<div class="card card-signin my-5">
					<img src="assets/teacher.jpg" class="card-img-top" alt="Teacher Login Image">
					<div class="card-body">
						<p class="card-title text-center">Click here if you are a teacher</p>
						<a class="btn btn-primary btn-block text-uppercase" href="pages/teacher-login.php">Login as a Teacher</a>
					</div>
				</div>
			</div>

		</div>
	</div>

	<footer>
        <div class="container-fluid padding bg-light">
            <div class="row text-center">
                <div class="col-12">
                	<h5>Admin Controls</h5>
                    <p>Admin privileges are special kind of access to the system. Admin can add, view, update or delete Students, Teachers and Subjects.</p>
                    <a class="btn btn-secondary" href="pages/admin-login.php">Login as an Admin</a>
                </div>
                <div class="col-12">
                    <hr class="light-100 bg-light">
                    <p>&copy; 2019 Student Portal</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>