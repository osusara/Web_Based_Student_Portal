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

    /* MODIFY PASSWORD (Submit button action) */
    // Check if the form is submited
    if(isset($_POST['submit'])){

        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

        // Checking required fields
        $req_fields = array('user_id', 'password');
        $errors = array_merge($errors, check_req_fields($req_fields));

        // Checking max length
        $max_len_fields = array('password' => 40);
        $errors = array_merge($errors, check_max_len($max_len_fields));

        // If there's no errors
        if(empty($errors)){
            // If no error record adds to to the table
            $password = mysqli_real_escape_string($connection, $_POST['password']); // Sanitizing password
            $hashed_password = sha1($password);

            $query = "UPDATE user SET
                     password = '{$hashed_password}'
                     WHERE id = {$user_id} LIMIT 1";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: users.php?user_modified=true');
            }else{
                $errors[] = 'Failed to change the password in record';
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
    <title>Change Password</title>

    <link href="styles/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
    </header>

    <main>
        <h1><label>Change Password</label> <span><a href="modify-user.php?user_id=<?php echo $user_id; ?>">< Back to View/Modify User</a></span></h1>

        <?php

            if(!empty($errors)){
                display_errors($errors);
            }

        ?>

        <form action="change-password.php" method="post" class="userform">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
            <p>
                <label>First Name</label>
                <input type="text" name="first_name" <?php echo 'value="'.$first_name.'"'; ?> disabled>
            </p>
            <p>
                <label>Last Name</label>
                <input type="text" name="last_name" <?php echo 'value="'.$last_name.'"'; ?> disabled>
            </p>
            <p>
                <label>Email</label>
                <input type="text" name="email" <?php echo 'value="'.$email.'"'; ?> disabled>
            </p>
            <p>
                <label>New Password</label>
                <input type="password" name="password" id="password">
            </p>
            <p>
                <label>Show Password</label>
                <input type="checkbox" name="showpassword" id="showpassword" style="width: 15px; height: 15px;">
            </p>
            <p>
                <label>&nbsp;</label>
                <button type="submit" name="submit">Update Password</button>
            </p>
        </form>
    </main>

    <script src="./js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            $('#showpassword').click(function(){
                if($('#showpassword').is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
            });
        });

    </script>
</body>
</html>

<?php mysqli_close($connection) ?>