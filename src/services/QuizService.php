<?php
// require "../Repository/QuizRepository.php";
use  App\Repository\QuizRepository;
function checkInsert($title,$descreption,$code){
    $rep=new QuizRepository();
    if($title=="" || $descreption=="" || $code==""){
        if($rep->findByCode($code)){
            header("Location:../../pages/homepageP.php?err=cexi");
            exit();
        }else{
             $rep->createQuiz(new Quiz(1,$title,$descreption,$code));
             header("Location:../../pages/homepageP.php");
             exit();
        }
    }else{
        header("Location:../../pages/homepageP.php?err=empty");
        exit();
    }
    
}