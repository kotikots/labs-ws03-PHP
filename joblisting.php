<?php
$listings = [
    [
        'id' => 1,
        'title' => 'Software Engineer',
        'description' => 'We are looking for a skilled software engineer to join our team.',
        'salary' => 80000,
        'location' => 'San Francisco',
        'tags' => ['Java', 'Python', 'PHP']
    ],
    [
        'id' => 2,
        'title' => 'Data Analyst',
        'description' => 'Seeking a data analyst to interpret complex datasets and provide insights.',
        'salary' => 70000,
        'location' => 'New York',
        'tags' => ['SQL', 'R', 'Tableau']
    ],
    [
        'id' => 3,
        'title' => 'Project Manager',
        'description' => 'Experienced project manager needed to lead cross-functional teams.',
        'salary' => 90000,
        'location' => 'Jakarta',
        'tags' => []
    ],
    [
        'id' => 4,
        'title' => 'UX Designer',
        'description' => 'Creative UX designer to enhance user experience across our platforms.',
        'salary' => 75000,
        'location' => 'Austin',
        'tags' => ['Figma', 'Adobe XD', 'User Research']
    ],
    [
        'id' => 5,
        'title' => 'DevOps Engineer',
        'description' => 'Looking for a DevOps engineer to streamline our deployment processes.',
        'salary' => 85000,
        'location' => 'Seattle',
        'tags' => ['AWS', 'Docker', 'Kubernetes']
    ]
];
// '??' Null Coalescing Operator checks if the variable is null, PHP 7

// $favoriteJob = null;
// $color = $favoriteJob ?? 'Red'; (will output 'Red')

// Helper function is for formatting
// function formatSalary($salary) {
//     return '$' . number_format($salary);
// }

$formatSalary = fn($salary) => '$' . number_format($salary);

// Named function 
// Anonymous function is chosen when you will only use the function once
$add = function ($a, $b) {
    return $a + $b;
}; // needs semi-colon

// convert to arrow function
$add = fn($a, $b) => $a + $b;

$hello = function () {
    echo "Hello";
};
// $hello();

// callback function 
function run($greet)
{
    $greet();
}
// run($hello);

// closure function makes a copy of the global variable to use inside a function
$kaibigan = 'friend';
$kamusta = function () use ($kaibigan) { // use is the keyword need to access the global variable
    echo "Kamusta ka $kaibigan? ";
};
// $kamusta();    

function filterByLocation($listings, $location)
{
    return array_filter($listings, function ($job) use ($location) {
        return strcasecmp($job['location'], $location) === 0;
    });
}

if (isset($_GET['location'])) {
    $location = $_GET['location'];
    $listings = filterByLocation($listings, $location);
} else {
    $filteredLocation = $listings;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <header class="bg-sky-900 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold">Job Listing</h1>
        </div>
    </header>

    <div class="container mx-auto p-4 mt-4">
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <?php foreach ($listings as $index => $job): ?>
                <!-- foreach loop is used to iterate through each job listing in the $listings array. The $index variable holds the current index of the loop, and $job holds the current job listing being processed. -->
                <div class="md my-4">
                    <div class="
                        <?php if ($index % 2 === 0) : ?>
                            bg-sky-100
                        <?php else : ?>
                            bg-white
                        <?php endif; ?>
                            rounded-lg shadow-md">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold"><?= $job['title'] ?></h2>
                            <p class="text-gray-700 text-lg mt-2"><?= $job['description'] ?></p>
                            <ul class="mt-4">
                                <li class="mb-2">
                                    <strong>Salary:</strong><?= ' ' . $formatSalary($job['salary']) ?>
                                </li>
                                <li class="mb-2">
                                    <strong>Location:</strong><?= ' ' . $job['location'] ?>
                                    <!-- <?php if ($job['location'] === 'New York') : ?>
                                        <span class="text-xs text-white bg-amber-900 rounded-full px-2 py-1 ml-2">Remote</span>
                                        <?php endif; ?> -->

                                    <?= $job['location'] === 'New York' ?
                                        '<span class="text-xs text-white bg-sky-900 rounded-full px-2 py-1 ml-2">Remote</span>'
                                        : '<span class="text-xs text-white bg-sky-900 rounded-full px-2 py-1 ml-2">Onsite</span>' ?>
                                </li>
                                <?php if (!empty($job['tags'])) : ?>
                                    <li class="mb-2">
                                        <strong>Tags:</strong><?= ' ' . implode(', ', $job['tags']) ?>
                                        <!-- implode() function is used to convert the array of tags into a comma-separated string for display. -->
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>