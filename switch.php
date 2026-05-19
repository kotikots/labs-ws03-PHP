<?php
$dayOftheWeek = date('l');

switch ($dayOftheWeek) {
    case 'Monday':
        $message = "Monday Blues";
        $color = 'blue';
        $textColor = 'black';
        break;
    case 'Tuesday':
        $message = "Tuesday green";
        $color = 'green';
        $textColor = 'white';
        break;
    case 'Wednesday':
        $message = "Wednesday yellow";
        $color = 'yellow';
        $textColor = 'black';
        break;
    case 'Thursday':
        $message = "Thursday orange";
        $color = 'orange';
        $textColor = 'white';
        break;
    case 'Friday':
        $message = "Friday red";
        $color = 'red';
        $textColor = 'white';
        break;
    case 'Saturday':
        $message = "Saturday purple";
        $color = 'purple';
        $textColor = 'white';
        break;
    case 'Sunday':
        $message = "Sunday pink";
        $color = 'pink';
        $textColor = 'white';
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day | What is HTML?</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: <?= $color ?>;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <h1><?= $message ?></h1>
</body>

</html>