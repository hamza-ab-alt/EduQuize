<?php
session_start();
require "config/database.php";
require "src/entity/user.php";
$db = new Database();
$conn = $db->getConnection();
$error = "";
if (isset($_POST["register"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id)
                            VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $role]);
    $user=new User($name,$email,$role);
    $id=$conn->lastInsertId();
    $user->setId($id);
    $_SESSION["user"]=$user;
    if($role==1){
        header("Location:pages/prof/homepageP.php");
        exit();
    }else if($role==2){
       header("Location:pages/student/homepageS.php");
       exit();
    }
}
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user["password"])) {
        var_dump($user);
         $userO=new User($user["name"],$user["email"],$user["password"]);
         $userO->setId($user["id"]);
         if($user["role_id"]==1){
             header("Location:pages/prof/homepageP.php");
             exit();
         }elseif($user["role_id"]==2){
             header("Location:pages/student/homepageS.php");
             exit();
         }
    } else {
        $error = "Login incorrect";
    }
}
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

   
    <h2 class="text-xl font-bold mb-2">Register</h2>
    <form method="POST">

        <input name="name" placeholder="Name" class="border w-full p-2 mb-2">
        <input name="email" placeholder="Email" class="border w-full p-2 mb-2">
        <input type="password" name="password" placeholder="Password" class="border w-full p-2 mb-2">

        <select name="role" class="border w-full p-2 mb-2">
            <option value="1">Prof</option>
            <option value="2">Etudiant</option>
        </select>

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