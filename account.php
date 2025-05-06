<?php 
include 'includes/nav.php';

#redirect to login if the user isnt logged in
if (!isset($_SESSION['id'])) 
{
    require('login_tools.php');
    load();
}

require('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
    if (isset($_POST['setup_billing']))
		{
        $uid = (int)$_SESSION['id'];
		#gets user email from database
        $get_user = "SELECT email FROM new_users WHERE id = $uid";
        $user_result = mysqli_query($link, $get_user);
        $user_data = mysqli_fetch_assoc($user_result);
        $email = $user_data['email'];
        # check if card details exist for user
        $card_check = "SELECT * FROM card WHERE email = '$email'";
        $card_result = mysqli_query($link, $card_check);
        $card_info = mysqli_fetch_assoc($card_result);
        #if card code exists activite account
        if (!empty($card_info['code'])) 
		{
            $update_status = "UPDATE new_users SET status = 'active' WHERE id = $uid";
            mysqli_query($link, $update_status);
        }
    }
	else 
	{
		#update card detials submitted by user
        $user_id = mysqli_real_escape_string($link, $_POST['user_id']);
        $card_number = mysqli_real_escape_string($link, $_POST['card_number']);
        $expiration_date = mysqli_real_escape_string($link, $_POST['expiration_date']);
        $last_three_digits = mysqli_real_escape_string($link, $_POST['last_three_digits']);
        #update card info in database
        $update_query = "UPDATE card SET cardnumber = '$card_number', exp = '$expiration_date', code = '$last_three_digits' 
                        WHERE email = (SELECT email FROM new_users WHERE id = " . (int)$user_id . ")";
        mysqli_query($link, $update_query);
    }
}
#fetch current user info
$q = "SELECT * FROM new_users WHERE id=" . (int)$_SESSION['id'];
$r = mysqli_query($link, $q);
#display user info
if (mysqli_num_rows($r) > 0) 
{
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) 
	{
        $c = "SELECT * FROM card WHERE email = '" . $row['email'] . "'";
        $t = mysqli_query($link, $c);
        $card_data = mysqli_fetch_array($t, MYSQLI_ASSOC);

        $date = $row["created_at"];
        $day = substr($date, 8, 2);
        $month = substr($date, 5, 2);
        $year = substr($date, 0, 4);

        $certification = $row['certificate'];

        echo '    
<div class="container mt-5">
    <h1>Welcome to your account, ' . htmlspecialchars($row['contact']) . '!</h1>
    <div class="d-flex flex-wrap justify-content-between">
        <!-- Account & Card Details -->
        <div class="card flex-grow-1 m-2 p-3" style="max-width: 23%; min-width: 250px;">
            <h2>Account & Card Details</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">User ID: EC2024/' . (int)$row['id'] . '</li>
                <li class="list-group-item">Email: ' . htmlspecialchars($row['email']) . '</li>
                <li class="list-group-item">Registration Date: ' . $day . '/' . $month . '/' . $year . '</li>';
#show card details if available
        if ($card_data)
			{
            echo '
                <li class="list-group-item">Card Number: ' . htmlspecialchars($card_data['cardnumber']) . '</li>
                <li class="list-group-item">Expiry Date: ' . htmlspecialchars($card_data['exp']) . '</li>
                <li class="list-group-item">3 Digits: ' . htmlspecialchars($card_data['code']) . '</li>';
        } 
		else 
		{
            echo '<li class="list-group-item">No card details found.</li>';
        }
# button to delete account
        echo '
                <li class="list-group-item text-center">
                    <form action="delete.php" method="POST">
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="card flex-grow-1 m-2 p-3" style="max-width: 23%; min-width: 250px;">
            <h2>Update Card</h2>
            <form method="POST" action="">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" class="form-control mb-2" value="' . (int)$row['id'] . '" readonly>
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" class="form-control mb-2" required>
                <label for="expiration_date">Expiration Date:</label>
                <input type="text" id="expiration_date" name="expiration_date" class="form-control mb-2" required>
                <label for="last_three_digits">Last Three Digits:</label>
                <input type="text" id="last_three_digits" name="last_three_digits" class="form-control mb-3" required>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="card flex-grow-1 m-2 p-3" style="max-width: 23%; min-width: 250px; height: 400px;">
            <h2>Green Certification</h2>';
#
        if (!empty($certification)) 
		{
            $certImage = strtolower($certification) . '.png';
            $imagePath = 'images/certificates/' . $certImage;

            echo '
                <p>You have achieved the <strong>' . htmlspecialchars($certification) . '</strong> Certification!</p>
                <img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($certification) . ' Certificate" class="img-fluid border rounded">';
        } 
		else 
		{
            echo '<p>No certification has been achieved yet.</p>';
        }
// billing set up section
        echo '
        </div>

        <div class="card flex-grow-1 m-2 p-3" style="max-width: 23%; min-width: 250px; height: 400px;">
            <h2>Yearly Billings</h2>';

        if ($row['status'] === 'active')
			{
            echo '<p class="text-dark">Yearly billing of £99.99 is setup.</p>';
        } 
		else 
		{
            echo '
            <p class="text-muted">Setup your yearly billing below.</p>
            <form method="POST" action="">
                <button type="submit" name="setup_billing" class="btn btn-outline-primary">Setup Billing</button>
            </form>';
        }

        echo '
        </div>
    </div>
</div>';
    }
} 
else 
{
    echo '<div class="container mt-5"><h3>No user details found.</h3></div>';
}

include 'includes/footer.php';
