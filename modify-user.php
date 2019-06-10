<?php session_start(); ?>
<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/functions.php'); ?>

<?php
    
    // Check if a user logged in
    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
    }

    $errors = array();

    $user_id = '';
    $first_name = '';
    $last_name = '';
    $email = '';

    /* VIEW USER */
    // Check if the user id is set
    if(isset($_GET['user_id'])){

        // Getting the user information
        $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
        $query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

        $result_set = mysqli_query($connection, $query);

        if($result_set){
            if(mysqli_num_rows($result_set) == 1){
                // User found
                $result = mysqli_fetch_assoc($result_set);
                $first_name = $result['first_name'];
                $last_name = $result['last_name'];
                $email = $result['email'];
            }else{
                // User not found
                header('Location: users.php?err=user_not_found');
            }
        }else{
            // Query failed
            header('Location: users.php?err=query_failed');
        }
    }

    /* MODIFY USER */
    // Check if the form is submited
    if(isset($_POST['submit'])){

        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        // Checking required fields
        $req_fields = array('user_id', 'first_name', 'last_name', 'email');
        $errors = array_merge($errors, check_req_fields($req_fields));

        // Checking max length
        $max_len_fields = array('first_name' => 45, 'last_name' => 45, 'email' => 45);
        $errors = array_merge($errors, check_max_len($max_len_fields));
        

        // Checking validation of email
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is not valid';
        }

        // Checking if email already exist
        $email = mysqli_real_escape_string($connection, $_POST['email']); // Sanitizing email
        $query = "SELECT * FROM user WHERE email = '{$email}' AND id != {$user_id} LIMIT 1";

        $result_set = mysqli_query($connection, $query);

        if($result_set){
            if(mysqli_num_rows($result_set) == 1){
                $errors[] = 'Email is already exist';
            }
        }

        // If there's no errors
        if(empty($errors)){
            // If no error record adds to to the table
            $first_name = mysqli_real_escape_string($connection, $_POST['first_name']); // Sanitizing first_name
            $last_name = mysqli_real_escape_string($connection, $_POST['last_name']); // Sanitizing last_name

            $query = "UPDATE user SET
                     first_name = '{$first_name}',
                     last_name = '{$last_name}',
                     email = '{$email}'
                     WHERE id = {$user_id} LIMIT 1";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: users.php?user_modified=true');
            }else{
                $errors[] = 'Failed to modify the record';
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
    <title>View/Modify User</title>

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

        <form action="modify-user.php" method="post" class="userform">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
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
                <a href="change-password.php?user_id=<?php echo $user_id; ?>">Change Password</a>
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