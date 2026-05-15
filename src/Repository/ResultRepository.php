<?php 
class ResultRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function saveResult($userId, $quizId, $score) {
        $stmt = $this->pdo->prepare("INSERT INTO results (user_id, quiz_id, score) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $quizId, $score]);
        return $this->pdo->lastInsertId(); 
    }
    public function saveStudentAnswer($resultId, $questionId, $answerId) {
        $stmt = $this->pdo->prepare("INSERT INTO student_answers (result_id, question_id, answer_id) VALUES (?, ?, ?)");
        $stmt->execute([$resultId, $questionId, $answerId]);
    }

    }