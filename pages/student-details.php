<?php session_start() ?>
<?php require_once('../includes/connection.php') ?>
<?php require_once('../includes/functions.php') ?>

<?php

    // Check if a user logged in
    if(!isset($_SESSION['admin_id'])){
        header('Location: admin-login.php');
    }

    // Student list
    $student_list = '';

    // Getting the list of users
    $query = "SELECT * FROM student WHERE is_deleted=0 ORDER BY student_id";
    $students = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($students);

    while($student = mysqli_fetch_assoc($students)){
        $student_list .= "<tr>";
        $student_list .= "<th scope=\"row\">{$student['student_id']}</th>";
        $student_list .= "<td>{$student['name']}</td>";
        $student_list .= "<td>{$student['address']}</td>";
        $student_list .= "<td>{$student['phone']}</td>";
        $student_list .= "<td>{$student['email']}</td>";
        $student_list .= "<td>{$student['last_login']}</td>";
        $student_list .= "<td><a href=\"student-edit.php?student_id={$student['student_id']}\" class=\"btn btn-warning\">Edit</a></td>";
        $student_list .= "</tr>";
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

	<title>Admin Dashboard</title>
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
                        <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Back</a></li>
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
                    <h1 class="display-4">Students Details</h1>
                    <hr>
                </div>
            </div>
        </div>

        <div class="container-fluid padding py-4">
            <div class="row">
                <div class="col-md-10 col-sm-12 mx-auto">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th> 
                                <th scope="col">Email</th> 
                                <th scope="col">Last Login</th> 
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $student_list ?>
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