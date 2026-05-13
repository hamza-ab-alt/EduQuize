<?php
namespace App\Entity;

class Quiz {
    private $id;
    private $title;
    private $code_quiz;

    public function __construct($id, $title, $code_quiz) {
        $this->id = $id;
        $this->title = $title;
        $this->code_quiz = $code_quiz;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getCodeQuiz() { return $this->code_quiz; }
}