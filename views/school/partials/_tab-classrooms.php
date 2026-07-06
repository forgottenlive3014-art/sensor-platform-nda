        <!-- ========================================================== -->
        <!--  AULAS -->
        <!-- ========================================================== -->
        <div id="tab-classrooms" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">🧱</span> Lista de Aulas</h3>
                <button class="school-btn primary" onclick="openModal('addClassroomModal')">
                    <span class="school-emoji" aria-hidden="true">➕</span> Agregar Aula
                </button>
            </div>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="classroomsSearch" class="school-select" placeholder="Buscar por nombre..." oninput="debounceClassroomsSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Grado</th>
                            <th>Nivel</th>
                            <th>Sección</th>
                            <th>Docente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="classroomsTableBody">
                        <tr><td colspan="6" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="classroomsPagination"></div>
        </div>
