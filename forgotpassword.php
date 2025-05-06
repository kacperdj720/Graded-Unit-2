<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password</title>
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
            <h1>Reset Password</h1>

            <?php
			# handles submission form
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					#requires database connection
                require('connect_db.php');
                #sanitises email and password inputs
                $email = mysqli_real_escape_string($link, $_POST['email']);
                $new_password = mysqli_real_escape_string($link, $_POST['new_password']);
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                 # checks if email exists
                $check_query = "SELECT * FROM new_users WHERE email = '$email'";
                $result = mysqli_query($link, $check_query);
                # if the user exists update password
                if (mysqli_num_rows($result) == 1)
					{
                    $update_query = "UPDATE new_users SET password = '$hashed_password' WHERE email = '$email'";
                    mysqli_query($link, $update_query);
                }

                mysqli_close($link);
            }
            ?>

            <form method="post" action="">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required><br>
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required><br>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>

            <div class="btn-group mt-4" role="group" aria-label="Navigation">
                <form action="login.php" method="get">
                    <button type="submit" class="btn btn-secondary">Login</button>
                </form>
                <form action="home.php" method="get">
                    <button type="submit" class="btn btn-secondary">Home</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php include 'includes/footer.php'; ?>
