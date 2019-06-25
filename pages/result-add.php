<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>

<?php

	// Check if a user logged in
	if(!isset($_SESSION['teacher_id'])){
		header('Location: teacher-login.php');
	}

	$errors = array();

	$student_id = '';
	$subject_id = '';
	$marks = '';

	$name = '';
	$address = '';
	$phone = '';
	$email = '';

	$subject_list = '';

	// GET SUBJECT IDS
	$query = "SELECT * FROM teacher WHERE teacher_id = {$_SESSION['teacher_id']} LIMIT 1";
    $teachers = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($teachers);

    $teacher = mysqli_fetch_assoc($teachers);
    $teacher_id = $teacher['teacher_id'];
    $query = "SELECT * FROM subject WHERE teacher_id = {$teacher_id}";
    $subjects = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($subjects);

    while($subject = mysqli_fetch_assoc($subjects)){
    	$subject_list .= "<tr>";
        $subject_list .= "<th scope=\"row\">{$subject['subject_id']}</th>";
        $subject_list .= "<td>{$subject['name']}</td>";
        $subject_list .= "</tr>";
    }

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
				header('Location: teacher-dashboard.php?err=not_found');
			}
		}else{

			// Query failed
			header('Location: teacher-dashboard.php?err=query_failed');
		}
	}

	// ADD RESULTS
	// Check if the form is submited
	if(isset($_POST['submit'])){

		$student_id = $_POST['student_id'];
		$subject_id = $_POST['subject_id'];
		$marks = $_POST['marks'];

		// Checking required fields
		$req_fields = array('student_id', 'subject_id', 'marks');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// Checking max length
		$max_len_fields = array('student_id' => 11, 'subject_id' => 11, 'marks' => 11);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// Check if the result is already exist
		$query = "SELECT * FROM result WHERE student_id = {$student_id} AND subject_id = {$subject_id} LIMIT 1";
		$result = mysqli_query($connection, $query);

		if(mysqli_num_rows($result) == 1){
			// If no error
			if(empty($errors)){

				// record add to the table
				$student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
				$subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);
				$marks = mysqli_real_escape_string($connection, $_POST['marks']);

				$query = "UPDATE result SET
						result = {$marks}
						WHERE student_id = {$student_id} AND subject_id = {$subject_id} LIMIT 1";

				$result_set = mysqli_query($connection, $query);

				if($result_set){
					header('Location: teacher-dashboard.php?results_added=true');
				}else{
					$errors[] = 'Failed to edit the record';
				}
			}
		}else{
			// If no error
			if(empty($errors)){

				// record add to the table
				$student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
				$subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);
				$marks = mysqli_real_escape_string($connection, $_POST['marks']);

				$query = "INSERT INTO result (subject_id, student_id, result)
						VALUES ({$subject_id}, {$student_id}, {$marks})";

				$result_set = mysqli_query($connection, $query);

				if($result_set){
					header('Location: teacher-dashboard.php?results_added=true');
				}else{
					$errors[] = 'Failed to edit the record';
				}
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
                		<li class="nav-item"><a class="nav-link" href="teacher-dashboard.php">Back</a></li>
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
						<h3 class="card-title text-center">Add Results</h3>
						<form action="result-add.php" method="post">
							<div class="form-row">
								<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
								<div class="form-group col-md-4">
									<label for="student id">Student ID</label>
									<input type="text" name="student_id" class="form-control" <?php echo 'value="'.$student_id.'"'; ?> disabled>
								</div>
								<div class="form-group col-md-4">
									<label for="subject ID">Subject ID</label>
									<input type="text" name="subject_id" class="form-control" <?php echo 'value="'.$subject_id.'"'; ?>>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="marks">Result</label>
									<input type="text" name="marks" class="form-control" <?php echo 'value="'.$marks.'"'; ?>>
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
							<button type="submit" class="btn btn-primary text-uppercase btn-block" name="submit">Add Results</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid padding py-4">
            <div class="row">
                <div class="col-md-10 col-sm-12 mx-auto">
                    <h5>Your Subject(s) List</h5>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Subject ID</th>
                                <th scope="col">Subject Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $subject_list ?>
                        </tbody>
                    </table>
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