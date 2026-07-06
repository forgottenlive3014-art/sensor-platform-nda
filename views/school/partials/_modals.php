<!-- ========================================================== -->
<!--  MODALES -->
<!-- ========================================================== -->

<!-- Modal Agregar Alumno -->
<div class="school-modal" id="addStudentModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Agregar Alumno</h3>
            <button class="school-modal-close" onclick="closeModal('addStudentModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addStudentForm">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="studentName" placeholder="Nombre del alumno" required>
                </div>
                <div class="school-form-group">
                    <label>Apellido *</label>
                    <input type="text" id="studentLastName" placeholder="Apellido del alumno" required>
                </div>
                <div class="school-form-group">
                    <label>Correo electrónico *</label>
                    <input type="email" id="studentEmail" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="school-form-group">
                    <label>Teléfono de emergencia</label>
                    <input type="text" id="studentPhone" placeholder="7777-0000">
                </div>
                <div class="school-form-group">
                    <label>Aula</label>
                    <select id="studentClassroom">
                        <option value="">Seleccionar aula</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Guardar Alumno</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Docente -->
<div class="school-modal" id="addTeacherModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Agregar Docente</h3>
            <button class="school-modal-close" onclick="closeModal('addTeacherModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addTeacherForm">
                <div class="school-form-group">
                    <label>Nombre completo *</label>
                    <input type="text" id="teacherName" placeholder="Prof. Juan Pérez" required>
                </div>
                <div class="school-form-group">
                    <label>Correo electrónico *</label>
                    <input type="email" id="teacherEmail" placeholder="juan@ejemplo.com" required>
                </div>
                <div class="school-form-group">
                    <label>Materia</label>
                    <input type="text" id="teacherSubject" placeholder="Matemáticas">
                </div>
                <div class="school-form-group">
                    <label>Teléfono</label>
                    <input type="text" id="teacherPhone" placeholder="7788-0000">
                </div>
                <button type="submit" class="school-btn primary">Guardar Docente</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Aula -->
<div class="school-modal" id="addClassroomModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Agregar Aula</h3>
            <button class="school-modal-close" onclick="closeModal('addClassroomModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addClassroomForm">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="classroomName" placeholder="Ej: 10° A" required>
                </div>
                <div class="school-form-group">
                    <label>Grado</label>
                    <input type="text" id="classroomGrade" placeholder="Ej: Décimo">
                </div>
                <div class="school-form-group">
                    <label>Nivel</label>
                    <select id="classroomLevel">
                        <option value="Básica">Básica</option>
                        <option value="Bachillerato">Bachillerato</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Sección</label>
                    <input type="text" id="classroomSection" placeholder="Ej: A">
                </div>
                <button type="submit" class="school-btn primary">Guardar Aula</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Ruta -->
<div class="school-modal" id="addRouteModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Agregar Ruta de Evacuación</h3>
            <button class="school-modal-close" onclick="closeModal('addRouteModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addRouteForm">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="routeName" placeholder="Ej: Ruta Norte" required>
                </div>
                <div class="school-form-group">
                    <label>Descripción</label>
                    <textarea id="routeDescription" rows="2" placeholder="Describe la ruta..."></textarea>
                </div>
                <div class="school-form-group">
                    <label>Estado</label>
                    <select id="routeStatus">
                        <option value="despejada">Despejada</option>
                        <option value="bloqueada">Bloqueada</option>
                        <option value="peligro">Peligro</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Guardar Ruta</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reportar Incidente -->

<!-- Modal Editar Incidente -->
<div class="school-modal" id="editIncidentModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Editar Incidente</h3>
            <button class="school-modal-close" onclick="closeModal('editIncidentModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="editIncidentForm">
                <input type="hidden" id="editIncidentId">
                <div class="school-form-group">
                    <label>Tipo *</label>
                    <select id="editIncidentType" required>
                        <option value="Ruta bloqueada">Ruta bloqueada</option>
                        <option value="Objeto caído">Objeto caído</option>
                        <option value="Alumno lesionado">Alumno lesionado</option>
                        <option value="Espacio dañado">Espacio dañado / Daño de infraestructura</option>
                        <option value="Falla estructural">Falla estructural</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Ubicación</label>
                    <input type="text" id="editIncidentLocation">
                </div>
                <div class="school-form-group">
                    <label>Descripción *</label>
                    <textarea id="editIncidentDescription" rows="3" required></textarea>
                </div>
                <div class="school-form-group">
                    <label>Prioridad</label>
                    <select id="editIncidentPriority">
                        <option value="baja">Baja</option>
                        <option value="media">Media</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Simulacro -->
<div class="school-modal" id="editDrillModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Editar Simulacro</h3>
            <button class="school-modal-close" onclick="closeModal('editDrillModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="editDrillForm">
                <input type="hidden" id="editDrillId">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="editDrillName" required>
                </div>
                <div class="school-form-group">
                    <label>Fecha</label>
                    <input type="date" id="editDrillDate">
                </div>
                <div class="school-form-group">
                    <label>Hora</label>
                    <input type="time" id="editDrillTime">
                </div>
                <div class="school-form-group">
                    <label>Tipo</label>
                    <select id="editDrillType">
                        <option value="Sísmico">Sísmico</option>
                        <option value="Incendio">Incendio</option>
                        <option value="Tsunami">Tsunami</option>
                        <option value="Erupción volcánica">Erupción volcánica</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Descripción</label>
                    <textarea id="editDrillDescription" rows="2"></textarea>
                </div>
                <button type="submit" class="school-btn primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
<div class="school-modal" id="editStudentModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Editar Alumno</h3>
            <button class="school-modal-close" onclick="closeModal('editStudentModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="editStudentForm">
                <input type="hidden" id="editStudentId">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="editStudentName" required>
                </div>
                <div class="school-form-group">
                    <label>Apellido *</label>
                    <input type="text" id="editStudentLastName" required>
                </div>
                <div class="school-form-group">
                    <label>Teléfono de emergencia</label>
                    <input type="text" id="editStudentPhone">
                </div>
                <div class="school-form-group">
                    <label>Aula</label>
                    <select id="editStudentClassroom">
                        <option value="">Seleccionar aula</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Docente -->
<div class="school-modal" id="editTeacherModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Editar Docente</h3>
            <button class="school-modal-close" onclick="closeModal('editTeacherModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="editTeacherForm">
                <input type="hidden" id="editTeacherId">
                <div class="school-form-group">
                    <label>Nombre completo *</label>
                    <input type="text" id="editTeacherName" required>
                </div>
                <div class="school-form-group">
                    <label>Materia</label>
                    <input type="text" id="editTeacherSubject">
                </div>
                <div class="school-form-group">
                    <label>Teléfono</label>
                    <input type="text" id="editTeacherPhone">
                </div>
                <p class="school-hint">El correo no se puede cambiar desde aquí.</p>
                <button type="submit" class="school-btn primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Aula -->
<div class="school-modal" id="editClassroomModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Editar Aula</h3>
            <button class="school-modal-close" onclick="closeModal('editClassroomModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="editClassroomForm">
                <input type="hidden" id="editClassroomId">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="editClassroomName" required>
                </div>
                <div class="school-form-group">
                    <label>Grado</label>
                    <input type="text" id="editClassroomGrade">
                </div>
                <div class="school-form-group">
                    <label>Nivel</label>
                    <select id="editClassroomLevel">
                        <option value="Básica">Básica</option>
                        <option value="Bachillerato">Bachillerato</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Sección</label>
                    <input type="text" id="editClassroomSection">
                </div>
                <div class="school-form-group">
                    <label>Docente asignado</label>
                    <select id="editClassroomTeacher">
                        <option value="">Sin docente asignado</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Ruta -->
<div class="school-modal" id="editRouteModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Editar Ruta de Evacuación</h3>
            <button class="school-modal-close" onclick="closeModal('editRouteModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="editRouteForm">
                <input type="hidden" id="editRouteId">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="editRouteName" required>
                </div>
                <div class="school-form-group">
                    <label>Descripción</label>
                    <textarea id="editRouteDescription" rows="2"></textarea>
                </div>
                <div class="school-form-group">
                    <label>Estado</label>
                    <select id="editRouteStatus">
                        <option value="despejada">Despejada</option>
                        <option value="bloqueada">Bloqueada</option>
                        <option value="peligro">Peligro</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
<div class="school-modal" id="addIncidentModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Reportar Incidente</h3>
            <button class="school-modal-close" onclick="closeModal('addIncidentModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addIncidentForm">
                <div class="school-form-group">
                    <label>Tipo *</label>
                    <select id="incidentType" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Ruta bloqueada">Ruta bloqueada</option>
                        <option value="Objeto caído">Objeto caído</option>
                        <option value="Alumno lesionado">Alumno lesionado</option>
                        <option value="Espacio dañado">Espacio dañado / Daño de infraestructura</option>
                        <option value="Falla estructural">Falla estructural</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Ubicación</label>
                    <input type="text" id="incidentLocation" placeholder="Ej: Pasillo norte, Pabellón B">
                </div>
                <div class="school-form-group">
                    <label>Descripción *</label>
                    <textarea id="incidentDescription" rows="3" placeholder="Describe el incidente en detalle..." required></textarea>
                </div>
                <div class="school-form-group">
                    <label>Foto del daño (opcional)</label>
                    <input type="file" id="incidentImage" accept="image/*">
                </div>
                <div class="school-form-group">
                    <label>Prioridad</label>
                    <select id="incidentPriority">
                        <option value="baja">Baja</option>
                        <option value="media" selected>Media</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Reportar Incidente</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nueva Nota de Corcho -->
<div class="school-modal" id="addBoardNoteModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Nueva nota</h3>
            <button class="school-modal-close" onclick="closeModal('addBoardNoteModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addBoardNoteForm">
                <div class="school-form-group">
                    <label>Mensaje *</label>
                    <textarea id="noteText" rows="3" maxlength="280" placeholder="Escribe un aviso, recordatorio o idea para la comunidad..." required></textarea>
                </div>
                <div class="school-form-group">
                    <label>Color</label>
                    <div class="note-color-picker">
                        <label><input type="radio" name="noteColor" value="amarillo" checked><span class="note-swatch amarillo"></span></label>
                        <label><input type="radio" name="noteColor" value="naranja"><span class="note-swatch naranja"></span></label>
                        <label><input type="radio" name="noteColor" value="verde"><span class="note-swatch verde"></span></label>
                        <label><input type="radio" name="noteColor" value="azul"><span class="note-swatch azul"></span></label>
                        <label><input type="radio" name="noteColor" value="rosa"><span class="note-swatch rosa"></span></label>
                    </div>
                </div>
                <div class="school-form-group">
                    <label>¿Quién la puede ver?</label>
                    <div class="note-visibility-picker">
                        <label><input type="checkbox" id="noteVisTodos" checked onchange="toggleNoteVisAll(this)"> Todos</label>
                        <span id="noteVisRoles" style="display:none;">
                            <label><input type="checkbox" class="noteVisRole" value="director"> Directores</label>
                            <label><input type="checkbox" class="noteVisRole" value="docente"> Docentes</label>
                            <label><input type="checkbox" class="noteVisRole" value="alumno"> Alumnos</label>
                            <label><input type="checkbox" class="noteVisRole" value="padre"> Padres</label>
                            <label><input type="checkbox" class="noteVisRole" value="administrativo"> Personal</label>
                        </span>
                    </div>
                </div>
                <button type="submit" class="school-btn primary">Pegar en el corcho</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nuevo Punto de Croquis -->
<div class="school-modal" id="addCroquisPointModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Nuevo punto en el croquis</h3>
            <button class="school-modal-close" onclick="closeModal('addCroquisPointModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addCroquisPointForm">
                <input type="hidden" id="croquisPointX">
                <input type="hidden" id="croquisPointY">
                <div class="school-form-group">
                    <label>Tipo *</label>
                    <select id="croquisPointType" required>
                        <option value="encuentro">Punto de encuentro</option>
                        <option value="zona_segura">Zona segura</option>
                        <option value="extintor">Extintor</option>
                        <option value="botiquin">Botiquín</option>
                        <option value="salida">Salida de emergencia</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="croquisPointName" placeholder="Ej: Cancha principal" required>
                </div>
                <div class="school-form-group">
                    <label>Descripción</label>
                    <input type="text" id="croquisPointDesc" placeholder="Detalles adicionales (opcional)">
                </div>
                <button type="submit" class="school-btn primary">Agregar punto</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nuevo Simulacro -->
<div class="school-modal" id="addDrillModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Nuevo Simulacro</h3>
            <button class="school-modal-close" onclick="closeModal('addDrillModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addDrillForm">
                <div class="school-form-group">
                    <label>Nombre *</label>
                    <input type="text" id="drillName" placeholder="Ej: Simulacro Sísmico 2025" required>
                </div>
                <div class="school-form-group">
                    <label>Tipo</label>
                    <select id="drillType">
                        <option value="Sísmico">Sísmico</option>
                        <option value="Incendio">Incendio</option>
                        <option value="Tsunami">Tsunami</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Fecha</label>
                    <input type="date" id="drillDate" required>
                </div>
                <div class="school-form-group">
                    <label>Hora</label>
                    <input type="time" id="drillTime" required>
                </div>
                <button type="submit" class="school-btn primary">Crear Simulacro</button>
            </form>
        </div>
    </div>
</div>
