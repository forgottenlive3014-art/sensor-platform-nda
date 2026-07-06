        <!-- ========================================================== -->
        <!--  ALUMNOS -->
        <!-- ========================================================== -->
        <div id="tab-students" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">🎒</span> Lista de Alumnos</h3>
                <button class="school-btn primary" onclick="openModal('addStudentModal')">
                    <span class="school-emoji" aria-hidden="true">➕</span> Agregar Alumno
                </button>
            </div>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="studentsSearch" class="school-select" placeholder="Buscar por nombre, apellido o código..." oninput="debounceStudentsSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Aula</th>
                            <th>Docente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">
                        <tr><td colspan="6" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="studentsPagination"></div>
        </div>
