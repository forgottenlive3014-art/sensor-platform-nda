        <!-- ========================================================== -->
        <!--  NOTIFICAR A MIS ALUMNOS (solo Docente, Panel de Gestión) -->
        <!-- ========================================================== -->
        <div id="tab-teacher-notify" class="school-panel">
            <div class="school-panel-header">
                <h3>Notificar a mis alumnos</h3>
            </div>
            <p class="school-hint">Envía un aviso o recordatorio a todos los alumnos de tus secciones asignadas.</p>
            <div class="school-card">
                <form id="notifyStudentsForm">
                    <div class="school-form-group">
                        <label>Mensaje *</label>
                        <textarea id="notifyStudentsMessage" rows="3" maxlength="255" placeholder="Escribe el aviso o recordatorio..." required></textarea>
                    </div>
                    <div class="school-form-group">
                        <label>Severidad</label>
                        <select id="notifyStudentsSeveridad">
                            <option value="informativo" selected>Informativo</option>
                            <option value="seguro">Seguro</option>
                            <option value="precaucion">Precaución</option>
                            <option value="alerta">Alerta</option>
                            <option value="emergencia">Emergencia</option>
                        </select>
                    </div>
                    <button type="submit" class="school-btn primary">Enviar a mis alumnos</button>
                </form>
            </div>
        </div>
