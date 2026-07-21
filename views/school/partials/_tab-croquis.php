        <!-- ========================================================== -->
        <!--  CROQUIS INTERACTIVO -->
        <!-- ========================================================== -->
        <div id="tab-croquis" class="school-panel">
            <div class="school-panel-header">
                <h3>Croquis de la institución</h3>
                <?php if (!empty($isSchoolAdmin)): ?>
                <label class="school-btn secondary" style="cursor:pointer;">
                    Subir plano
                    <input type="file" id="croquisUploadInput" accept="image/*" style="display:none" onchange="uploadCroquisImage(this)">
                </label>
                <?php endif; ?>
            </div>
            <p class="school-hint">Puntos de encuentro, zonas seguras, extintores y botiquines. <?php if (!empty($isSchoolStaff)): ?>Haz clic sobre el plano para agregar un punto.<?php endif; ?></p>
            <div class="croquis-legend">
                <span><i class="croquis-dot encuentro"></i> Punto de encuentro</span>
                <span><i class="croquis-dot zona_segura"></i> Zona segura</span>
                <span><i class="croquis-dot extintor"></i> Extintor</span>
                <span><i class="croquis-dot botiquin"></i> Botiquín</span>
                <span><i class="croquis-dot salida"></i> Salida</span>
                <span><i class="croquis-dot otro"></i> Otro</span>
            </div>

            <div style="display:flex;gap:8px;margin-bottom:10px;">
                <button type="button" class="school-btn secondary" data-croquis-view="2d" onclick="showCroquisView('2d')" style="opacity:1;">Vista 2D</button>
                <button type="button" class="school-btn secondary" data-croquis-view="map" onclick="showCroquisView('map')" style="opacity:0.6;">Vista en mapa real</button>
            </div>

            <div id="croquisView2d">
                <div class="croquis-board" id="croquisBoard">
                    <div class="text-center" style="padding:30px;color:var(--text3);">Cargando croquis...</div>
                </div>
            </div>

            <div id="croquisViewMap" style="display:none;">
                <p class="school-hint" id="croquisMapHint">Cargando mapa...</p>
                <div id="croquisMap" style="height:420px;border-radius:10px;overflow:hidden;"></div>
            </div>
        </div>
