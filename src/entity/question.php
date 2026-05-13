<?php
namespace App\Entity;

class Question {
    public $id;
    public $question_text;

    public function __construct($id, $question_text) {
        $this->id = $id;
        $this->question_text = $question_text;
    }
}