<?php
function connection(){
    try {
        return $pdo=new PDO("mysql:host=localhost;dbname=quiz","root","");
    } catch (PDOExcpetion $e) {
        return  $e->getMessage();
    }
}
