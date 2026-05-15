<?php
if(isset($_GET["id"])){
    $id=$_GET["id"];
    try {
        $sql="SELECT *  FROM quizzes q";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>