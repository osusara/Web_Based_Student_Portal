<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>

<?php

	// Check if a result logged in
    if(!isset($_SESSION['student_id'])){
        header('Location: index.php');
    }

    // Getting Student details
    $id = $_SESSION['student_id'];
    $name = '';
    $address = '';
    $email = '';
    $phone = '';

    $query = "SELECT * FROM student WHERE student_id={$id} LIMIT 1";
    $result_set = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($result_set);

    $student = mysqli_fetch_assoc($result_set);
    $name = $student['name'];
    $address = $student['address'];
    $email = $student['email'];
    $phone = $student['phone'];

    // Getting the list of results
    $result_list = '';

    $query = "SELECT * FROM result WHERE student_id={$id} ORDER BY subject_id";
    $results = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($results);

    while($result = mysqli_fetch_assoc($results)){
    	$query = "SELECT * FROM subject WHERE subject_id = {$result['subject_id']} LIMIT 1";
    	$subject_set = mysqli_query($connection, $query);
    	$subject = mysqli_fetch_assoc($subject_set);

        $result_list .= "<tr>";
        $result_list .= "<th scope=\"row\">{$result['subject_id']}</th>";
        $result_list .= "<td>{$subject['name']}</td>";
        $result_list .= "<td>{$result['result']}</td>";
        $result_list .= "</tr>";
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

	<title>Student Dashboard</title>
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
                    	<li class="nav-item"><a class="btn btn-secondary btn-block" href="logout.php">Log Out</a></li>
                	</ul>
            	</div>
        	</div>
		</nav>
	</header>

	<main>
        <div class="container text-center">
            <div class="row">
                <div class="col-6 mx-auto pt-4">
                    <hr>
                    <h1 class="display-4">Student Dashboard</h1>
                    <hr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <div class="container padding">
                            <h1 class="card-title text-center py-4">Hi! There,</h1>
                            <table class="table">
                                <tr>
                                    <td>Student ID</td>
                                    <th><?php echo ' '.$id.''; ?></th>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <th><?php echo ' '.$name.''; ?></th>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <th><?php echo ' '.$address.''; ?></th>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <th><?php echo ' '.$email.''; ?></th>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <th><?php echo ' '.$phone.''; ?></th>
                                </tr>
                            </table>
                        </div>

                        <div class="col-sm-12 col-md-10">
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
                </div>
            </div>
        </div>

		<div class="container padding py-4">
			<div class="row">
				<div class="col-md-10 col-sm-12 mx-auto">
                    <h5>Results Sheet</h5>
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Subject ID</th>
								<th scope="col">Subject Name</th>
                				<th scope="col">Result</th>
							</tr>
						</thead>
						<tbody>
							<?php echo $result_list ?>
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