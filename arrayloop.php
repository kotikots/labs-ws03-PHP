<?php

$names = ['Red Yoyong', 'Blue Yong', 'Green Yong', 'Yellow Yong'];

$users = [
    ["name" => "Red Yoyong", "email" => "redyoyong@gmail.com"],
    ["name" => "Blue Yong", "email" => "blueyong@gmail.com"],
    ["name" => "Green Yong", "email" => "greenyong@gmail.com"],
    ["name" => "Yellow Yong", "email" => "yellowyong@gmail.com"]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>LOOPING</title>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold">PHP LOOP</h1>
        </div>
    </header>
    <div class="container mx-auto p-4 mt-4">
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <!-- Output -->
            <h3 class="text-xl font-semibold mb-4">Using a for loop</h3>
            <ul class="mb-6">
                <?php for ($i = 0; $i < count($names); $i++) { ?>
                    <li><?= $names[$i] ?></li>
                <?php } ?>
            </ul>
            <h3 class="text-xl font-semibold mb-4">Using a foreach loop</h3>
            <ul class="mb-6">
                <?php foreach ($names as $name): ?>
                    <li><?= $name ?></li>
                <?php endforeach; ?>
            </ul>
            <h3 class="text-xl font-semibold mb-4">Using a foreach loop with index</h3>
            <ul class="mb-6">
                <?php foreach ($names as $index => $name): ?>
                    <li><?= $index . ": " . $name ?></li>
                <?php endforeach; ?>
            </ul>
            <h3 class="text-xl font-semibold mb-4">Using a foreach loop with associative array</h3>
            <?php foreach ($users as $user): ?>
                <ul><?= "Name: " . $user["name"] . " / " . "Email: " . $user["email"] ?></ul>
            <?php endforeach; ?>

            <h3 class="text-xl font-semibold mb-4">Getting key names and values from associative array</h3>
            <ul class="mb-6">
                <?php foreach ($users as $user): ?>

                    <?php foreach ($user as $key => $value): ?>
                        <li><?= $key . ": " . $value ?></li>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>

</html>