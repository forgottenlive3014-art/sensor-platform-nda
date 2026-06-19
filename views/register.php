<?php
$title = $title ?? 'Register';
ob_start();
?>

<div class="min-h-screen flex items-center justify-center pt-16">
    <div class="bg-slate-800/50 backdrop-blur-lg p-8 rounded-2xl border border-slate-700 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="text-4xl mb-3"><i class="fa-solid fa-volcano"></i></div>
            <h1 class="text-2xl font-bold text-white">Create Account</h1>
            <p class="text-slate-400 text-sm">Register for NDA</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-2 rounded-lg mb-4">
                <i class="fa-regular fa-circle-xmark"></i> <?= e($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=register">
            <div class="mb-4">
                <label class="text-slate-300 text-sm block mb-1"><i class="fa-regular fa-user"></i> Full Name</label>
                <input type="text" name="name" required class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-orange-500">
            </div>
            <div class="mb-4">
                <label class="text-slate-300 text-sm block mb-1"><i class="fa-regular fa-envelope"></i> Email</label>
                <input type="email" name="email" required class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-orange-500">
            </div>
            <div class="mb-4">
                <label class="text-slate-300 text-sm block mb-1"><i class="fa-solid fa-lock"></i> Password (min 6 characters)</label>
                <input type="password" name="password" required minlength="6" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-orange-500">
            </div>
            <div class="mb-6">
                <label class="text-slate-300 text-sm block mb-1"><i class="fa-regular fa-id-card"></i> Role</label>
                <select name="role" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-orange-500">
                    <option value="user">User</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-3 rounded-lg transition">
                <i class="fa-regular fa-user-plus"></i> Create Account
            </button>
        </form>

        <p class="text-center text-slate-400 text-sm mt-4">
            Already have an account? <a href="?url=login" class="text-orange-400 hover:text-orange-300">Login here</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>