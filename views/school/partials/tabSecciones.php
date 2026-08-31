        <div id="tab-sections" class="school-panel">
            <div class="school-panel-header">
                <h3>Secciones de Bachillerato</h3>
                <?php if (!empty($isSchoolStaff)): ?>
                <label class="school-toggle-all">
                    <input type="checkbox" id="sectionsShowAll" onchange="loadSections()"> Ver todas las secciones
                </label>
                <?php endif; ?>
            </div>
            <div class="school-panel-header" style="margin-top:0;">
                <div class="school-year-pager">
                    <button type="button" class="school-btn secondary" id="sectionsYearPrev" onclick="changeSectionsYear(-1)">&laquo; Anterior</button>
                    <span class="school-year-label" id="sectionsYearLabel">—</span>
                    <button type="button" class="school-btn secondary" id="sectionsYearNext" onclick="changeSectionsYear(1)">Siguiente &raquo;</button>
                </div>
            </div>
            <div class="sections-grid" id="sectionsGrid">
                <div class="text-center" style="padding:20px;color:var(--text3);">Cargando secciones...</div>
            </div>
        </div>
