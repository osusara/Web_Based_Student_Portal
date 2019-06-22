<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>
<?php

	// check if user is logged in
	if(!isset($_SESSION['admin_id'])){
		header('Location: admin-login.php');
	}

	// teacher list
    $teacher_list = '';

    // Getting the list of users
    $query = "SELECT * FROM teacher WHERE is_deleted=0 ORDER BY teacher_id";
    $teachers = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($teachers);

    while($teacher = mysqli_fetch_assoc($teachers)){
        $teacher_list .= "<tr>";
        $teacher_list .= "<th scope=\"row\">{$teacher['teacher_id']}</th>";
        $teacher_list .= "<td>{$teacher['name']}</td>";
        $teacher_list .= "<td>{$teacher['phone']}</td>";
        $teacher_list .= "<td>{$teacher['email']}</td>";
        $teacher_list .= "</tr>";
    }

    // Subject registration process
	$errors = array();

	$name = '';
	$teacher_id = '';

	// check if the form is submitted
	if(isset($_POST['submit'])){
		$name = $_POST['subject_name'];
		$teacher_id = $_POST['teacher_id'];

		// checking required fields
		$req_fields = array('subject_name', 'teacher_id',);
		$errors = array_merge($errors, check_req_fields($req_fields));

    	if(empty($errors)){
            // If no error record adds to to the table
            $name = mysqli_real_escape_string($connection, $_POST['subject_name']); // Sanitizing subject_name
            $teacher_id = mysqli_real_escape_string($connection, $_POST['teacher_id']); // Sanitizing teacher_id

            $query = "INSERT INTO subject
                     (name, teacher_id, is_deleted) VALUES
                     ('{$name}', '{$teacher_id}', 0)";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: subject-registration.php?subject_add=true');
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

	<title>Add Subjects</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
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
					<div class="card-body">
						<h3 class="card-title text-center">Add Subject</h3>
						<form action="subject-registration.php" method="post">
							<div class="form-row">
								<div class="form-group col-md-9">
									<label for="name">Subject Name</label>
									<input type="text" name="subject_name" class="form-control" <?php echo 'value="'.$name.'"'; ?> placeholder="Enter subject name">
								</div>
								<div class="form-group col-sm-12 col-md-3">
									<label for="teacher_id">Teacher ID</label>
									<input type="text" name="teacher_id" class="form-control" <?php echo 'value="'.$teacher_id.'"'; ?> placeholder="Enter ID">
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
							</div>
							<button type="submit" class="btn btn-primary text-uppercase btn-block" name="submit">Add Subject</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid padding py-4">
            <div class="row">
                <div class="col-md-10 col-sm-12 mx-auto">
                    <h5>Teachers Details</h5>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Teacher ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Phone</th> 
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $teacher_list ?>
                        </tbody>
                    </table>
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

<?php mysqli_close($connection) ?>