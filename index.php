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
        <div class="container-fluid text-center bg-dark py-1">
            <h1 class="text-light">STUDENT PORTAL</h1>
        </div>
    </header>

	<div class="container-fluid padding text-center">
		<div class="row">

			<div class="col-sm-12 col-md-4 mx-auto">
				<div class="card card-signin my-5">
					<img src="assets/student.jpg" class="card-img-top" alt="Student Login Image">
					<div class="card-body">
						<p class="card-title text-center">Click here if you are a student</p>
						<a class="btn btn-primary btn-block text-uppercase" href="student-login.php">Login as a Student</a>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4 mx-auto">
				<div class="card card-signin my-5">
					<img src="assets/teacher.jpg" class="card-img-top" alt="Teacher Login Image">
					<div class="card-body">
						<p class="card-title text-center">Click here if you are a teacher</p>
						<a class="btn btn-primary btn-block text-uppercase" href="teacher-login.php">Login as a Teacher</a>
					</div>
				</div>
			</div>

		</div>
	</div>

	<footer>
        <div class="container-fluid padding bg-dark text-light">
            <div class="row text-center">
                <div class="col-md-4 py-3">
                	<h5>Admin Controls</h5>
                    <p>Admin privileges are special kind of access to the system. Admin can add, view, update or delete Students, Teachers and Subjects.</p>
                    <a class="btn btn-secondary" href="admin-login.php">Login as an Admin</a>
                </div>

                <div class="col-md-4 py-3">
                    <h5>Setup The System</h5>
                    <p>When the first use, the system must setup. This will create the database and create the environment for the system.</p>
                    <a class="btn btn-secondary" href="admin-login.php">System Setup</a>
                </div>
                
                <div class="col-md-4 py-3">
                    
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