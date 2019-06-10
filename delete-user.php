<?php session_start(); ?>
<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/functions.php'); ?>

<?php
    
    // Check if a user logged in
    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
    }

    /* VIEW USER */
    // Check if the user id is set
    if(isset($_GET['user_id'])){

        // Getting the user information
        $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
        
        // Should not delete current user
        if($user_id == $_SESSION['user_id']){
            header('Location: users.php?err=cannot_delete_current_user');
        }else{

            // Deleting the user
            $query = "UPDATE user SET
                     is_deleted = 1
                     WHERE id = {$user_id} LIMIT 1";

            $result = mysqli_query($connection, $query);

            if($result){

                // User deleted
                header('Location: users.php?msg=user_deleted');
            }else{
                header('Location: users.php?msg=user_delete_failed');
            }
        }
    }else{
        header('Location: users.php');
    }

?>

<?php mysqli_close($connection) ?>