<?php session_start(); ?>
<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/functions.php'); ?>

<?php

    // Check for submission
    if(isset($_POST['submit'])){

        $errors = array();

        // Check if the username and password has been entered
        if(!isset($_POST['username']) || strlen(trim($_POST['username'])) < 1){
            $errors[] = 'Username can not be empty';
        }

        if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1){
            $errors[] = 'Password can not be empty';
        }

        // Check if there are any errors in the form
        if(empty($errors)){

            // Save into variables
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashed_password = sha1($password);

            // Prepare database query
            $query = "SELECT * FROM user WHERE email='{$username}' AND password='{$hashed_password}' LIMIT 1";
            $result_set = mysqli_query($connection, $query);

            // Check if the user is valid
            verify_query($result_set);

            // Query successful
            if(mysqli_num_rows($result_set) == 1){

                // Valid user found
                $user = mysqli_fetch_assoc($result_set);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];

                // Updating last login
                $query = "UPDATE user SET last_login = NOW()";
                $query .= "WHERE id={$_SESSION['user_id']} LIMIT 1";

                $result_set = mysqli_query($connection, $query);

                verify_query($result_set);

                // redirect to user.php
                header('Location: users.php');
            }else{

                // Username or password incorrect
                $errors[] = 'Username or Password incorrect';
            }

            // if not, display the error
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link href="styles/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="login">
        <form action="index.php" method="post">
            <fieldset>
                <legend><h1>Login</h1></legend>

                <?php
                    // Display errors
                    if(isset($errors) && !empty($errors)){
                        echo '<p class="error">'.$errors[0].'</p>';
                    }
                ?>

                <?php
                    // Display logout messege
                    if(isset($_GET['logout'])) {
                        echo '<p class="info"> Successfully logged out!</p>';
                    }
                ?>

                <p>
                    <label for="">Username</label>
                    <input type="text" name="username" id="" placeholder="Email Address">
                </p>

                <p>
                    <label for="">Password</label>
                    <input type="password" name="password" id="" placeholder="Password">
                </p>

                <p>
                    <button type="submit" name="submit">Login</button>
                </p>
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php mysqli_close($connection) ?>