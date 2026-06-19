<?php
$title = $title ?? 'School Module';
$user = $user ?? null;
$stats = $stats ?? [];
$students = $students ?? [];
ob_start();
?>

<div class="pt-20 container mx-auto px-4 py-8">
    <div class="bg-slate-800/50 backdrop-blur-lg rounded-2xl border border-slate-700 p-8">
        <div class="flex items-center gap-3 mb-6">
            <i class="fa-solid fa-school text-3xl text-orange-500"></i>
            <div>
                <h1 class="text-2xl font-bold text-white">School Module</h1>
                <p class="text-slate-400 text-sm">
                    <i class="fa-regular fa-user"></i> <?= e($user['name'] ?? 'User') ?>
                    <span class="ml-2 px-2 py-1 bg-orange-500/20 text-orange-400 rounded-lg text-xs">
                        <?= e($user['role'] ?? 'user') ?>
                    </span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-slate-700/50 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-orange-400"><?= $stats['students'] ?? 0 ?></div>
                <div class="text-slate-400 text-sm"><i class="fa-regular fa-user"></i> Students</div>
            </div>
            <div class="bg-slate-700/50 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-orange-400"><?= $stats['teachers'] ?? 0 ?></div>
                <div class="text-slate-400 text-sm"><i class="fa-regular fa-user-tie"></i> Teachers</div>
            </div>
            <div class="bg-slate-700/50 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-orange-400"><?= $stats['classrooms'] ?? 0 ?></div>
                <div class="text-slate-400 text-sm"><i class="fa-regular fa-building"></i> Classrooms</div>
            </div>
        </div>

        <h2 class="text-white font-bold text-lg mb-4"><i class="fa-regular fa-users"></i> Students List</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-700">
                        <th class="pb-2 text-slate-400 text-sm">ID</th>
                        <th class="pb-2 text-slate-400 text-sm">Name</th>
                        <th class="pb-2 text-slate-400 text-sm">Classroom</th>
                        <th class="pb-2 text-slate-400 text-sm">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr><td colspan="4" class="py-4 text-slate-400 text-center">No students found</td></tr>
                    <?php else: ?>
                        <?php foreach ($students as $s): ?>
                        <tr class="border-b border-slate-700/50">
                            <td class="py-2 text-slate-400"><?= e($s['estudiantes_id']) ?></td>
                            <td class="py-2 text-white"><?= e($s['nombre']) ?> <?= e($s['apellido'] ?? '') ?></td>
                            <td class="py-2 text-slate-300"><?= e($s['classroom'] ?? 'N/A') ?></td>
                            <td class="py-2">
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-lg text-xs">
                                    <i class="fa-regular fa-circle-check"></i> Active
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>