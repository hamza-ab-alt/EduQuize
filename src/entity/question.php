<?php
namespace App\Entity;

class Question {
    public $id;
    public $question_text;
    public $quiz_id;
    public function __construct($id, $question_text,$quiz_id) {
        $this->id = $id;
        $this->question_text = $question_text;
        $this->$quiz_id=$quiz_id;
    }
}
