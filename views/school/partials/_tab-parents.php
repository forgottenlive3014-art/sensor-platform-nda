        <!-- ========================================================== -->
        <!--  PADRES / MADRES -->
        <!-- ========================================================== -->
        <div id="tab-parents" class="school-panel">
            <div class="school-panel-header">
                <h3>Padres / Madres</h3>
                <button class="school-btn primary" onclick="openModal('addParentModal')">
                    Agregar Padre/Madre
                </button>
            </div>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="parentsSearch" class="school-select" placeholder="Buscar por nombre o correo..." oninput="debounceParentsSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Hijos vinculados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="parentsTableBody">
                        <tr><td colspan="4" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="parentsPagination"></div>
        </div>

        <!-- Modal Agregar Padre/Madre -->
        <div class="school-modal" id="addParentModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Agregar Padre/Madre</h3>
                    <button class="school-modal-close" onclick="closeModal('addParentModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="addParentForm">
                        <div class="school-form-group">
                            <label>Nombre completo *</label>
                            <input type="text" id="parentName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Correo *</label>
                            <input type="email" id="parentEmail" required>
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="parentPhone">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Padre/Madre -->
        <div class="school-modal" id="editParentModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Editar Padre/Madre</h3>
                    <button class="school-modal-close" onclick="closeModal('editParentModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="editParentForm">
                        <input type="hidden" id="editParentId">
                        <div class="school-form-group">
                            <label>Nombre completo *</label>
                            <input type="text" id="editParentName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="editParentPhone">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Vincular Hijo -->
        <div class="school-modal" id="linkChildModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Vincular hijo/a</h3>
                    <button class="school-modal-close" onclick="closeModal('linkChildModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <div id="linkChildCurrentList" class="school-hint"></div>
                    <form id="linkChildForm">
                        <input type="hidden" id="linkChildParentId">
                        <div class="school-form-group">
                            <label>Estudiante *</label>
                            <select id="linkChildStudent" required></select>
                        </div>
                        <div class="school-form-group">
                            <label>Parentesco</label>
                            <select id="linkChildRelation">
                                <option value="padre/madre">Padre/Madre</option>
                                <option value="tutor">Tutor legal</option>
                                <option value="abuelo/a">Abuelo/a</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <button type="submit" class="school-btn primary">Vincular</button>
                    </form>
                </div>
            </div>
        </div>
