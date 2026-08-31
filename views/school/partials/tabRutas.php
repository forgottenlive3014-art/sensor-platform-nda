        <div id="tab-routes" class="school-panel">
            <div class="school-panel-header">
                <h3>Rutas de Evacuación</h3>
                <?php if (!empty($isSchoolAdmin)): ?>
                <button class="school-btn primary" onclick="openAddRouteModal()">
                    Agregar Ruta
                </button>
                <?php endif; ?>
            </div>
            <div id="routesMap" style="height:320px;border-radius:10px;overflow:hidden;margin-bottom:14px;"></div>
            <div class="school-grid-2" id="routesContainer">
                <div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando rutas...</div>
            </div>
        </div>
