<?php
include 'includes/nav.php';
require('connect_db.php');

$uid = $_SESSION['id'];
$q = "SELECT admin FROM new_users WHERE id = '$uid' LIMIT 1";
$r = mysqli_query($link, $q);
$row = mysqli_fetch_assoc($r);

if ($row['admin'] != 1) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Access Denied. Admins only.</div></div>";
    exit();
}

//handles deletion requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    if ($delete_id !== $uid) {  // Prevent the admin from deleting themselves
        $delete_q = "DELETE FROM new_users WHERE id = $delete_id LIMIT 1";
        mysqli_query($link, $delete_q);
    }
}

//fetches all users
$users_q = "SELECT id, company, email FROM new_users ORDER BY id ASC";
$users_r = mysqli_query($link, $users_q);

//fetches all feedback subbmissions
$feedback_q = "SELECT id, name, email, message FROM feedback ORDER BY id DESC";
$feedback_r = mysqli_query($link, $feedback_q);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Admin Panel - User List</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Company</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($users_r)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['company']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <?php if ($user['id'] != $uid): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">Current Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2 class="mb-4 mt-5">Feedback Submissions</h2>
    <?php if (mysqli_num_rows($feedback_r) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($feedback = mysqli_fetch_assoc($feedback_r)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                        <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($feedback['message'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No feedback submissions available.</p>
    <?php endif; ?>
    
<a href="home.php" class="btn btn-secondary mt-3">Back to Home</a>
</div>
</body>
</html>

<?php 
mysqli_close($link);
include 'includes/footer.php';
?>
