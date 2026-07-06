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
            </div>
            <p class="school-hint">6 secciones de 1er año, 6 de 2do año y 6 de 3er año (A-F). Cada docente ve sus secciones asignadas; el listado completo está disponible para el director.</p>
            <div class="sections-grid" id="sectionsGrid">
                <div class="text-center" style="padding:20px;color:var(--text3);">Cargando secciones...</div>
            </div>
        </div>
