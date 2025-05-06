<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	#this connects to the database
    require('connect_db.php');
    $errors = array();

    #this validates and santisizes the input fields
    $company = !empty($_POST['company']) ? mysqli_real_escape_string($link, trim($_POST['company'])) : $errors[] = 'Enter your company name.';
    $contact = !empty($_POST['contact']) ? mysqli_real_escape_string($link, trim($_POST['contact'])) : $errors[] = 'Enter your contact name.';
    $phone = !empty($_POST['phone']) ? mysqli_real_escape_string($link, trim($_POST['phone'])) : $errors[] = 'Enter your phone number.';
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($link, trim($_POST['email'])) : $errors[] = 'Enter your email address.';

    #checcks if the passwords match
    if (!empty($_POST['pass1']) && $_POST['pass1'] === $_POST['pass2']) 
    {
        $password = trim($_POST['pass1']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } 
    else 
    {
        $errors[] = 'Passwords do not match or are empty.';
    }
    #checks if email already exists
    if (empty($errors)) 
    {
        $q = "SELECT id FROM new_users WHERE email='$email'";
        $r = mysqli_query($link, $q);
        if (mysqli_num_rows($r) > 0) {
            $errors[] = 'Email already registered. <a class="alert-link" href="login.php">Sign In Now</a>';
        }
    }
    # if theres no erroes insert user into database
    if (empty($errors)) 
    {
        $created_at = date('Y-m-d H:i:s');
        $q = "INSERT INTO new_users (company, contact, phone, email, password, status, admin, created_at, certificate) 
              VALUES ('$company', '$contact', '$phone', '$email', '$hashed_password', 'No', 0, '$created_at', NULL)";

        $r = mysqli_query($link, $q);

        if ($r) 
        {
            $z = "INSERT INTO card (cardnumber, exp, code, email) VALUES (NULL, NULL, NULL, '$email')";
            mysqli_query($link, $z);

            header('Location: login.php');
            exit();
        } 
        else 
        {
            $errors[] = 'Registration failed. Please try again.';
        }
    }
   #show erroes if there are any
    if (!empty($errors)) 
    {
        echo '<div class="container"><div class="alert alert-danger"><h4>Errors:</h4>';
        foreach ($errors as $msg) echo " - $msg<br>";
        echo '</div></div>';
    }
    #closes database
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { font-family: "Tinos", serif; }
        .container {
            max-width: 500px; margin: 50px auto; background: #fff;
            padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 { font-size: 32px; text-align: center; margin-bottom: 30px; }
        .form-control { margin-bottom: 15px; }
        .btn-primary { width: 100%; }
    </style>
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <form method="post" action="register.php" class="was-validated">
        <input type="text" name="company" class="form-control" placeholder="Company Name" required>
        <input type="text" name="contact" class="form-control" placeholder="Contact Name" required>
        <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="pass1" class="form-control" placeholder="Password" required>
        <input type="password" name="pass2" class="form-control" placeholder="Confirm Password" required>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div class="btn-group mt-3 d-flex justify-content-between">
        <a href="login.php" class="btn btn-secondary">Login</a>
        <a href="home.php" class="btn btn-secondary">Home</a>
    </div>
</div>
</body>
</html>
<?php include 'includes/footer.php'; ?>
