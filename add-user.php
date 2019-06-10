<?php session_start(); ?>
<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/functions.php'); ?>

<?php
    
    // Check if a user logged in
    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
    }
    
    $errors = array();

    $first_name = '';
    $last_name = '';
    $email = '';

    // Check if the form is submited
    if(isset($_POST['submit'])){

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        // Checking required fields
        $req_fields = array('first_name', 'last_name', 'email', 'password');
        $errors = array_merge($errors, check_req_fields($req_fields));

        // Checking max length
        $max_len_fields = array('first_name' => 45, 'last_name' => 45, 'email' => 45, 'password' => 45);
        $errors = array_merge($errors, check_max_len($max_len_fields));
        

        // Checking validation of email
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is not valid';
        }

        // Checking if email already exist
        $email = mysqli_real_escape_string($connection, $_POST['email']); // Sanitizing email
        $query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

        $result_set = mysqli_query($connection, $query);

        if($result_set){
            if(mysqli_num_rows($result_set) == 1){
                $errors[] = 'Email is already exist';
            }
        }

        if(empty($errors)){
            // If no error record adds to to the table
            $first_name = mysqli_real_escape_string($connection, $_POST['first_name']); // Sanitizing first_name
            $last_name = mysqli_real_escape_string($connection, $_POST['last_name']); // Sanitizing last_name
            $password = mysqli_real_escape_string($connection, $_POST['password']); // Sanitizing password

            $hashed_password = sha1($password);

            $query = "INSERT INTO user
                     (first_name, last_name, email, password, is_deleted) VALUES
                     ('{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0)";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: users.php?user_add=true');
            }else{
                $errors[] = 'Failed to add the new record';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New User</title>

    <link href="styles/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
    </header>

    <main>
        <h1><label>Add New User</label> <span><a href="users.php">< Back to users list</a></span></h1>

        <?php

            if(!empty($errors)){
                display_errors($errors);
            }

        ?>

        <form action="add-user.php" method="post" class="userform">
            <p>
                <label>First Name</label>
                <input type="text" name="first_name" <?php echo 'value="'.$first_name.'"'; ?>>
            </p>
            <p>
                <label>Last Name</label>
                <input type="text" name="last_name" <?php echo 'value="'.$last_name.'"'; ?>>
            </p>
            <p>
                <label>Email</label>
                <input type="text" name="email" <?php echo 'value="'.$email.'"'; ?>>
            </p>
            <p>
                <label>Password</label>
                <input type="password" name="password">
            </p>
            <p>
                <label>&nbsp;</label>
                <button type="submit" name="submit">Save</button>
            </p>
        </form>
    </main>
</body>
</html>

<?php mysqli_close($connection) ?>