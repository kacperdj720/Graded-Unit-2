<?php
session_start();
#this starts the session
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/mystyle.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <title>Sustain Energy</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
  
    <?php
	#  if the company is logged into the webstie this welcomes them by displaying their name
      if (isset($_SESSION['company'])) 
	  {
          echo 'Welcome to Sustain Energy! ' . htmlspecialchars($_SESSION['company']) . '!';
      } else {
          echo 'Welcome to Sustain Energy!';
      }
    ?>
  </a>
  <button class="navbar-toggler" type="button" 
    data-toggle="collapse" 
    data-target="#navbarNav" 
    aria-controls="navbarNav" 
    aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="d-flex justify-content-between align-items-center w-100">
    <ul class="navbar-nav me-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home</a>
      </li>

      <?php if (isset($_SESSION['id'])): 
	  # this displays if the company is logged in as every page doesnt need to be displayed
	  ?>
        <li class="nav-item">
          <a class="nav-link" href="information.php">Information</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="feedback.php">Feedback</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cred.php">Credentials</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="terms.php">Terms n Condtion</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="privacy.php">Privacy Policy</a>
        </li>

        <?php
          #this sections displays if the company has active billing setup or if the user has admin permissions
          require('connect_db.php');
          $uid = $_SESSION['id'];
          $q = "SELECT status, admin FROM new_users WHERE id = '$uid' LIMIT 1";
          $r = mysqli_query($link, $q);
          $row = mysqli_fetch_assoc($r);

          if ($row['status'] === 'active') {
              echo '<li class="nav-item"><a class="nav-link" href="greencalc.php">Green calculator</a></li>';
          } else {
              echo '<li class="nav-item"><a class="nav-link" href="account.php">Green calculator</a></li>';
          }

          if ($row['admin'] == 1) {
              echo '<li class="nav-item"><a class="nav-link" href="panel.php">Admin Panel</a></li>';
          }

          mysqli_close($link);
        ?>

        <li class="nav-item">
          <a class="nav-link" href="account.php">Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      <?php else: 
	  #if the user isnt logged in it displays these below?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
</body>
</html>
