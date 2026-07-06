        <!-- Solo visible para Admin General -->
        <div id="tab-institutions" class="school-panel">
            <div class="school-panel-header">
                <h3>Instituciones registradas</h3>
                <button class="school-btn primary" onclick="openModal('addInstitutionModal')">
                    Agregar Institución
                </button>
            </div>
            <p class="school-hint">Todas las instituciones dadas de alta en el sistema NDA.</p>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="institutionsSearch" class="school-select" placeholder="Buscar por nombre o correo..." oninput="debounceInstitutionsSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Usuarios</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="institutionsTableBody">
                        <tr><td colspan="6" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="institutionsPagination"></div>
        </div>

        <div class="school-modal" id="addInstitutionModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Agregar Institución</h3>
                    <button class="school-modal-close" onclick="closeModal('addInstitutionModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="addInstitutionForm">
                        <div class="school-form-group">
                            <label>Nombre *</label>
                            <input type="text" id="institutionName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Correo</label>
                            <input type="email" id="institutionEmail">
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="institutionPhone">
                        </div>
                        <div class="school-form-group">
                            <label>Dirección</label>
                            <input type="text" id="institutionAddress">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar Institución</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="school-modal" id="editInstitutionModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Editar Institución</h3>
                    <button class="school-modal-close" onclick="closeModal('editInstitutionModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="editInstitutionForm">
                        <input type="hidden" id="editInstitutionId">
                        <div class="school-form-group">
                            <label>Nombre *</label>
                            <input type="text" id="editInstitutionName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Correo</label>
                            <input type="email" id="editInstitutionEmail">
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="editInstitutionPhone">
                        </div>
                        <div class="school-form-group">
                            <label>Dirección</label>
                            <input type="text" id="editInstitutionAddress">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
