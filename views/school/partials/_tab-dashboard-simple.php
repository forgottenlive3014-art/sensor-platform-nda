        <!-- ========================================================== -->
        <!--  DASHBOARD (solo lectura: estudiante / padre) -->
        <!-- ========================================================== -->
        <div id="tab-dashboard" class="school-panel active">
            <?php if (($user['role'] ?? '') === 'alumno'): ?>
            <div class="school-card" id="myClassroomCard" style="margin-bottom:16px;">
                <h3><span class="school-emoji" aria-hidden="true">🎒</span> Mi Aula</h3>
                <div id="myClassroomInfo" class="text-center" style="padding:10px;color:var(--text3);">Cargando...</div>
            </div>
            <?php endif; ?>
            <div class="school-stats">
                <div class="school-stat">
                    <div class="school-stat-icon"><span class="school-emoji" aria-hidden="true">🚸</span></div>
                    <div class="school-stat-number"><?= $stats['routes'] ?? 0 ?></div>
                    <div class="school-stat-label">Rutas</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><span class="school-emoji" aria-hidden="true">🔔</span></div>
                    <div class="school-stat-number"><?= $stats['drills'] ?? 0 ?></div>
                    <div class="school-stat-label">Simulacros</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><span class="school-emoji" aria-hidden="true">🧯</span></div>
                    <div class="school-stat-number"><?= $stats['incidents'] ?? 0 ?></div>
                    <div class="school-stat-label">Incidentes abiertos</div>
                </div>
            </div>

            <div class="school-grid-2">
                <div class="school-card">
                    <h3>Rutas de Evacuación</h3>
                    <table class="school-table">
                        <thead>
                            <tr><th>Nombre</th><th>Estado</th></tr>
                        </thead>
                        <tbody>
                            <?php if (empty($routes)): ?>
                                <tr><td colspan="2" class="text-center">No hay rutas registradas</td></tr>
                            <?php else: ?>
                                <?php foreach ($routes as $r): ?>
                                    <tr>
                                        <td><?= e($r['nombre']) ?></td>
                                        <td><span class="school-route-status <?= $r['estado'] ?? 'despejada' ?>"><?= e($r['estado'] ?? 'Despejada') ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="school-card">
                    <h3>Próximos Simulacros</h3>
                    <table class="school-table">
                        <thead>
                            <tr><th>Nombre</th><th>Fecha</th><th>Hora</th></tr>
                        </thead>
                        <tbody>
                            <?php if (empty($drills)): ?>
                                <tr><td colspan="3" class="text-center">No hay simulacros registrados</td></tr>
                            <?php else: ?>
                                <?php foreach ($drills as $d): ?>
                                    <tr>
                                        <td><?= e($d['nombre']) ?></td>
                                        <td><?= e($d['fecha'] ?? '') ?></td>
                                        <td><?= e($d['hora'] ?? '') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="school-grid-2" style="margin-top:20px;">
                <div class="school-card" style="grid-column:1/-1;">
                    <h3>Últimos Incidentes reportados</h3>
                    <table class="school-table">
                        <thead>
                            <tr><th>Tipo</th><th>Ubicación</th><th>Fecha</th></tr>
                        </thead>
                        <tbody>
                            <?php if (empty($incidents)): ?>
                                <tr><td colspan="3" class="text-center">No hay incidentes reportados</td></tr>
                            <?php else: ?>
                                <?php foreach ($incidents as $i): ?>
                                    <tr>
                                        <td><?= e($i['tipo'] ?? '') ?></td>
                                        <td><?= e($i['ubicacion'] ?? '—') ?></td>
                                        <td><?= !empty($i['created_at']) ? date('d/m/Y', strtotime($i['created_at'])) : '—' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
