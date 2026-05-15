<?php
namespace App\Repository;
require "../entity/question.php";
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
    public function creatQuestion(Question $qestion){
        try {
            $sql="INSERT INTO questions(quiz_id,question) VALUES (?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$qestion->quiz_id,$qestion->question_text]);
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}