<?php

function load($page = 'login.php') 
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}
#validates user login details
function validate($link, $email = '', $pwd = '')
{
  $errors = array();

  if (empty($email)) 
  {
    $errors[] = 'Enter your email address.';
  } 
  else 
  {
    $e = mysqli_real_escape_string($link, trim($email));
  }

  if (empty($pwd)) 
  {
    $errors[] = 'Enter your password.';
  }
  else
	  {
    $p = mysqli_real_escape_string($link, trim($pwd));
  }

  if (empty($errors))
	  {
    $q = "SELECT id, company, created_at FROM new_users WHERE email='$e' AND password=SHA2('$p',256)";
    $r = mysqli_query($link, $q);
    if (@mysqli_num_rows($r) == 1) {
      $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
      return array(true, $row);
    } 
	else 
	{
      $errors[] = 'Email address and password not found.';
    }
  }

  return array(false, $errors);
}

