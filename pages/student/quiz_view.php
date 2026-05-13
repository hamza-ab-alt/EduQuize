<?php
require_once '../../config/database.php';
require_once '../../src/Entity/Quiz.php';
require_once '../../src/Entity/Question.php';
require_once '../../src/Repository/QuizRepository.php';
require_once '../../src/Repository/QuestionREpository.php';

use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;

$database = new Database();
$db = $database->getConnection();

$quizRepo = new QuizRepository($db);
$questionRepo = new QuestionRepository($db);

$code = $_POST['quiz_code'] ?? 'PHP2026';
$quiz = $quizRepo->findByCode($code);

if (!$quiz) {
    die("Erreur: Quiz introuvable.");
}

$questions = $questionRepo->getQuestionsByQuiz($quiz->id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>EduQuiz - <?php echo htmlspecialchars($quiz->title); ?></title>
</head>
<body class="bg-slate-50 min-h-screen py-10 px-4">

    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight"><?php echo $quiz->title; ?></h1>
                <p class="text-indigo-600 font-medium text-sm flex items-center gap-2 mt-1">
                    <i class="fas fa-hashtag text-xs"></i> Code: <?php echo $quiz->code_quiz; ?>
                </p>
            </div>
            <div class="hidden sm:block text-right">
                <span class="text-xs text-slate-400 uppercase font-bold tracking-widest">Status</span>
                <p class="text-emerald-500 font-bold flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> En cours
                </p>
            </div>
        </div>

        <!-- Quiz Form -->
        <form action="submit_quiz.php" method="POST" class="space-y-6">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz->id; ?>">

            <?php foreach ($questions as $index => $q): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:border-indigo-200 transition-colors">
                    <div class="bg-slate-50 px-6 py-3 border-b border-slate-100 flex items-center gap-3">
                        <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">
                            <?php echo $index + 1; ?>
                        </span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Question</span>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-lg font-bold text-slate-800 mb-6"><?php echo $q['question']; ?></p>
                        
                        <div class="grid gap-3">
                            <?php 
                            $answers = $questionRepo->getAnswersByQuestion($q['id']);
                            foreach ($answers as $ans): 
                            ?>
                                <label class="group flex items-center p-4 border border-slate-100 rounded-xl cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition-all active:bg-indigo-100">
                                    <input type="radio" name="question_<?php echo $q['id']; ?>" value="<?php echo $ans['id']; ?>" required
                                        class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                    <span class="ml-4 text-slate-700 group-hover:text-indigo-900 transition-colors font-medium">
                                        <?php echo $ans['answer']; ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-6">
                <button type="submit" 
                    class="w-full bg-slate-900 hover:bg-black text-white font-extrabold py-5 rounded-2xl shadow-xl transition-all flex items-center justify-center gap-3 group">
                    <span>Valider mes réponses</span>
                    <i class="fas fa-paper-plane transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                </button>
            </div>
        </form>

        <footer class="mt-12 text-center text-slate-400 text-sm">
            <p>&copy; 2026 EduQuize Assessment Platform. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>