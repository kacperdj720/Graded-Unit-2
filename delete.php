<?php
session_start();
require('connect_db.php');

if (!isset($_SESSION['id'])) 
{
    header("Location: login.php");
    exit();
}
# get the logged in users id from session
$user_id = (int)$_SESSION['id'];
#fetch users email from database using user id
$get_email_query = "SELECT email FROM new_users WHERE id = $user_id";
$result = mysqli_query($link, $get_email_query);

if ($result && mysqli_num_rows($result) == 1) 
{
    $row = mysqli_fetch_assoc($result);
    $email = mysqli_real_escape_string($link, $row['email']);
#delete any records regarding users email
    $delete_card_query = "DELETE FROM card WHERE email = '$email'";
    mysqli_query($link, $delete_card_query);
#delete the user from new_users table
    $delete_user_query = "DELETE FROM new_users WHERE id = $user_id";
    mysqli_query($link, $delete_user_query);
    session_destroy();

    header("Location: login.php?deleted=1");
    exit();
} 
else
	{
    echo "Error: User not found or already deleted.";
}

mysqli_close($link);
?>