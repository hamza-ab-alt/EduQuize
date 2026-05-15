<?php
namespace App\Repository;

require_once __DIR__ . "/../../config/database.php";
use PDO;
use PDOException;

class AnswerRepository {
    private $db;

    public function __construct() {
        $database = new \Database();
        $this->db = $database->getConnection();
    }
    public function getAnswersByQuestion($question_id) {
        $stmt = $this->db->prepare("SELECT * FROM answers WHERE question_id = :qid");
        $stmt->execute(['qid' => $question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAnswer($question_id, $answer_text, $is_correct = 0) {
        try {
            $sql = "INSERT INTO answers (question_id, answer, is_correct) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$question_id, $answer_text, $is_correct]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function deleteAnswer($id) {
        try {
            $sql = "DELETE FROM answers WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}