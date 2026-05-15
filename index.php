<?php
session_start();
require "config/database.php";
$db = new Database();
$conn = $db->getConnection();
$error = "";
if (isset($_POST["register"])) {



if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        header("Location: index.php");
        exit;

    } else {
        $error = "Login incorrect";
    }
}

/* ================= LOGOUT ================= */
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

