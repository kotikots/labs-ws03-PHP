<?php
// SUPERGLOBALS LAB
// Fill in the blanks using ONLY these:
// $_SERVER, $_GET, $_POST, $_FILES, $_SESSION

session_start(); // needed for $_SESSION

// 1) SERVER: request method
$requestMethod = $_SERVER['REQUEST_METHOD']; // GET or POST

// 2) GET or POST: theme from URL or form 
$theme = $_GET['theme'] ?? ($_POST['theme'] ?? 'light');

// Theme classes
$bodyClass = "bg-rose-100 text-rose-900";
$cardClass = "bg-white border-rose-200";
$mutedText = "text-rose-600";
$softBg    = "bg-rose-50";

if ($theme === "dark") {
    $bodyClass = "bg-rose-300 text-rose-900";
    $cardClass = "bg-white border-rose-950";
    $mutedText = "text-rose-700";
    $softBg    = "bg-rose-300";
}

// Default outputs
$notice = "";
$uploadedInfo = "";

// 3) POST + FILES handling
if ($requestMethod === "POST") {

    // POST: read name
    $name = $_POST['student_name'] ?? "";

    // SESSION: remember name
    $_SESSION['saved_name'] = $name;

    // FILES: safe check first
    if (isset($_FILES['student_file']) && $_FILES['student_file']['error'] === 0) {

        $fileName = $_FILES['student_file']['name'];
        $fileSize = $_FILES['student_file']['size'];

        $uploadedInfo = "Uploaded file: $fileName ($fileSize bytes)";
    } else {
        $uploadedInfo = "No file selected (or upload error).";
    }

    $notice = "Saved! Refresh the page and your SESSION name should stay.";
}

// 4) SESSION: read remembered value
$savedName = $_SESSION['saved_name'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Superglobals Lab</title>
</head>

<body class="<?= $bodyClass; ?> min-h-screen p-6">
    <div class="max-w-3xl mx-auto">
        <div class="<?= $cardClass; ?> border rounded-2xl shadow p-6">

            <h1 class="text-2xl font-bold">Superglobals Lab (Student)</h1>
            <p class="mt-1 <?= $mutedText; ?>">
                FORM → $_SERVER → $_GET → $_POST → $_FILES → $_SESSION
            </p>

            <?php if ($notice !== ""): ?>
                <div class="mt-4 <?= $softBg; ?> border <?= ($theme === "dark" ? "border-rose-700" : "border-rose-200"); ?> rounded-xl p-4">
                    <p class="font-semibold"><?= $notice; ?></p>
                </div>
            <?php endif; ?>

            <div class="grid md:grid-cols-2 gap-4 mt-6">

                <!-- SERVER -->
                <div class="<?= $softBg; ?> border <?= ($theme === "dark" ? "border-rose-700" : "border-rose-200"); ?> rounded-xl p-4">
                    <h2 class="font-bold text-lg">$_SERVER</h2>
                    <p class="mt-2 text-sm <?= $mutedText; ?>">Shows the request method.</p>
                    <p class="mt-3 font-mono">REQUEST_METHOD: <?= $requestMethod; ?></p>
                </div>

                <!-- GET -->
                <div class="<?= $softBg; ?> border <?= ($theme === "dark" ? "border-rose-700" : "border-rose-200"); ?> rounded-xl p-4">
                    <h2 class="font-bold text-lg">$_GET</h2>
                    <p class="mt-2 text-sm <?= $mutedText; ?>">Reads data from the URL.</p>
                    <p class="mt-3 font-mono">theme: <?= $theme; ?></p>

                    <div class="mt-3 flex gap-2">
                        <a class="px-3 py-2 rounded-lg <?= ($theme === "dark" ? "bg-rose-700" : "bg-rose-200"); ?>" href="?theme=light">Light</a>
                        <a class="px-3 py-2 rounded-lg <?= ($theme === "dark" ? "bg-rose-700" : "bg-rose-200"); ?>" href="?theme=dark">Dark</a>
                    </div>
                </div>

                <!-- POST + FILES -->
                <div class="<?= $softBg; ?> border <?= ($theme === "dark" ? "border-rose-700" : "border-rose-200"); ?> rounded-xl p-4">
                    <h2 class="font-bold text-lg">FORM → $_POST + $_FILES</h2>
                    <p class="mt-2 text-sm <?= $mutedText; ?>">
                        Submit a name (POST) and choose a file (FILES).
                    </p>

                    <form method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">

                        <!-- Keep theme during POST -->
                        <input type="hidden" name="theme" value="<?= $theme; ?>">

                        <input type="text"
                            name="student_name"
                            placeholder="Enter your name"
                            class="w-full rounded-xl border px-4 py-2 <?= ($theme === "dark" ? "bg-rose-800 border-rose-700" : "bg-white border-rose-200"); ?>" />

                        <input type="file" name="student_file" class="w-full text-sm" />

                        <button class="w-full rounded-xl px-4 py-2 font-semibold <?= ($theme === "dark" ? "bg-rose-500 text-white" : "bg-rose-900 text-white"); ?>">
                            Save (POST)
                        </button>
                    </form>

                    <?php if ($uploadedInfo !== ""): ?>
                        <p class="mt-3 text-sm font-mono"><?= $uploadedInfo; ?></p>
                    <?php endif; ?>

                </div>

                <!-- SESSION -->
                <div class="<?= $softBg; ?> border <?= ($theme === "dark" ? "border-rose-700" : "border-rose-200"); ?> rounded-xl p-4">
                    <h2 class="font-bold text-lg">$_SESSION</h2>
                    <p class="mt-2 text-sm <?= $mutedText; ?>">
                        Remembers data even after refresh.
                    </p>

                    <p class="mt-3">
                        <span class="font-semibold">Saved Name:</span>
                        <span class="font-mono"><?= $savedName; ?></span>
                    </p>
                </div>

            </div>
        </div>
    </div>
</body>

</html>