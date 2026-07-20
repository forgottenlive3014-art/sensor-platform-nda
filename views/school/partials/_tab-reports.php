        <!-- ========================================================== -->
        <!--  REPORTES -->
        <!-- ========================================================== -->
        <div id="tab-reports" class="school-panel">
            <div class="school-panel-header">
                <h3>Reportes</h3>
                <?php if (!empty($isSchoolAdmin)): ?>
                <button class="school-btn secondary" onclick="exportReport()">
                    Exportar
                </button>
                <?php endif; ?>
            </div>
            <div id="reportsContainer">
                <div class="text-center" style="padding:40px;color:var(--text3);">Cargando reportes...</div>
            </div>
        </div>
