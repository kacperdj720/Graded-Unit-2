<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('connect_db.php');
    require('login_tools.php');

    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = $_POST['password'];
#creates query to find user by email
    $query = "SELECT * FROM new_users WHERE email = '$email'";
    $result = mysqli_query($link, $query);
#checks if a user exists with inputted email
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
#checks if the password matches inputted email
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['created_at'] = $user['created_at'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['company'] = $user['company'];
            $_SESSION['email'] = $user['email'];

            load('home.php');
        } else {
            $errors = ['Invalid email or password.'];
        }
    } else {
        $errors = ['Invalid email or password.'];
    }
#closes database connection
    mysqli_close($link);
}
#if there are any errors display errors
if (!empty($errors)) {
    include('login.php');
}
?>
