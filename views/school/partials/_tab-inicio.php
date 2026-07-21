        <!-- ========================================================== -->
        <!--  INICIO (Pagina Principal): datos de la institucion, mapa, -->
        <!--  rutas y simulacros en solo lectura. -->
        <!-- ========================================================== -->
        <div id="tab-inicio" class="school-panel active">
            <div class="school-panel-header">
                <h3>Inicio</h3>
            </div>
            <?php if ($institucion): ?>
            <div class="school-card" style="margin-bottom:16px;">
                <h3><?= e($institucion['nombre']) ?></h3>
                <div class="school-stats" style="margin-top:0;">
                    <div class="school-stat">
                        <div class="school-stat-label">Tipo</div>
                        <div class="school-stat-number" style="font-size:1rem;"><?= e(ucfirst($institucion['tipo'] ?? '—')) ?></div>
                    </div>
                    <div class="school-stat">
                        <div class="school-stat-label">Teléfono</div>
                        <div class="school-stat-number" style="font-size:1rem;"><?= e($institucion['telefono'] ?? '—') ?></div>
                    </div>
                    <div class="school-stat">
                        <div class="school-stat-label">Dirección</div>
                        <div class="school-stat-number" style="font-size:0.85rem;"><?= e($institucion['direccion'] ?? '—') ?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="school-card" style="margin-bottom:16px;">
                <h3>Mapa de la institución</h3>
                <p class="school-hint">Ubicación real, rutas de evacuación y puntos del croquis. <?php if (!empty($isSchoolStaff)): ?>Haz clic en el mapa para agregar un punto ahí mismo.<?php endif; ?></p>
                <div id="inicioMap" style="height:360px;border-radius:10px;overflow:hidden;"></div>
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
        </div>
