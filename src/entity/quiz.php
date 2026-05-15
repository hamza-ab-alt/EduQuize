<?php
namespace App\Entity;

class Quiz {
    public $id;
    public $title;
    public $description;
    public $code_quiz;

    public function __construct($id, $title, $code_quiz,$description) {
        $this->id = $id;
        $this->title = $title;
        $this->description=$description;
        $this->code_quiz = $code_quiz;
    }
}