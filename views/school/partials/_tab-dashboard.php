        <!-- ========================================================== -->
        <!--  DASHBOARD -->
        <!-- ========================================================== -->
        <div id="tab-dashboard" class="school-panel active">
            <div class="school-stats">
                <div class="school-stat">
                    <div class="school-stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 4h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="M9 12h6M9 16h6"/></svg></div>
                    <div class="school-stat-number"><?= $stats['students'] ?? 0 ?></div>
                    <div class="school-stat-label">Alumnos</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M3 9v6c0 1.5 4 3 9 3s9-1.5 9-3V9"/></svg></div>
                    <div class="school-stat-number"><?= $stats['teachers'] ?? 0 ?></div>
                    <div class="school-stat-label">Docentes</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 22h16M4 10h16M6 10V6l6-3 6 3v4M8 22v-8M12 22v-8M16 22v-8"/></svg></div>
                    <div class="school-stat-number"><?= $stats['classrooms'] ?? 0 ?></div>
                    <div class="school-stat-label">Aulas</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="1,6 8,3 16,6 23,3 23,18 16,21 8,18 1,21"/><line x1="8" y1="3" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="21"/></svg></div>
                    <div class="school-stat-number"><?= $stats['routes'] ?? 0 ?></div>
                    <div class="school-stat-label">Rutas</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg></div>
                    <div class="school-stat-number"><?= $stats['drills'] ?? 0 ?></div>
                    <div class="school-stat-label">Simulacros</div>
                </div>
                <div class="school-stat">
                    <div class="school-stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                    <div class="school-stat-number"><?= $stats['incidents'] ?? 0 ?></div>
                    <div class="school-stat-label">Incidentes</div>
                </div>
            </div>

            <div class="school-grid-2">
                <div class="school-card">
                    <h3>Últimos Alumnos</h3>
                    <table class="school-table">
                        <thead>
                            <tr><th>Nombre</th><th>Aula</th><th>Docente</th></tr>
                        </thead>
                        <tbody>
                            <?php if (empty($students)): ?>
                                <tr><td colspan="3" class="text-center">No hay alumnos registrados</td></tr>
                            <?php else: ?>
                                <?php foreach ($students as $s): ?>
                                    <tr>
                                        <td><?= e($s['nombre']) ?> <?= e($s['apellido'] ?? '') ?></td>
                                        <td><?= e($s['classroom'] ?? 'Sin aula') ?></td>
                                        <td><?= e($s['teacher'] ?? 'Sin asignar') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="school-card">
                    <h3>Últimos Simulacros</h3>
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
                    <h3>Últimos Incidentes</h3>
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
