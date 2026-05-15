<?php
namespace App\Entity;

class Answer {
    public $id;
    public $question_id;
    public $answer_text;
    public $is_correct;

    public function __construct($question_id , $answer_text , $is_correct ) {
        $this->question_id = $question_id;
        $this->answer_text = $answer_text;
        $this->is_correct = $is_correct;
    }
}