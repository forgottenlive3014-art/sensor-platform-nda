        <div id="tab-attendance" class="school-panel">
            <div class="school-panel-header">
                <h3>Pase de Lista</h3>
                <div>
                    <select id="drillSelect" class="school-select">
                        <option value="">Seleccionar simulacro</option>
                    </select>
                    <button class="school-btn primary" onclick="loadAttendance()">
                        Cargar
                    </button>
                </div>
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Aula</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <tr><td colspan="4" class="text-center">Selecciona un simulacro para ver el pase de lista</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-attendance-actions" style="margin-top:12px;display:none;" id="attendanceActions">
                <button class="school-btn primary" onclick="saveAttendance()">
                    Guardar Asistencia
                </button>
            </div>
        </div>
