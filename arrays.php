<?php
$output = Null;

$ids = [10, 22, 15, 67, 45];
$users = ['user1', 'user2', 'user3'];

sort($ids);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Array Function</title>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold">PHP</h1>
        </div>
    </header>
    <div class="container mx-auto p-4 mt-4">
        <!--Output-->
        <p class="text-xl"><?= $output ?></p>
        <h2 class="text-xl font-semibold my-4">IDs Array</h2>
        <p><?php print_r($ids); ?></p>

    </div>
</body>

</html>