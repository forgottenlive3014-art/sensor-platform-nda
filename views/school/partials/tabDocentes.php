        <div id="tab-teachers" class="school-panel">
            <div class="school-panel-header">
                <h3>Lista de Docentes</h3>
                <button class="school-btn primary" onclick="openModal('addTeacherModal')">
                    Agregar Docente
                </button>
            </div>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="teachersSearch" class="school-select" placeholder="Buscar por nombre o correo..." oninput="debounceTeachersSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Materia</th>
                            <th>Aula(s)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="teachersTableBody">
                        <tr><td colspan="5" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="teachersPagination"></div>
        </div>
