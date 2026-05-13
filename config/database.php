<?php
declare(strict_types=1);

namespace App\Repository;

use Config\Database;
use App\Entity\Quiz;
use PDO;

class QuizRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByCode(string $code): ?Quiz {
        $query = "SELECT * FROM quizzes WHERE code_unique = :code LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['code' => $code]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Quiz((int)$data['id'], $data['titre'], $data['code_unique']);
    }
}