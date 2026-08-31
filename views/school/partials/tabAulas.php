        <!-- ========================================================== -->
        <!--  AULAS (director): 6 recuadros (A-F) por año, con
              Anterior/Siguiente para moverse entre 1°, 2° y 3° año -->
        <!-- ========================================================== -->
        <div id="tab-classrooms" class="school-panel">
            <div class="school-panel-header">
                <h3>Aulas</h3>
                <div class="school-year-pager">
                    <button type="button" class="school-btn secondary" id="classroomsYearPrev" onclick="changeClassroomsYear(-1)">&laquo; Anterior</button>
                    <span class="school-year-label" id="classroomsYearLabel">—</span>
                    <button type="button" class="school-btn secondary" id="classroomsYearNext" onclick="changeClassroomsYear(1)">Siguiente &raquo;</button>
                </div>
            </div>
            <div class="sections-grid" id="classroomsSectionsGrid">
                <div class="text-center" style="padding:20px;color:var(--text3);">Cargando...</div>
            </div>
        </div>
