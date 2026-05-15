<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>EduQuiz - Welcome</title>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 border border-slate-100">
        <div class="text-center mb-8">
            <div class="bg-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                <i class="fas fa-graduation-cap text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800">EduQuiz</h1>
            <p class="text-slate-500 mt-2">enter your quiz code to begin</p>
        </div>

        <!-- Form -->
        <form action="quiz_view.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Quiz Code</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="text" name="quiz_code" placeholder="Ex: PHP2026" required
                        class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all uppercase tracking-widest font-bold text-slate-700">
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-100 transform transition-active active:scale-95 flex items-center justify-center gap-2">
                <span>Start Quiz</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 mt-8 uppercase tracking-widest">Powered by EduQuiz Platform</p>
    </div>

</body>
</html>