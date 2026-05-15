<?php
namespace App\Repository;
use App\Entity\Quiz;
use PDO;

class QuizRepository {
    private $db;

    public function __construct() {
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
    public function createQuiz(Quiz $quiz){
          try {
            $sql="INSERT INTO quizzes(title,description,code_quiz) VALUES(?,?,?)";
            $stm=$this->db->prepare($sql);
            $stm->execute([$quiz->title,$quiz->description,$quiz->code_quiz]);
          } catch (PDOException $e) {
             echo $e->getMessage();
          }
    }
}