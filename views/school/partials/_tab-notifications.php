        <!-- ========================================================== -->
        <!--  NOTIFICACIONES -->
        <!-- ========================================================== -->
        <div id="tab-notifications" class="school-panel">
            <div class="school-panel-header">
                <h3><span class="school-emoji" aria-hidden="true">🔔</span> Notificaciones enviadas</h3>
                <button class="school-btn primary" onclick="openModal('sendNotificationModal')">
                    <span class="school-emoji" aria-hidden="true">📣</span> Enviar notificación
                </button>
            </div>
            <p class="school-hint">Avisos enviados a la comunidad institucional (o de forma global, si eres Admin General).</p>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Mensaje</th>
                            <th>Severidad</th>
                            <th>Alcance</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="notificationsTableBody">
                        <tr><td colspan="5" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="notificationsPagination"></div>
        </div>

        <!-- Modal Enviar Notificación -->
        <div class="school-modal" id="sendNotificationModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Enviar notificación</h3>
                    <button class="school-modal-close" onclick="closeModal('sendNotificationModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="sendNotificationForm">
                        <div class="school-form-group">
                            <label>Mensaje * (máx. 255 caracteres)</label>
                            <textarea id="notificationMessage" rows="3" maxlength="255" required></textarea>
                        </div>
                        <div class="school-form-group">
                            <label>Severidad</label>
                            <select id="notificationSeverity">
                                <option value="informativo">Informativo</option>
                                <option value="seguro">Seguro</option>
                                <option value="precaucion">Precaución</option>
                                <option value="alerta">Alerta</option>
                                <option value="emergencia">Emergencia</option>
                            </select>
                        </div>
                        <div class="school-form-group">
                            <label>Destinatarios</label>
                            <select id="notificationTargetType" onchange="onNotificationTargetTypeChange()">
                                <option value="institucion">Institución completa</option>
                                <option value="rol">Rol específico</option>
                                <option value="usuarios">Usuarios determinados</option>
                            </select>
                        </div>
                        <div class="school-form-group" id="notificationGlobalGroup" style="display:none;">
                            <label><input type="checkbox" id="notificationGlobal"> Enviar a todo el sitio (global)</label>
                        </div>
                        <div class="school-form-group" id="notificationRoleGroup" style="display:none;">
                            <label>Rol</label>
                            <select id="notificationRole">
                                <option value="director">Admin Institucional</option>
                                <option value="docente">Docente</option>
                                <option value="alumno">Estudiante</option>
                                <option value="padre">Padre</option>
                                <option value="administrativo">Personal</option>
                            </select>
                        </div>
                        <div class="school-form-group" id="notificationUsersGroup" style="display:none;">
                            <label>IDs de usuario (separados por coma, ver pestaña Usuarios)</label>
                            <input type="text" id="notificationUserIds" placeholder="12, 45, 78">
                        </div>
                        <button type="submit" class="school-btn primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
