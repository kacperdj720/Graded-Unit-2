<?php
include 'includes/nav.php';
#starts database connection
require 'connect_db.php';

#gets users quiz score and email from session
$score = $_SESSION['quiz_score'] ?? null;
$email = $_SESSION['email'] ?? null;
$certificate = null;
$purchase_message = null;

#handles point purchase if user makes a transaction
if (isset($_GET['purchase']) && is_numeric($_GET['purchase']) && $score !== null) 
{
    $purchased_points = intval($_GET['purchase']);
    $score += $purchased_points;
    $_SESSION['quiz_score'] = $score;
    $purchase_message = "Payment complete.";
}

#determines which certificate the user gained
if ($score !== null && $email !== null)
	{
    if ($score >= 70) {
        $certificate = 'Gold';
    } elseif ($score >= 60) {
        $certificate = 'Silver';
    } elseif ($score >= 50) {
        $certificate = 'Bronze';
    }
#updates the certificate in database
    if ($certificate !== null) 
	{
        try
		{
            $query = "UPDATE new_users SET certificate = ? WHERE email = ?";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, "ss", $certificate, $email);
            mysqli_stmt_execute($stmt);

            if ($purchase_message) 
			{
                $purchase_message .= " $certificate certificate achieved!";
            }
        } catch (Exception $e) 
		{
            echo "<h2>Error updating certificate: " . $e->getMessage() . "</h2>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Green Calculator Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Green Calculator Result</h1>

    <?php if ($purchase_message): ?>
        <h2><?= $purchase_message ?></h2>
    <?php endif; ?>

    <?php if ($score !== null): ?>
        <h2>Your total score is: <?= $score ?> / 100</h2>

        <?php if ($certificate !== null): ?>
            <h2>Congratulations! You earned the <?= $certificate ?> certificate!</h2>
        <?php endif; ?>

        <?php if ($score < 70): ?>
            <?php if ($score < 50): ?>
                <a href="?purchase=<?= 50 - $score ?>" class="btn btn-primary mb-2">
                    Purchase <?= 50 - $score ?> points to reach <strong>Bronze</strong> level for £50
                </a><br>
            <?php endif; ?>

            <?php if ($score < 60): ?>
                <a href="?purchase=<?= 60 - $score ?>" class="btn btn-primary mb-2">
                    Purchase <?= 60 - $score ?> points to reach <strong>Silver</strong> level for £100
                </a><br>
            <?php endif; ?>

            <?php if ($score < 70): ?>
                <a href="?purchase=<?= 70 - $score ?>" class="btn btn-primary mb-2">
                    Purchase <?= 70 - $score ?> points to reach <strong>Gold</strong> level £200
                </a>
            <?php endif; ?>
        <?php endif; ?>

    <?php else: ?>
        <h2>No score found. Please take the quiz first.</h2>
    <?php endif; ?>
	<h2> If any point purchases are made all proceeds go to charity! </h2>
</div>
</body>
</html>

<?php
include 'includes/footer.php';
?>
