<?php
$output = Null;
$ids = [10, 22, 15, 67, 45];
$users = ['user1', 'user2', 'user3'];

$output = "Count of IDs array is: " . count($ids);
sort($ids);
rsort($ids);
array_push($ids, 100);
array_pop($ids);
array_shift($ids);
array_unshift($ids, 67);
$ids2 = array_slice($ids, 2, 3);
var_dump($ids2);
array_splice($ids, 1, 1, 'new user');
$output = 'sum of array Ids: ' . array_sum($ids);

$output = "user 3 exists: "  . in_array('user3', $users);

$tags = 'saleslady,collector,callcenter,police';
$tagsArray = explode(',', $tags);
var_dump($tagsArray);

date_default_timezone_set('America/Los_Angeles');
$output = date('F/d/Y h:i:s A');
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
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <!--Output-->
            <p class="text-xl"><?= $output ?></p>
            <h2 class="text-xl font-semibold my-4">IDs Array</h2>
            <p><?php print_r($users); ?></p>
        </div>

    </div>
</body>

</html>