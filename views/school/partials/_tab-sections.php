        <!-- ========================================================== -->
        <!--  SECCIONES (18 aulas: 1°-3° A-F) -->
        <!-- ========================================================== -->
        <div id="tab-sections" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">🧩</span> Secciones de Bachillerato</h3>
                <?php if (!empty($isSchoolStaff)): ?>
                <label class="school-toggle-all">
                    <input type="checkbox" id="sectionsShowAll" onchange="loadSections()"> Ver todas las secciones
                </label>
                <?php endif; ?>
                <?php if (($user['role'] ?? '') === 'docente'): ?>
                <button class="school-btn primary" onclick="openModal('sendStudentsNotifModal')">
                    <span class="school-emoji" aria-hidden="true">📣</span> Enviar aviso a mis alumnos
                </button>
                <?php endif; ?>
            </div>
            <p class="school-hint">6 secciones de 1er año, 6 de 2do año y 6 de 3er año (A-F). Cada docente ve sus secciones asignadas; el listado completo está disponible para el director.</p>
            <div class="sections-grid" id="sectionsGrid">
                <div class="text-center" style="padding:20px;color:var(--text3);">Cargando secciones...</div>
            </div>
        </div>

        <?php if (($user['role'] ?? '') === 'docente'): ?>
        <div class="school-modal" id="sendStudentsNotifModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Enviar aviso a mis alumnos</h3>
                    <button class="school-modal-close" onclick="closeModal('sendStudentsNotifModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="sendStudentsNotifForm">
                        <div class="school-form-group">
                            <label>Mensaje * (máx. 255 caracteres)</label>
                            <textarea id="studentsNotifMessage" rows="3" maxlength="255" required></textarea>
                        </div>
                        <button type="submit" class="school-btn primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
