<?php

namespace App\Services;

use App\Repository\QuizRepository;
use App\Entity\Quiz;

require_once __DIR__ . '/../Repository/QuizRepository.php';
require_once __DIR__ . '/../Entity/Quiz.php';

class QuizService {

    private $rep;

    public function __construct() {
        $this->rep = new QuizRepository();
    }

    public function checkInsert($title, $description, $code) {

        if (!empty($title) && !empty($description) && !empty($code)) {

            if ($this->rep->findByCode($code)) {
                header("Location: ../../pages/prof/homepageP.php?err=exists");
                exit();
            }

            $quiz = new Quiz(null, $title, $description, $code);
            $this->rep->createQuiz($quiz);

            header("Location: ../../pages/prof/homepageP.php?success=1");
            exit();

        } else {
            header("Location: ../../pages/prof/homepageP.php?err=empty");
            exit();
        }
    }
}