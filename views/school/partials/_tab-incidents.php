        <div id="tab-incidents" class="school-panel">
            <div class="school-panel-header">
                <h3>Incidentes</h3>
                <button class="school-btn primary" onclick="openModal('addIncidentModal')">
                    Reportar Incidente
                </button>
            </div>
            <div class="school-filters" id="incidentsFilters">
                <button class="sfilter active" data-cat="all">Todos</button>
                <button class="sfilter" data-cat="Ruta bloqueada">Ruta bloqueada</button>
                <button class="sfilter" data-cat="Objeto caído">Objeto caído</button>
                <button class="sfilter" data-cat="Alumno lesionado">Alumno lesionado</button>
                <button class="sfilter" data-cat="Espacio dañado">Espacio dañado</button>
                <button class="sfilter" data-cat="Falla estructural">Falla estructural</button>
                <button class="sfilter" data-cat="Otro">Otro</button>
            </div>
            <div class="school-incident-list" id="incidentList">
                <div class="text-center" style="padding:20px;color:var(--text3);">Cargando incidentes...</div>
            </div>
        </div>
