        <div id="tab-users" class="school-panel">
            <div class="school-panel-header">
                <h3>Usuarios</h3>
                <button class="school-btn primary" onclick="openModal('addUserModal')">
                    Agregar Usuario
                </button>
            </div>
            <div class="school-panel-header" style="margin-top:0;gap:10px;flex-wrap:wrap;">
                <input type="text" id="usersSearch" class="school-select" placeholder="Buscar por nombre o correo..." oninput="debounceUsersSearch()" style="max-width:240px;">
                <select id="usersRoleFilter" class="school-select" onchange="loadUsers(1)">
                    <option value="">Todos los roles</option>
                    <?php if (($user['role'] ?? '') === 'admin'): ?>
                    <option value="admin">Admin General</option>
                    <?php endif; ?>
                    <option value="director">Admin Institucional</option>
                    <option value="docente">Docente</option>
                    <option value="alumno">Estudiante</option>
                    <option value="padre">Padre</option>
                    <option value="administrativo">Personal</option>
                    <?php if (($user['role'] ?? '') !== 'director'): ?>
                    <option value="user">Usuario registrado</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Institución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <tr><td colspan="6" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="usersPagination"></div>
        </div>

        <div class="school-modal" id="addUserModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Agregar Usuario</h3>
                    <button class="school-modal-close" onclick="closeModal('addUserModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="addUserForm">
                        <div class="school-form-group">
                            <label>Nombre completo *</label>
                            <input type="text" id="userName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Correo *</label>
                            <input type="email" id="userEmail" required>
                        </div>
                        <div class="school-form-group">
                            <label>Contraseña temporal *</label>
                            <input type="password" id="userPassword" minlength="6" required>
                        </div>
                        <div class="school-form-group">
                            <label>Rol *</label>
                            <select id="userRole" required>
                                <?php if (($user['role'] ?? '') !== 'director'): ?>
                                <option value="user">Usuario registrado</option>
                                <?php endif; ?>
                                <?php if (($user['role'] ?? '') === 'admin'): ?>
                                <option value="admin">Admin General</option>
                                <?php endif; ?>
                                <option value="director">Admin Institucional</option>
                                <option value="docente">Docente</option>
                                <option value="alumno">Estudiante</option>
                                <option value="padre">Padre</option>
                                <option value="administrativo">Personal</option>
                            </select>
                        </div>
                        <div class="school-form-group" id="userInstitutionGroup">
                            <label>Institución</label>
                            <select id="userInstitutionId"></select>
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="userPhone">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar Usuario</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="school-modal" id="editUserModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Editar Usuario</h3>
                    <button class="school-modal-close" onclick="closeModal('editUserModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <div class="school-form-group">
                            <label>Nombre completo *</label>
                            <input type="text" id="editUserName" required>
                        </div>
                        <div class="school-form-group">
                            <label>Rol *</label>
                            <select id="editUserRole" required>
                                <?php if (($user['role'] ?? '') !== 'director'): ?>
                                <option value="user">Usuario registrado</option>
                                <?php endif; ?>
                                <?php if (($user['role'] ?? '') === 'admin'): ?>
                                <option value="admin">Admin General</option>
                                <?php endif; ?>
                                <option value="director">Admin Institucional</option>
                                <option value="docente">Docente</option>
                                <option value="alumno">Estudiante</option>
                                <option value="padre">Padre</option>
                                <option value="administrativo">Personal</option>
                            </select>
                        </div>
                        <div class="school-form-group">
                            <label>Estado institucional</label>
                            <select id="editUserEstado">
                                <option value="ninguno">Ninguno</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="rechazado">Rechazado</option>
                            </select>
                        </div>
                        <div class="school-form-group">
                            <label>Teléfono</label>
                            <input type="text" id="editUserPhone">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
