        <!-- ========================================================== -->
        <!--  PERSONAL ADMINISTRATIVO -->
        <!-- ========================================================== -->
        <div id="tab-staff" class="school-panel">
            <div class="school-panel-header">
                <h3>Personal Administrativo</h3>
                <button class="school-btn primary" onclick="openModal('addStaffModal')">
                    Agregar Personal
                </button>
            </div>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="staffSearch" class="school-select" placeholder="Buscar por nombre o correo..." oninput="debounceStaffSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="staffTableBody">
                        <tr><td colspan="4" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="staffPagination"></div>
        </div>

        <!-- Modal Agregar Personal -->
        <div class="school-modal" id="addStaffModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Agregar Personal</h3>
                    <button class="school-modal-close" onclick="closeModal('addStaffModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="addStaffForm">
                        <div class="school-form-group">
                            <label>Nombre completo *</label>
                            <input type="text" id="staffName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Correo *</label>
                            <input type="email" id="staffEmail" required>
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="staffPhone">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Personal -->
        <div class="school-modal" id="editStaffModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Editar Personal</h3>
                    <button class="school-modal-close" onclick="closeModal('editStaffModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="editStaffForm">
                        <input type="hidden" id="editStaffId">
                        <div class="school-form-group">
                            <label>Nombre completo *</label>
                            <input type="text" id="editStaffName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="editStaffPhone">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
