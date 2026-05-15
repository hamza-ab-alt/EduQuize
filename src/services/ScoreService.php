<?php
class ScoreService {
    private $pdo;
    private $repo;

    public function __construct($pdo, $repo) {
        $this->pdo = $pdo;
        $this->repo = $repo;
    }

    public function calculerEtSauvegarder($userId, $quizId, $userAnswers) {
        $correctPoints = 0;
        $totalQuestions = count($userAnswers);

        foreach ($userAnswers as $qId => $aId) {
            $stmt = $this->pdo->prepare("SELECT is_correct FROM answers WHERE id = ?");
            $stmt->execute([$aId]);
            if ($stmt->fetchColumn() == 1) {
                $correctPoints++;
            }
        }

        $scoreFinal = ($correctPoints / $totalQuestions) * 20;

        // تسجيل النتيجة والحصول على الـ ID
        $resultId = $this->repo->saveResult($userId, $quizId, $scoreFinal);

        // تسجيل كل جواب ديال الطالب
        foreach ($userAnswers as $qId => $aId) {
            $this->repo->saveStudentAnswer($resultId, $qId, $aId);
        }

        return $scoreFinal;
    }
}