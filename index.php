<?php
session_start();
require "config/database.php";
$db = new Database();
$conn = $db->getConnection();
$error = "";
if (isset($_POST["register"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role)
                            VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $role]);
}


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

<!DOCTYPE html>
<html>
<head>
    <title>EduQuiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<div class="bg-white p-6 rounded-xl w-96">

<?php if (!isset($_SESSION["name"])): ?>

    <!-- LOGIN -->
    <h2 class="text-xl font-bold mb-2">Login</h2>

    <?php if ($error) echo "<p class='text-red-500'>$error</p>"; ?>

    <form method="POST">
        <input name="email" placeholder="Email" class="border w-full p-2 mb-2">
        <input type="password" name="password" placeholder="Password" class="border w-full p-2 mb-2">

        <button name="login" class="bg-blue-500 text-white w-full p-2">
            Login
        </button>
    </form>

    <hr class="my-4">

    <!-- REGISTER -->
    <h2 class="text-xl font-bold mb-2">Register</h2>

    <form method="POST">

      
    

        <button name="register" class="bg-green-500 text-white w-full p-2">
            Register
        </button>
    </form>

<?php else: ?>

  
    <h2 class="text-xl font-bold">
        Welcome <?= $_SESSION["name"] ?>
    </h2>

    <p>Role: <?= $_SESSION["role"] ?></p>

    <a href="?logout=1" class="text-red-500">Logout</a>

<?php endif; ?>

</div>

</body>
</html>