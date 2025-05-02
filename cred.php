<?php
include 'includes/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Credentials</title>
    <style>
        body {
            text-align: center;
        }
        .sponsors {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap; /* allows stacking on smaller screens */
            margin-bottom: 40px;
        }
        .sponsor {
            width: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sponsor img {
            width: 100%;
            height: auto;
            max-height: 150px;
            object-fit: contain;
        }
        .sponsor h3 {
            margin-top: 10px;
            font-size: 16px;
            font-weight: normal;
        }
        .description {
            max-width: 700px;
            margin: 0 auto;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1>Our Credentials</h1>

    <div class="sponsors">
        <div class="sponsor">
            <img src="images/edicol.png" alt="Edinburgh College Logo">
            <h3>Edinburgh College</h3>
        </div>
        <div class="sponsor">
            <img src="images/peace.png" alt="Greenpeace Logo">
            <h3>Green Peace</h3>
        </div>
        <div class="sponsor">
            <img src="images/wwf.png" alt="WWF Logo">
            <h3>WWF</h3>
        </div>
    </div>

    <p class="description">
        This website is proudly approved by respected institutions and organisations committed to promoting sustainability. 
        Endorsed by Edinburgh College and supported by global leaders in environmental protection like Greenpeace and WWF, 
        we aim to provide companies with the tools to build a greener future.
    </p>

</body>
</html>

<?php
include 'includes/footer.php';
?>
