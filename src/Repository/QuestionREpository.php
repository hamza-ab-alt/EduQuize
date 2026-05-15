<?php
namespace App\Repository;

require_once __DIR__ . "/../../config/database.php";
use PDO;
use PDOException;

class QuestionRepository {
    private $db;

    public function __construct() {
        $database = new \Database();
        $this->db = $database->getConnection();
    }

    public function getQuestionsByQuiz($quiz_id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE quiz_id = :qid");
        $stmt->execute(['qid' => $quiz_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createQuestion($quiz_id, $question_text) {
        try {
            $sql = "INSERT INTO questions (quiz_id, question) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$quiz_id, $question_text]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteQuestion($id) {
        try {
            $sql = "DELETE FROM questions WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}