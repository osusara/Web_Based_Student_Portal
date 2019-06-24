<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>

<?php

	// Check if a user logged in
	if(!isset($_SESSION['admin_id'])){
		header('Location: admin-login.php');
	}

	$errors = array();

	$subject_id = '';
	$name = '';
	$teacher_id = '';

	// VIEW SUBJECT
	// Check if the subject_id is set
	if(isset($_GET['subject_id'])){

		// Get subject information
		$subject_id = mysqli_real_escape_string($connection, $_GET['subject_id']);
		$query = "SELECT * FROM subject WHERE subject_id = {$subject_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if($result_set){
			if(mysqli_num_rows($result_set) == 1){

				// subject found
				$result = mysqli_fetch_assoc($result_set);
				$name = $result['name'];
				$teacher_id = $result['teacher_id'];
			}else{

				// subject not found
				header('Location: subject-details.php?err=not_found');
			}
		}else{

			// Query failed
			header('Location: subject-details.php?err=query_failed');
		}
	}

	// EDIT SUBJECT
	// Check if the form is submited
	if(isset($_POST['submit'])){

		$subject_id = $_POST['subject_id'];
		$name = $_POST['name'];
		$teacher_id = $_POST['teacher_id'];

		// Checking required fields
		$req_fields = array('subject_id', 'name', 'teacher_id');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// Checking max length
		$max_len_fields = array('name' => 45, 'teacher_id' => 11);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// If no error
		if(empty($errors)){

			// record add to the table
			$name = mysqli_real_escape_string($connection, $_POST['name']);
			$teacher_id = mysqli_real_escape_string($connection, $_POST['teacher_id']);

			$query = "UPDATE subject SET
						name = '{$name}',
						teacher_id = '{$teacher_id}'
						WHERE subject_id = {$subject_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if($result){
				header('Location: subject-details.php?subject_edit=true');
			}else{
				$errors[] = 'Failed to edit the record';
			}
		}

	}

	// TEACHERS TABLE
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

	<title>Edit Subject</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
			<div class="container-fluid">
            	<a class="navbar-brand" href="../index.html">STUDENT PORTAL</a>
            	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-responsive" aria-controls="navbar-responsive"aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
            	</button>

            	<div class="collapse navbar-collapse" id="navbar-responsive">
                	<ul class="navbar-nav ml-auto">
                		<li class="nav-item"><a class="nav-link" href="subject-details.php">Back</a></li>
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
					<img src="../assets/subject.jpg" class="card-img-top" alt="Subject Image">
					<div class="card-body">
						<h3 class="card-title text-center">Update Subject Details</h3>
						<form action="subject-edit.php" method="post">
							<div class="form-row">
								<input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
								<div class="form-group col-md-9">
									<label for="name">Subject Name</label>
									<input type="text" name="name" class="form-control" <?php echo 'value="'.$name.'"'; ?> disabled>
								</div>
								<div class="form-group col-md-3">
									<label for="address">Techer ID</label>
									<input type="text" name="teacher_id" class="form-control" <?php echo 'value="'.$teacher_id.'"'; ?>>
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