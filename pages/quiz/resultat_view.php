<?php
session_start();
$score = $_SESSION['last_score'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <h1 class="text-2xl font-bold mb-4">Félicitations !</h1>
        <p class="text-gray-600">Votre score final est :</p>
        <div class="text-5xl font-extrabold text-blue-600 my-4"><?= round($score, 2) ?> / 20</div>
        <a href="../index.php" class="text-blue-500 hover:underline">Rejouer le quiz</a>
    </div>
</body>
</html>