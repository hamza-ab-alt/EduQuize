<?php
require_once "../../src/Repository/QuestionRepository.php";
require_once "../../config/database.php";
use App\Repository\QuestionRepository;

$QR = new QuestionRepository();
$quiz_id = $_GET["id"] ?? null;

if (!$quiz_id) {
    die("ID Quiz manquant!");
}

if (isset($_POST['add_question'])) {
    $question_text = $_POST['question_text'];
    $newQ = new stdClass(); 
    $newQ->quiz_id = $quiz_id;
    $newQ->question_text = $question_text;
    
    $QR->createQuestion($newQ->quiz_id,$newQ->question_text);
    header("Location: updateQuiz.php?id=" . $quiz_id);
    exit;
}

if (isset($_POST['delete_id'])) {
    $QR->deleteQuestion($_POST['delete_id']);
    header("Location: updateQuiz.php?id=" . $quiz_id);
    exit;
}

$results = $QR->getQuestionsByQuiz($quiz_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestion des Questions</title>
</head>
<body class="bg-gray-100 p-4 md:p-10">

    <div class="max-w-4xl mx-auto">        
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Ajouter une nouvelle question</h2>
            <form method="POST" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="question_text" required placeholder="Entrez votre question ici..." 
                       class="flex-1 border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                <button type="submit" name="add_question" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    Ajouter +
                </button>
            </form>
        </div>
        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Questions du Quiz #<?php echo htmlspecialchars($quiz_id); ?></h1>
                <span class="text-sm text-gray-500 font-medium"><?php echo count($results); ?> Questions</span>
            </div>
            
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-5 py-4 border-b">Question</th>
                        <th class="px-5 py-4 border-b text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $item): ?>
                            <tr class="border-b border-gray-200 hover:bg-blue-50/50 transition-colors">
                                <td class="px-5 py-4 text-sm">
                                    <p class="text-gray-800 font-medium"><?php echo htmlspecialchars($item['question']); ?></p>
                                </td>
                                <td class="px-5 py-4 text-sm text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="updateQestion.php?id=<?php echo $item['id']; ?>" class="text-indigo-600 hover:underline">Modifier</a>
                                        
                                        <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?');">
                                            <input type="hidden" name="delete_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center text-gray-400 italic bg-white">
                                Aucune question trouvée pour ce quiz.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            <a href="homepageP.php" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-2">
                ← Retour au tableau de bord
            </a>
        </div>
    </div>

</body>
</html>