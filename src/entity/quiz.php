<?php
namespace App\Entity;

class Quiz {
    public $id;
    public $title;
    public $code_quiz;

    public function __construct($id, $title, $code_quiz) {
        $this->id = $id;
        $this->title = $title;
        $this->code_quiz = $code_quiz;
    }
}