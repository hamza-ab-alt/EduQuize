<?php
namespace App\Repository;

use App\Entity\Quiz;
use PDO;

class QuizRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByCode($code) {
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE code_quiz = :code LIMIT 1");
        $stmt->execute(['code' => $code]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Quiz($row['id'], $row['title'], $row['code_quiz']);
        }
        return null;
    }
}