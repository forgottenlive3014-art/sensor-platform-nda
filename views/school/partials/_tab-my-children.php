        <!-- ========================================================== -->
        <!--  MIS HIJOS (solo Padre) -->
        <!-- ========================================================== -->
        <div id="tab-my-children" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">👪</span> Mis Hijos</h3>
                <button class="school-btn primary" onclick="openModal('sendChildrenNotifModal')">
                    <span class="school-emoji" aria-hidden="true">📣</span> Enviar aviso a mis hijos
                </button>
            </div>
            <p class="school-hint">Información de tus hijos vinculados en esta institución. Si falta alguno, pídele al director que lo vincule desde Padres.</p>
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
                <h3><span class="school-emoji" aria-hidden="true">🔔</span> Estado en el último simulacro</h3>
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

        <div class="school-modal" id="sendChildrenNotifModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Enviar aviso a mis hijos</h3>
                    <button class="school-modal-close" onclick="closeModal('sendChildrenNotifModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="sendChildrenNotifForm">
                        <div class="school-form-group">
                            <label>Mensaje * (máx. 255 caracteres)</label>
                            <textarea id="childrenNotifMessage" rows="3" maxlength="255" required></textarea>
                        </div>
                        <button type="submit" class="school-btn primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
