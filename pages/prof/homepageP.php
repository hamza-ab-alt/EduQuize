<?php
require_once "../../config/database.php";
$D = new Database();
$conn = $D->getConnection();
try {
    $sql = "SELECT * FROM quizzes WHERE user_id=?";
    $stm = $conn->prepare($sql);
    $stm->execute([1]);
    $quizes = $stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["delete"])){
   $id=$_POST["delete"];
   try {
    $sql="DELETE FROM quizzes WHERE id =? ";
    $stm=$conn->prepare($sql);
    $stm->execute([$id]);
    header("Location:homepageP.php");
   } catch (PDOException $e) {
     echo $e->getMessage();
   }
}
if(isset($_POST["update"])){
    $id=$_POST["update"];
    header("Location: updateQuiz.php?id=$id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Prof Dashboard | Quizzes</title>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back, Professor! 👋</h1>
                <p class="text-gray-500 mt-1 text-lg">Here's an overview of the quizzes you've created.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="createQuiz.php" method="post">
                    <button class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-lg shadow-indigo-200" name="addQ" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add New Quiz
                    </button>
                </form>
            </div>
        </div>
        <?php
            if(isset($_GET["err"]) && $_GET["err"]=="cexi"){
               ?>
              <div class="bg-red-100 text-red-700 p-3 rounded">
                <p>
                    <span class="font-bold">Error:</span>
                    A quiz with this code already exists.
                </p>
              </div>
               <?php
            }
            ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach ($quizes as $quiz): ?>
                <div class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-indigo-400 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2 truncate"><?= htmlspecialchars($quiz["title"]) ?></h2>
                    <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                        <?= htmlspecialchars($quiz["description"] ?: "No description provided for this quiz.") ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Quiz Management List</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">code</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php foreach ($quizes as $quiz): ?>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-md">#<?= $quiz["id"] ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($quiz["title"]) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs truncate"><?= htmlspecialchars($quiz["description"]) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs truncate"><?= htmlspecialchars($quiz["code_quiz"]) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <form action="#" method="post" class="flex justify-center items-center gap-2">
                                    <button name="update" value="<?= $quiz["id"] ?>" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-all" title="Edit Quiz">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <button name="delete" value="<?= $quiz["id"] ?>" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Delete Quiz">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($quizes)): ?>
                <div class="text-center py-12">
                    <p class="text-gray-400 italic text-lg">You haven't created any quizzes yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>