<?php
include 'includes/nav.php';
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST["q$i"])) {
            $score += (int)$_POST["q$i"];
        }
    }
    $_SESSION['quiz_score'] = $score;
    header("Location: quizfinal.php");
    exit();
}

$questions = [];
$query = "SELECT id, title, question FROM questions WHERE id BETWEEN 1 AND 10 ORDER BY id ASC";
$result = mysqli_query($link, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[$row['id']] = $row;
    }
} else {
    die('Error fetching questions: ' . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Green Calculator Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-group .btn {
            width: 100px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Green Calculator</h1>

        <form method="POST">
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <?php if (isset($questions[$i])): ?>
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-7">
                            <h4><?= htmlspecialchars($questions[$i]['title']) ?></h4>
                            <p><?= nl2br(htmlspecialchars($questions[$i]['question'])) ?></p>
                        </div>
                        <div class="col-md-5 text-center">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="q<?= $i ?>" id="q<?= $i ?>-10" value="10" required>
                                <label class="btn btn-outline-success" for="q<?= $i ?>-10">Yes (10 pts)</label>

                                <input type="radio" class="btn-check" name="q<?= $i ?>" id="q<?= $i ?>-5" value="5">
                                <label class="btn btn-outline-warning" for="q<?= $i ?>-5">Neutral (5 pts)</label>

                                <input type="radio" class="btn-check" name="q<?= $i ?>" id="q<?= $i ?>-0" value="0">
                                <label class="btn btn-outline-danger" for="q<?= $i ?>-0">No (0 pts)</label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
include 'includes/footer.php';
?>
