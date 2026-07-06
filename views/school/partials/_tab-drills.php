        <!-- ========================================================== -->
        <!--  SIMULACROS -->
        <!-- ========================================================== -->
        <div id="tab-drills" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">🔔</span> Simulacros</h3>
                <button class="school-btn primary" onclick="openModal('addDrillModal')">
                    <span class="school-emoji" aria-hidden="true">➕</span> Nuevo Simulacro
                </button>
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Asistencia</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="drillsTableBody">
                        <tr><td colspan="6" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
