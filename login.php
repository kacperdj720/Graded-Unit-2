<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cinema</title>
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
          crossorigin="anonymous">
</head>

<style>
    .card {
        width: 100%;
        max-width: 600px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 0;
        border: none;
    }
    h1 {
        font-size: 40px;
        text-align: center;
        font-family: "Tinos", serif;
        font-weight: 400;
        font-style: normal;
        margin-top: 20px;
    }
    .btn-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .btn {
        padding: 10px 20px;
    }
    .container {
        max-width: 400px;
        margin: 50px auto;
        text-align: center;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    body {
        font-family: "Tinos", serif;
        font-weight: 400;
        font-style: normal;
    }
</style>

<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h1>Login</h1>
            <form action="login_action.php" method="post">
                <label for="email">Email:</label><br>
                <input type="text" class="form-control" placeholder="Email" name="email" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" class="form-control" placeholder="Password" name="password" required><br><br>
                <div class="btn-group" role="group" aria-label="Login">
                    <button type="submit" value="login" class="btn btn-primary">Login</button>
                </div>
            </form>

            <div class="btn-group" role="group" aria-label="Navigation Buttons">
                <form action="register.php" method="get">
                    <button type="submit" class="btn btn-secondary">Register</button>
                </form>
                <form action="home.php" method="get">
                    <button type="submit" class="btn btn-secondary">Home</button>
                </form>
                <form action="forgotpassword.php" method="get">
                    <button type="submit" class="btn btn-warning">Forgot Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
include 'includes/footer.php';
?>
