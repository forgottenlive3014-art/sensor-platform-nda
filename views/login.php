<?php
$title = $title ?? 'Login';
ob_start();
?>

<div class="min-h-screen flex items-center justify-center pt-16">
    <div class="bg-slate-800/50 backdrop-blur-lg p-8 rounded-2xl border border-slate-700 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="text-4xl mb-3"><i class="fa-solid fa-volcano"></i></div>
            <h1 class="text-2xl font-bold text-white">Login</h1>
            <p class="text-slate-400 text-sm">Sign in to your NDA account</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-2 rounded-lg mb-4">
                <i class="fa-regular fa-circle-xmark"></i> <?= e($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-2 rounded-lg mb-4">
                <i class="fa-regular fa-circle-check"></i> <?= e($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=login">
            <div class="mb-4">
                <label class="text-slate-300 text-sm block mb-1"><i class="fa-regular fa-envelope"></i> Email</label>
                <input type="email" name="email" required class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-orange-500">
            </div>
            <div class="mb-6">
                <label class="text-slate-300 text-sm block mb-1"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" name="password" required class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-orange-500">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-3 rounded-lg transition">
                <i class="fa-regular fa-right-to-bracket"></i> Login
            </button>
        </form>

        <p class="text-center text-slate-400 text-sm mt-4">
            Don't have an account? <a href="?url=register" class="text-orange-400 hover:text-orange-300">Register here</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>