<?php

namespace App\Repository;

use App\Entity\Quiz;
use PDO;

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Entity/Quiz.php';

class QuizRepository {

    private $db;

    public function __construct() {
        $database = new \Database();
        $this->db = $database->getConnection();
    }

    public function findByCode($code) {
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE code_quiz = ?");
        $stmt->execute([$code]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Quiz(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['code_quiz']
            );
        }

        return null;
    }

    public function createQuiz(Quiz $quiz) {
        $stmt = $this->db->prepare(
            "INSERT INTO quizzes (title, description, code_quiz,user_id) VALUES (?, ?, ?,?)"
        );

        $stmt->execute([
            $quiz->title,
            $quiz->description,
            $quiz->code_quiz,
            1
        ]);
    }
}