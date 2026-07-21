        <!-- ========================================================== -->
        <!--  MIS HIJOS (solo Padre) -->
        <!-- ========================================================== -->
        <div id="tab-my-children" class="school-panel">
            <div class="school-panel-header">
                <h3>Mis Hijos</h3>
            </div>
            <p class="school-hint">Información de tus hijos vinculados en esta institución. Si falta alguno, pídele al director que lo vincule desde Padres.</p>

            <div class="school-card" style="margin-bottom:16px;">
                <h3>Notificar a mis hijos</h3>
                <form id="notifyChildrenForm">
                    <div class="school-form-group">
                        <label>Mensaje *</label>
                        <textarea id="notifyChildrenMessage" rows="2" maxlength="255" placeholder="Escribe un aviso o recordatorio..." required></textarea>
                    </div>
                    <div class="school-form-group">
                        <label>Severidad</label>
                        <select id="notifyChildrenSeveridad">
                            <option value="informativo" selected>Informativo</option>
                            <option value="seguro">Seguro</option>
                            <option value="precaucion">Precaución</option>
                            <option value="alerta">Alerta</option>
                            <option value="emergencia">Emergencia</option>
                        </select>
                    </div>
                    <button type="submit" class="school-btn primary">Enviar a mis hijos</button>
                </form>
            </div>

            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Aula</th>
                            <th>Docente</th>
                        </tr>
                    </thead>
                    <tbody id="myChildrenTableBody">
                        <tr><td colspan="4" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="school-card" style="margin-top:20px;">
                <h3>Estado en el último simulacro</h3>
                <div class="school-table-wrap">
                    <table class="school-table">
                        <thead>
                            <tr><th>Hijo/a</th><th>Simulacro</th><th>Estado</th></tr>
                        </thead>
                        <tbody id="myChildrenStatusBody">
                            <tr><td colspan="3" class="text-center">Cargando...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
