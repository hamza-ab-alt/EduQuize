<?php 
class ResultRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    }