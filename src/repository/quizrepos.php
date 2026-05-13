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
        $query = "SELECT * FROM quizes WHERE code_quiz = :code LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $data = $stmt->fetch();
        if ($data) {
            return new Quiz((int)$data['id'], $data['title'], $data['code_quiz']);
        }
        return null;
    }
}