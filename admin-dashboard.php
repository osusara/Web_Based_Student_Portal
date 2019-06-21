<?php session_start() ?>
<?php require_once('includes/connection.php') ?>
<?php require_once('includes/functions.php') ?>
<?php
    
    // check if user is logged in
    if(!isset($_SESSION['admin_id'])){
        header('Location: admin-login.php');
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

	<title>Admin Dashboard</title>
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
                        <li class="nav-item"><a class="nav-link" href="admin-registration.php">Admin Registration</a></li>
                        <li class="nav-item"><a class="btn btn-secondary btn-block" href="admin-logout.php">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>

        <div class="container-fluid padding text-center">
            <div class="row">

                <div class="col-sm-12 col-md-3 mx-auto">
                    <div class="card card-signin my-5">
                        <img src="assets/student.jpg" class="card-img-top" alt="Student Image">
                        <div class="card-body">
                            <a class="btn btn-primary btn-block text-uppercase" href="student-details.php">Students Manager</a>
                            <a class="btn btn-secondary btn-block text-uppercase" href="student-registration.php">Add Student</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 mx-auto">
                    <div class="card card-signin my-5">
                        <img src="assets/teacher.jpg" class="card-img-top" alt="Teacher Image">
                        <div class="card-body">
                            <a class="btn btn-primary btn-block text-uppercase" href="teacher-details.php">Teachers Manager</a>
                            <a class="btn btn-secondary btn-block text-uppercase" href="teacher-registration.php">Add Teacher</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 mx-auto">
                    <div class="card card-signin my-5">
                        <img src="assets/subject.jpg" class="card-img-top" alt="Subject Image">
                        <div class="card-body">
                            <a class="btn btn-primary btn-block text-uppercase" href="subject-details.php">Subjects Manager</a>
                            <a class="btn btn-secondary btn-block text-uppercase" href="subject-registration.php">Add Subject</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

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