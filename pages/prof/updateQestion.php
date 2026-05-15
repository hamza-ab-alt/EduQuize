<?php
require_once __DIR__ . "/../../src/Repository/AnswerRespository.php";
require_once __DIR__ . "/../../src/Repository/QuestionRepository.php";
require_once __DIR__ . "/../../config/database.php";
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;

$AR = new AnswerRepository();
$question_id = $_GET["id"] ?? null;

if (!$question_id) die("ID Question introuvable!");

if (isset($_POST['add_answer'])) {
    $text = $_POST['answer_text'];
    $correct = isset($_POST['is_correct']) ? 1 : 0;
    $AR->createAnswer($question_id, $text, $correct);
    header("Location: updateQestion.php?id=" . $question_id);
    exit;
}

if (isset($_POST['delete_id'])) {
    $AR->deleteAnswer($_POST['delete_id']);
    header("Location: updateQestion.php?id=" . $question_id);
    exit;
}

$answers = $AR->getAnswersByQuestion($question_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gérer les Réponses</title>
</head>
<body class="bg-gray-50 p-6 md:p-12">

    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Réponses pour la Question #<?php echo htmlspecialchars($question_id); ?></h1>
        <div class="bg-white p-6 rounded-xl shadow-sm border mb-8">
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle Réponse</label>
                    <input type="text" name="answer_text" required placeholder="Texte de la réponse..." 
                           class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_correct" id="correct" class="w-4 h-4 text-blue-600 rounded">
                    <label for="correct" class="ml-2 text-sm text-gray-600">Marquer comme réponse correcte</label>
                </div>
                <button type="submit" name="add_answer" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Ajouter la réponse
                </button>
            </form>
        </div>
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Réponse</th>
                        <th class="px-6 py-3 text-center">Correcte?</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php foreach ($answers as $ans): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($ans['answer']); ?></td>
                        <td class="px-6 py-4 text-center">
                            <?php if($ans['is_correct']): ?>
                                <span class="text-green-600 font-bold">✔ Oui</span>
                            <?php else: ?>
                                <span class="text-gray-400">Non</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" onsubmit="return confirm('Supprimer?');">
                                <input type="hidden" name="delete_id" value="<?php echo $ans['id']; ?>">
                                <button type="submit" class="text-red-500 hover:underline font-medium">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <a href="updateQuiz.php?id=1" class="text-blue-600 hover:underline">← Retour aux questions</a>
        </div>
    </div>

</body>
</html>