<?php



require_once '../../config/database.php'; 
require_once '../../src/Repository/ResultRepository.php';

session_start();

$db = new Database(); 
$pdo = $db->getConnection(); 

if (!$pdo) {
    die("Erreur : La connexion à la base de données a échoué.");
}

$repo = new ResultRepository($pdo);



session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // تأكد أن البيانات واصلة من عند صحابك
    $userId = $_SESSION['user_id'];
    $quizId = $_POST['quiz_id'];
    $userAnswers = $_POST['answers']; // مصفوفة فيها [question_id => answer_id]

    $correctPoints = 0;
    $totalQuestions = count($userAnswers);

    // 2. المحرّك (Logic) - حساب شحال من جواب صحيح
    foreach ($userAnswers as $qId => $aId) {
        $stmt = $pdo->prepare("SELECT is_correct FROM answers WHERE id = ?");
        $stmt->execute([$aId]);
        if ($stmt->fetchColumn() == 1) {
            $correctPoints++;
        }
    }

    // حساب النقطة على 20
    $scoreFinal = ($correctPoints / $totalQuestions) * 20;

    // 3. التسجيل - عيط للخزنة (Repository) لي صاوبتي
    $repo = new ResultRepository($pdo);
    $resultId = $repo->saveResult($userId, $quizId, $scoreFinal);

    // تسجيل التفاصيل (مهمة لـ User Story 2)
    foreach ($userAnswers as $qId => $aId) {
        $repo->saveStudentAnswer($resultId, $qId, $aId);
    }

    // 4. التوجيه لصفحة العرض (Affichage)
    // غنصيفطو النتيجة فـ Session أو فـ URL باش تبان للطالب
    $_SESSION['last_score'] = $scoreFinal;
    $_SESSION['last_result_id'] = $resultId;
    
    header("Location: ../resultat_view.php"); // كترجع بـ dossier واحد لـ pages
    exit();
}