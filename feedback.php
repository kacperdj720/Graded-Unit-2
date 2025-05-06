<?php
include 'includes/nav.php';
include 'connect_db.php'; 

$success = "";
#check if the form is being submitted using post
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $message = mysqli_real_escape_string($link, $_POST['message']);
    #insert feedback form into the database
    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";
	#check if its been successful
    if (mysqli_query($link, $sql)) 
	{
        $success = "Thank you for your feedback!";
    } 
	else 
	{
        $success = "Something went wrong: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback - Sustain Energy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">Send us your Feedback</h2>

  <?php if ($success): ?>
    <div class="alert alert-info"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST" action="feedback.php">
    <div class="mb-3">
      <label for="name" class="form-label">Your Name</label>
      <input type="text" class="form-control" name="name" id="name" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Your Email</label>
      <input type="email" class="form-control" name="email" id="email" required>
    </div>

    <div class="mb-3">
      <label for="message" class="form-label">Message</label>
      <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Submit Feedback</button>
  </form>
</div>
</body>
</html>

<?php include 'includes/footer.php'; ?>
