<?php
require_once '../../config/database.php';
require_once '../../src/Entity/Quiz.php';
require_once '../../src/Repository/QuizRepository.php';
require_once '../../src/Repository/QuestionRepository.php';
$database = new Database();
$db = $database->getConnection();

$quizRepo = new \App\Repository\QuizRepository($db);
$questionRepo = new \App\Repository\QuestionRepository($db);
$code = $_POST['quiz_code'] ?? '';
$quiz = $quizRepo->findByCode($code);
if (!$quiz) {
    die("Quiz introuvable ! <a href='homepageS.php'>Retour</a>");
}
$questions = $questionRepo->getQuestionsByQuiz($quiz->getId());
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>EduQuiz - <?php echo $quiz->getTitle(); ?></title>
</head>
<body class="bg-gray-50 min-h-screen p-6">

    <div class="max-w-3xl mx-auto">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-blue-700"><?php echo $quiz->getTitle(); ?></h1>
            <p class="text-gray-600">Répondez à toutes les questions avant de soumettre.</p>
        </header>

        <form action="submit_quiz.php" method="POST" class="space-y-6">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz->getId(); ?>">

            <?php foreach ($questions as $q_id => $q_data): ?>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <?php echo $q_data['text']; ?>
                    </h3>
                    
                    <div class="space-y-3">
                        <?php foreach ($q_data['answers'] as $ans): ?>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                                <input type="radio" name="question_<?php echo $q_id; ?>" value="<?php echo $ans['id']; ?>" class="h-4 w-4 text-blue-600" required>
                                <span class="ml-3 text-gray-700"><?php echo $ans['text']; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 shadow-lg transition">
                Soumettre mes réponses
            </button>
        </form>
    </div>

</body>
</html>
