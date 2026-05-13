<?php
namespace App\Repository;

use PDO;

class QuestionRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getQuestionsByQuiz($quiz_id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE quiz_id = :qid");
        $stmt->execute(['qid' => $quiz_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnswersByQuestion($question_id) {
        $stmt = $this->db->prepare("SELECT * FROM answers WHERE question_id = :qid");
        $stmt->execute(['qid' => $question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}