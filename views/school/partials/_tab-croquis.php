        <!-- ========================================================== -->
        <!--  CROQUIS INTERACTIVO -->
        <!-- ========================================================== -->
        <div id="tab-croquis" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">📐</span> Croquis de la institución</h3>
                <?php if (!empty($isSchoolAdmin)): ?>
                <label class="school-btn secondary" style="cursor:pointer;">
                    <span class="school-emoji" aria-hidden="true">📥</span> <span id="croquisUploadLabel">Subir plano</span>
                    <input type="file" id="croquisUploadInput" accept="image/*" style="display:none" onchange="uploadCroquisImage(this)">
                </label>
                <button class="school-btn secondary" id="croquisDeleteBtn" style="display:none;color:var(--acc2);" onclick="deleteCroquisImage()">
                    <span class="school-emoji" aria-hidden="true">🗑️</span> Eliminar plano
                </button>
                <?php endif; ?>
            </div>
            <p class="school-hint">Puntos de encuentro, zonas seguras, extintores y botiquines. <?php if (!empty($isSchoolStaff)): ?>Haz clic sobre el plano para agregar un punto.<?php endif; ?></p>
            <div class="croquis-legend">
                <span><i class="croquis-dot encuentro"></i> Punto de encuentro</span>
                <span><i class="croquis-dot zona_segura"></i> Zona segura</span>
                <span><i class="croquis-dot zona_riesgo"></i> Zona de riesgo</span>
                <span><i class="croquis-dot extintor"></i> Extintor</span>
                <span><i class="croquis-dot botiquin"></i> Botiquín</span>
                <span><i class="croquis-dot salida"></i> Salida</span>
                <span><i class="croquis-dot otro"></i> Otro</span>
            </div>
            <div class="croquis-board" id="croquisBoard">
                <div class="text-center" style="padding:30px;color:var(--text3);">Cargando croquis...</div>
            </div>
        </div>
