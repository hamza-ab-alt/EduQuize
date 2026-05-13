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

