// ================================================================
//  SCHOOL MODULE - SismoNDA
// ================================================================

// ─── PAGINACIÓN (helper reutilizado por todos los CRUD del módulo) ───
// onPageClickFnName: nombre (string) de una función global que recibe el
// número de página, ej. renderPagination('fooPagination', 2, 5, 'loadFooPage').
function renderPagination(containerId, page, totalPages, onPageClickFnName) {
    const el = document.getElementById(containerId);
    if (!el) return;
    if (totalPages <= 1) { el.innerHTML = ''; return; }

    let html = '';
    html += `<button class="school-btn secondary" ${page <= 1 ? 'disabled' : ''} onclick="${onPageClickFnName}(${page - 1})">&laquo; Anterior</button>`;
    html += `<span class="school-pagination-info">Página ${page} de ${totalPages}</span>`;
    html += `<button class="school-btn secondary" ${page >= totalPages ? 'disabled' : ''} onclick="${onPageClickFnName}(${page + 1})">Siguiente &raquo;</button>`;
    el.innerHTML = html;
}

function debounce(fn, wait) {
    let t;
    return function (...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), wait);
    };
}

// ─── TABS ───
function showSchoolTab(tabId) {
    document.querySelectorAll('.school-panel').forEach(p => p.classList.remove('active'));
    const panel = document.getElementById('tab-' + tabId);
    if (panel) panel.classList.add('active');

    document.querySelectorAll('.school-tab').forEach(t => t.classList.remove('active'));
    document.querySelector(`.school-tab[data-tab="${tabId}"]`)?.classList.add('active');

    // Cargar datos según la pestaña
    const loaders = {
        'students': loadStudents,
        'teachers': loadTeachers,
        'classrooms': loadClassrooms,
        'routes': loadRoutes,
        'attendance': loadDrillSelect,
        'incidents': loadIncidents,
        'drills': loadDrills,
        'reports': loadReports,
        'sections': loadSections,
        'croquis': loadCroquis,
        'board': loadBoard,
        'requests': loadJoinRequests,
        'institutions': loadInstitutions,
        'my-attendance': loadMyAttendance,
        'users': loadUsers,
        'news': loadNews,
        'parents': loadParents,
        'my-children': loadMyChildren,
        'staff': loadStaff,
        'notifications': loadNotifications,
        'blog': loadBlog,
        'articulos': loadArticulos,
        'recursos': loadRecursos,
        'quehacer-content': () => loadContentForm('quehacer'),
        'acercade-content': () => loadContentForm('acercade')
    };
    if (loaders[tabId]) loaders[tabId]();
}

// ─── MODALS ───
function openModal(id) {
    document.getElementById(id).classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

// ─── ALUMNOS ───
let __studentsCache = [];
let __studentsPage = 1;

async function loadStudents(page) {
    const tbody = document.getElementById('studentsTableBody');
    if (!tbody) return;
    __studentsPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Cargando alumnos...</td></tr>';

    const q = document.getElementById('studentsSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/students&q=${encodeURIComponent(q)}&page=${__studentsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __studentsCache = result.data || [];

        if (__studentsCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay alumnos registrados</td></tr>';
            renderPagination('studentsPagination', 1, 1, 'loadStudents');
            return;
        }

        tbody.innerHTML = __studentsCache.map(s => `
            <tr>
                <td><code>${s.codigo || '—'}</code></td>
                <td>${s.nombre} ${s.apellido || ''}</td>
                <td>${s.classroom || 'Sin aula'}</td>
                <td>${s.teacher || 'Sin asignar'}</td>
                <td><span style="color:var(--teal);">Activo</span></td>
                <td>
                    ${window.__ndaIsSchoolStaff ? `<button class="school-attendance-btn" onclick="editStudent(${s.estudiantes_id})">Editar</button>` : ''}
                    ${window.__ndaIsSchoolAdmin ? `<button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteStudent(${s.estudiantes_id})">Eliminar</button>` : ''}
                </td>
            </tr>
        `).join('');

        renderPagination('studentsPagination', result.page, result.total_pages, 'loadStudents');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar alumnos</td></tr>';
        console.error(e);
    }
}

const debounceStudentsSearch = debounce(() => loadStudents(1), 350);

document.getElementById('addStudentForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('studentName').value,
        apellido: document.getElementById('studentLastName').value,
        email: document.getElementById('studentEmail').value,
        telefono: document.getElementById('studentPhone').value,
        aula_id: document.getElementById('studentClassroom').value || null
    };

    try {
        const response = await fetch('?url=school/add-student', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Alumno agregado correctamente. Contraseña temporal: ' + result.password_temporal);
            closeModal('addStudentModal');
            this.reset();
            loadStudents(__studentsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

async function editStudent(id) {
    const s = __studentsCache.find(x => String(x.estudiantes_id) === String(id));
    if (!s) { ndaAlert('No se encontró el alumno.'); return; }

    document.getElementById('editStudentId').value = s.estudiantes_id;
    document.getElementById('editStudentName').value = s.nombre || '';
    document.getElementById('editStudentLastName').value = s.apellido || '';
    document.getElementById('editStudentPhone').value = s.telefono_emergencia || '';

    const select = document.getElementById('editStudentClassroom');
    select.innerHTML = '<option value="">Seleccionar aula</option>';
    try {
        const res = await fetch('?url=school/classrooms&per_page=100');
        const result = await res.json();
        const classrooms = result.data || [];
        classrooms.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.aulas_id;
            opt.textContent = c.nombre;
            if (String(c.aulas_id) === String(s.aulas_id)) opt.selected = true;
            select.appendChild(opt);
        });
    } catch (e) { /* deja el select vacio si falla */ }

    openModal('editStudentModal');
}

document.getElementById('editStudentForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editStudentId').value,
        nombre: document.getElementById('editStudentName').value,
        apellido: document.getElementById('editStudentLastName').value,
        telefono: document.getElementById('editStudentPhone').value,
        aula_id: document.getElementById('editStudentClassroom').value || null,
    };
    try {
        const response = await fetch('?url=school/update-student', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editStudentModal');
            loadStudents(__studentsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteStudent(id) {
    if (!(await ndaConfirm('¿Eliminar este alumno?'))) return;
    try {
        const response = await fetch(`?url=school/delete-student&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Alumno eliminado');
            loadStudents(__studentsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// ─── DOCENTES ───
let __teachersCache = [];
let __teachersPage = 1;

async function loadTeachers(page) {
    const tbody = document.getElementById('teachersTableBody');
    if (!tbody) return;
    __teachersPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando docentes...</td></tr>';

    const q = document.getElementById('teachersSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/teachers&q=${encodeURIComponent(q)}&page=${__teachersPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __teachersCache = result.data || [];

        if (__teachersCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay docentes registrados</td></tr>';
            renderPagination('teachersPagination', 1, 1, 'loadTeachers');
            return;
        }

        tbody.innerHTML = __teachersCache.map(t => `
            <tr>
                <td><strong>${t.nombre}</strong></td>
                <td>${t.email}</td>
                <td>${t.materia || '—'}</td>
                <td>${t.aulas || 'Sin asignar'}</td>
                <td>
                    <button class="school-attendance-btn" onclick="editTeacher(${t.usuarios_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteTeacher(${t.usuarios_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('teachersPagination', result.page, result.total_pages, 'loadTeachers');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Error al cargar docentes</td></tr>';
        console.error(e);
    }
}

const debounceTeachersSearch = debounce(() => loadTeachers(1), 350);

function editTeacher(id) {
    const t = __teachersCache.find(x => String(x.usuarios_id) === String(id));
    if (!t) { ndaAlert('No se encontró el docente.'); return; }
    document.getElementById('editTeacherId').value = t.usuarios_id;
    document.getElementById('editTeacherName').value = t.nombre || '';
    document.getElementById('editTeacherSubject').value = t.materia || '';
    document.getElementById('editTeacherPhone').value = t.telefono || '';
    openModal('editTeacherModal');
}

document.getElementById('editTeacherForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editTeacherId').value,
        nombre: document.getElementById('editTeacherName').value,
        materia: document.getElementById('editTeacherSubject').value,
        telefono: document.getElementById('editTeacherPhone').value,
    };
    try {
        const response = await fetch('?url=school/update-teacher', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editTeacherModal');
            loadTeachers(__teachersPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

document.getElementById('addTeacherForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('teacherName').value,
        email: document.getElementById('teacherEmail').value,
        materia: document.getElementById('teacherSubject').value,
        telefono: document.getElementById('teacherPhone').value
    };

    try {
        const response = await fetch('?url=school/add-teacher', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Docente agregado correctamente. Contraseña temporal: ' + result.password_temporal);
            closeModal('addTeacherModal');
            this.reset();
            loadTeachers(__teachersPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

async function deleteTeacher(id) {
    if (!(await ndaConfirm('¿Eliminar este docente?'))) return;
    try {
        const response = await fetch(`?url=school/delete-teacher&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Docente eliminado');
            loadTeachers(__teachersPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// Un docente sube su propia fotografia de perfil (usado desde su dashboard).
async function uploadTeacherPhoto(input) {
    if (!input.files[0]) return;
    const formData = new FormData();
    formData.append('foto', input.files[0]);
    try {
        const response = await fetch('?url=school/upload-teacher-photo', { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Fotografía actualizada');
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
    input.value = '';
}

// ─── PADRES / MADRES ───
let __parentsCache = [];
let __parentsPage = 1;

async function loadParents(page) {
    const tbody = document.getElementById('parentsTableBody');
    if (!tbody) return;
    __parentsPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Cargando...</td></tr>';

    const q = document.getElementById('parentsSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/parents&q=${encodeURIComponent(q)}&page=${__parentsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __parentsCache = result.data || [];

        if (__parentsCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay padres/madres registrados</td></tr>';
            renderPagination('parentsPagination', 1, 1, 'loadParents');
            return;
        }

        tbody.innerHTML = __parentsCache.map(p => `
            <tr>
                <td><strong>${p.nombre}</strong></td>
                <td>${p.email}</td>
                <td>${p.hijos || 'Ninguno vinculado'}</td>
                <td>
                    <button class="school-attendance-btn" onclick="openLinkChildModal(${p.usuarios_id})">👪 Vincular hijo</button>
                    <button class="school-attendance-btn" onclick="editParent(${p.usuarios_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteParent(${p.usuarios_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('parentsPagination', result.page, result.total_pages, 'loadParents');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Error al cargar padres/madres</td></tr>';
        console.error(e);
    }
}

const debounceParentsSearch = debounce(() => loadParents(1), 350);

document.getElementById('addParentForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('parentName').value,
        email: document.getElementById('parentEmail').value,
        telefono: document.getElementById('parentPhone').value,
    };
    try {
        const response = await fetch('?url=school/add-parent', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Padre/madre agregado. Contraseña temporal: ' + result.password_temporal);
            closeModal('addParentModal');
            this.reset();
            loadParents(__parentsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
});

function editParent(id) {
    const p = __parentsCache.find(x => String(x.usuarios_id) === String(id));
    if (!p) { ndaAlert('No se encontró el registro.'); return; }
    document.getElementById('editParentId').value = p.usuarios_id;
    document.getElementById('editParentName').value = p.nombre || '';
    document.getElementById('editParentPhone').value = p.telefono || '';
    openModal('editParentModal');
}

document.getElementById('editParentForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editParentId').value,
        nombre: document.getElementById('editParentName').value,
        telefono: document.getElementById('editParentPhone').value,
    };
    try {
        const response = await fetch('?url=school/update-parent', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editParentModal');
            loadParents(__parentsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteParent(id) {
    if (!(await ndaConfirm('¿Eliminar este padre/madre?'))) return;
    try {
        const response = await fetch(`?url=school/delete-parent&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Eliminado');
            loadParents(__parentsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
}

async function openLinkChildModal(parentId) {
    document.getElementById('linkChildParentId').value = parentId;

    const currentList = document.getElementById('linkChildCurrentList');
    currentList.innerHTML = 'Cargando vínculos actuales...';
    try {
        const res = await fetch(`?url=school/parent-children-links&padre_id=${parentId}`);
        const links = await res.json();
        if (Array.isArray(links) && links.length > 0) {
            currentList.innerHTML = 'Vinculados actualmente: ' + links.map(l =>
                `${l.nombre} ${l.apellido} (${l.parentesco}) <button class="school-attendance-btn" onclick="unlinkChild(${l.padres_estudiantes_id}, ${parentId})">Quitar</button>`
            ).join(' · ');
        } else {
            currentList.innerHTML = 'Todavía no tiene hijos vinculados.';
        }
    } catch (e) { currentList.innerHTML = ''; }

    const select = document.getElementById('linkChildStudent');
    select.innerHTML = '<option value="">Cargando alumnos...</option>';
    try {
        const res = await fetch('?url=school/students&per_page=200');
        const result = await res.json();
        const students = result.data || [];
        select.innerHTML = students.map(s => `<option value="${s.estudiantes_id}">${s.nombre} ${s.apellido} (${s.codigo || ''})</option>`).join('');
    } catch (e) { select.innerHTML = '<option value="">Error al cargar alumnos</option>'; }

    openModal('linkChildModal');
}

document.getElementById('linkChildForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        padre_id: document.getElementById('linkChildParentId').value,
        estudiante_id: document.getElementById('linkChildStudent').value,
        parentesco: document.getElementById('linkChildRelation').value,
    };
    try {
        const response = await fetch('?url=school/link-child', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Estudiante vinculado');
            closeModal('linkChildModal');
            loadParents(__parentsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
});

async function unlinkChild(linkId, parentId) {
    if (!(await ndaConfirm('¿Quitar este vínculo?'))) return;
    try {
        const response = await fetch(`?url=school/unlink-child&id=${linkId}`);
        const result = await response.json();
        if (result.success) {
            openLinkChildModal(parentId);
            loadParents(__parentsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

// ─── MIS HIJOS (Padre) ───
async function loadMyChildren() {
    const tbody = document.getElementById('myChildrenTableBody');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Cargando...</td></tr>';

    try {
        const response = await fetch('?url=school/my-children');
        const children = await response.json();

        if (children.error) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">Error: ${children.error}</td></tr>`;
            return;
        }
        if (!Array.isArray(children) || children.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">Todavía no tienes hijos vinculados. Pídele al director que te vincule desde Padres.</td></tr>';
            return;
        }

        tbody.innerHTML = children.map(c => `
            <tr>
                <td><code>${c.codigo || '—'}</code></td>
                <td>${c.nombre} ${c.apellido || ''}</td>
                <td>${c.classroom || 'Sin aula'}</td>
                <td>${c.teacher || 'Sin asignar'}</td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Error al cargar tus hijos</td></tr>';
        console.error(e);
    }

    loadMyChildrenDrillStatus();
}

async function loadMyChildrenDrillStatus() {
    const tbody = document.getElementById('myChildrenStatusBody');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="3" class="text-center">Cargando...</td></tr>';

    try {
        const response = await fetch('?url=school/my-children-status');
        const rows = await response.json();

        if (!Array.isArray(rows) || rows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">Sin hijos vinculados</td></tr>';
            return;
        }

        tbody.innerHTML = rows.map(r => `
            <tr>
                <td>${r.nombre} ${r.apellido || ''}</td>
                <td>${r.simulacro || 'Sin simulacros registrados'}</td>
                <td>${r.status ? `<span class="school-attendance-status ${r.status}">${r.status}</span>` : '—'}</td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-center">Error al cargar el estado</td></tr>';
        console.error(e);
    }
}

// ─── PERSONAL ADMINISTRATIVO ───
let __staffCache = [];
let __staffPage = 1;

async function loadStaff(page) {
    const tbody = document.getElementById('staffTableBody');
    if (!tbody) return;
    __staffPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Cargando...</td></tr>';

    const q = document.getElementById('staffSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/staff&q=${encodeURIComponent(q)}&page=${__staffPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __staffCache = result.data || [];

        if (__staffCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay personal registrado</td></tr>';
            renderPagination('staffPagination', 1, 1, 'loadStaff');
            return;
        }

        tbody.innerHTML = __staffCache.map(s => `
            <tr>
                <td><strong>${s.nombre}</strong></td>
                <td>${s.email}</td>
                <td>${s.telefono || '—'}</td>
                <td>
                    <button class="school-attendance-btn" onclick="editStaff(${s.usuarios_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteStaff(${s.usuarios_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('staffPagination', result.page, result.total_pages, 'loadStaff');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Error al cargar personal</td></tr>';
        console.error(e);
    }
}

const debounceStaffSearch = debounce(() => loadStaff(1), 350);

document.getElementById('addStaffForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('staffName').value,
        email: document.getElementById('staffEmail').value,
        telefono: document.getElementById('staffPhone').value,
    };
    try {
        const response = await fetch('?url=school/add-staff', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Personal agregado. Contraseña temporal: ' + result.password_temporal);
            closeModal('addStaffModal');
            this.reset();
            loadStaff(__staffPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
});

function editStaff(id) {
    const s = __staffCache.find(x => String(x.usuarios_id) === String(id));
    if (!s) { ndaAlert('No se encontró el registro.'); return; }
    document.getElementById('editStaffId').value = s.usuarios_id;
    document.getElementById('editStaffName').value = s.nombre || '';
    document.getElementById('editStaffPhone').value = s.telefono || '';
    openModal('editStaffModal');
}

document.getElementById('editStaffForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editStaffId').value,
        nombre: document.getElementById('editStaffName').value,
        telefono: document.getElementById('editStaffPhone').value,
    };
    try {
        const response = await fetch('?url=school/update-staff', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editStaffModal');
            loadStaff(__staffPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteStaff(id) {
    if (!(await ndaConfirm('¿Eliminar este registro de personal?'))) return;
    try {
        const response = await fetch(`?url=school/delete-staff&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Eliminado');
            loadStaff(__staffPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
}

// ─── NOTIFICACIONES ───
let __notificationsPage = 1;
const severityLabelMap = { seguro: 'Seguro', informativo: 'Informativo', precaucion: 'Precaución', alerta: 'Alerta', emergencia: 'Emergencia' };

async function loadNotifications(page) {
    const tbody = document.getElementById('notificationsTableBody');
    if (!tbody) return;
    __notificationsPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando...</td></tr>';

    try {
        const response = await fetch(`?url=school/notifications&page=${__notificationsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        const rows = result.data || [];

        if (rows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se han enviado notificaciones</td></tr>';
            renderPagination('notificationsPagination', 1, 1, 'loadNotifications');
            return;
        }

        tbody.innerHTML = rows.map(n => `
            <tr>
                <td>${n.mensaje}</td>
                <td><span class="chip b">${severityLabelMap[n.severidad] || n.severidad}</span></td>
                <td>${n.es_global == 1 ? 'Global' : 'Institución'}</td>
                <td>${new Date(n.created_at).toLocaleString('es-SV')}</td>
                <td><button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteNotification(${n.notificaciones_id})">Eliminar</button></td>
            </tr>
        `).join('');

        renderPagination('notificationsPagination', result.page, result.total_pages, 'loadNotifications');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Error al cargar notificaciones</td></tr>';
        console.error(e);
    }
}

document.querySelector('[onclick="openModal(\'sendNotificationModal\')"]')?.addEventListener('click', () => {
    const group = document.getElementById('notificationGlobalGroup');
    if (group) group.style.display = window.__ndaIsGlobalAdmin ? '' : 'none';
});

document.getElementById('sendNotificationForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        mensaje: document.getElementById('notificationMessage').value,
        severidad: document.getElementById('notificationSeverity').value,
        es_global: document.getElementById('notificationGlobal')?.checked || false,
    };
    try {
        const response = await fetch('?url=school/send-notification', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Notificación enviada');
            closeModal('sendNotificationModal');
            this.reset();
            loadNotifications(__notificationsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
});

async function deleteNotification(id) {
    if (!(await ndaConfirm('¿Eliminar esta notificación?'))) return;
    try {
        const response = await fetch(`?url=school/delete-notification&id=${id}`);
        const result = await response.json();
        if (result.success) {
            loadNotifications(__notificationsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

// ─── AULAS ───
let __classroomsCache = [];
let __classroomsPage = 1;

async function loadClassrooms(page) {
    const tbody = document.getElementById('classroomsTableBody');
    if (!tbody) return;
    __classroomsPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Cargando aulas...</td></tr>';

    const q = document.getElementById('classroomsSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/classrooms&q=${encodeURIComponent(q)}&page=${__classroomsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __classroomsCache = result.data || [];

        if (__classroomsCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay aulas registradas</td></tr>';
            renderPagination('classroomsPagination', 1, 1, 'loadClassrooms');
            return;
        }

        tbody.innerHTML = __classroomsCache.map(c => `
            <tr>
                <td><strong>${c.nombre}</strong></td>
                <td>${c.grado || '—'}</td>
                <td>${c.nivel || '—'}</td>
                <td>${c.seccion || '—'}</td>
                <td>${c.teacher || 'Sin asignar'}</td>
                <td>
                    <button class="school-attendance-btn" onclick="editClassroom(${c.aulas_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteClassroom(${c.aulas_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('classroomsPagination', result.page, result.total_pages, 'loadClassrooms');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar aulas</td></tr>';
        console.error(e);
    }
}

const debounceClassroomsSearch = debounce(() => loadClassrooms(1), 350);

async function editClassroom(id) {
    const c = __classroomsCache.find(x => String(x.aulas_id) === String(id));
    if (!c) { ndaAlert('No se encontró el aula.'); return; }

    document.getElementById('editClassroomId').value = c.aulas_id;
    document.getElementById('editClassroomName').value = c.nombre || '';
    document.getElementById('editClassroomGrade').value = c.grado || '';
    document.getElementById('editClassroomLevel').value = c.nivel || 'Bachillerato';
    document.getElementById('editClassroomSection').value = c.seccion || '';

    const select = document.getElementById('editClassroomTeacher');
    select.innerHTML = '<option value="">Sin docente asignado</option>';
    try {
        const res = await fetch('?url=school/assignable-teachers');
        const teachers = await res.json();
        if (Array.isArray(teachers)) {
            teachers.forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.usuarios_id;
                opt.textContent = t.nombre;
                if (String(t.usuarios_id) === String(c.maestro_id)) opt.selected = true;
                select.appendChild(opt);
            });
        }
    } catch (e) { /* deja el select con solo la opcion vacia */ }

    openModal('editClassroomModal');
}

document.getElementById('editClassroomForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editClassroomId').value,
        nombre: document.getElementById('editClassroomName').value,
        grado: document.getElementById('editClassroomGrade').value,
        nivel: document.getElementById('editClassroomLevel').value,
        seccion: document.getElementById('editClassroomSection').value,
        maestro_id: document.getElementById('editClassroomTeacher').value || null,
    };
    try {
        const response = await fetch('?url=school/update-classroom', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editClassroomModal');
            loadClassrooms(__classroomsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

document.getElementById('addClassroomForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('classroomName').value,
        grado: document.getElementById('classroomGrade').value,
        nivel: document.getElementById('classroomLevel').value,
        seccion: document.getElementById('classroomSection').value
    };

    try {
        const response = await fetch('?url=school/add-classroom', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Aula agregada correctamente');
            closeModal('addClassroomModal');
            this.reset();
            loadClassrooms(__classroomsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

async function deleteClassroom(id) {
    if (!(await ndaConfirm('¿Eliminar esta aula?'))) return;
    try {
        const response = await fetch(`?url=school/delete-classroom&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Aula eliminada');
            loadClassrooms(__classroomsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// ─── RUTAS ───
let __routesCache = [];

async function loadRoutes() {
    const container = document.getElementById('routesContainer');
    if (!container) return;
    container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando rutas...</div>';

    try {
        const response = await fetch('?url=school/routes');
        const routes = await response.json();

        if (routes.error) {
            container.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error: ${routes.error}</div>`;
            return;
        }
        __routesCache = Array.isArray(routes) ? routes : [];

        if (routes.length === 0) {
            container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">No hay rutas registradas</div>';
            return;
        }

        container.innerHTML = routes.map(r => `
            <div class="school-route-card">
                <div class="school-route-header">
                    <span class="school-route-icon">🗺️</span>
                    <h4>${r.nombre}</h4>
                    <span class="school-route-status ${r.estado || 'despejada'}">${r.estado || 'Despejada'}</span>
                </div>
                <p style="font-size:0.82rem;color:var(--text2);">${r.descripcion || 'Sin descripción'}</p>
                <div style="margin-top:8px;display:flex;gap:6px;">
                    ${window.__ndaIsSchoolStaff ? `<button class="school-attendance-btn" onclick="editRoute(${r.rutas_evacuacion_id})"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></button>` : ''}
                    ${window.__ndaIsSchoolAdmin ? `<button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteRoute(${r.rutas_evacuacion_id})">Eliminar</button>` : ''}
                </div>
            </div>
        `).join('');
    } catch (e) {
        container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error al cargar rutas</div>';
        console.error(e);
    }
}

document.getElementById('addRouteForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('routeName').value,
        descripcion: document.getElementById('routeDescription').value,
        estado: document.getElementById('routeStatus').value
    };

    try {
        const response = await fetch('?url=school/add-route', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Ruta agregada correctamente');
            closeModal('addRouteModal');
            this.reset();
            loadRoutes();
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

function editRoute(id) {
    const r = __routesCache.find(x => String(x.rutas_evacuacion_id) === String(id));
    if (!r) { ndaAlert('No se encontró la ruta.'); return; }
    document.getElementById('editRouteId').value = r.rutas_evacuacion_id;
    document.getElementById('editRouteName').value = r.nombre || '';
    document.getElementById('editRouteDescription').value = r.descripcion || '';
    document.getElementById('editRouteStatus').value = r.estado || 'despejada';
    openModal('editRouteModal');
}

document.getElementById('editRouteForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editRouteId').value,
        nombre: document.getElementById('editRouteName').value,
        descripcion: document.getElementById('editRouteDescription').value,
        estado: document.getElementById('editRouteStatus').value,
    };
    try {
        const response = await fetch('?url=school/update-route', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editRouteModal');
            loadRoutes();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteRoute(id) {
    if (!(await ndaConfirm('¿Eliminar esta ruta?'))) return;
    try {
        const response = await fetch(`?url=school/delete-route&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Ruta eliminada');
            loadRoutes();
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// ─── ASISTENCIA ───
async function loadDrillSelect() {
    const select = document.getElementById('drillSelect');
    if (!select) return;

    try {
        const response = await fetch('?url=school/drills');
        const drills = await response.json();

        if (!drills.error && drills.length > 0) {
            select.innerHTML = `<option value="">Seleccionar simulacro</option>` +
                drills.map(d => `<option value="${d.simulacros_id}">${d.nombre} (${d.fecha})</option>`).join('');
        }
    } catch (e) {
        console.error('Error loading drill select:', e);
    }
}

let attendanceStudents = [];
let currentDrillId = null;

async function loadAttendance() {
    const select = document.getElementById('drillSelect');
    const drillId = select?.value;
    if (!drillId) {
        ndaAlert('Selecciona un simulacro primero');
        return;
    }

    const tbody = document.getElementById('attendanceTableBody');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Cargando asistencia...</td></tr>';

    try {
        const response = await fetch(`?url=school/attendance&drill_id=${drillId}`);
        const students = await response.json();

        if (students.error) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">Error: ${students.error}</td></tr>`;
            return;
        }

        if (students.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay alumnos para este simulacro</td></tr>';
            return;
        }

        attendanceStudents = students;
        currentDrillId = drillId;

        tbody.innerHTML = students.map((s, i) => `
            <tr>
                <td>${s.nombre} ${s.apellido || ''}</td>
                <td>${s.aula || '—'}</td>
                <td>
                    <span class="school-attendance-status ${s.status || 'pendiente'}" id="att-status-${i}">
                        ${s.status || 'Pendiente'}
                    </span>
                </td>
                <td>
                    <button class="school-attendance-btn ${s.status === 'presente' ? 'active' : ''}" onclick="setAttendance(${i}, 'presente')">Presente</button>
                    <button class="school-attendance-btn ${s.status === 'ausente' ? 'active' : ''} danger" onclick="setAttendance(${i}, 'ausente')">Ausente</button>
                    <button class="school-attendance-btn ${s.status === 'herido' ? 'active' : ''} warning" onclick="setAttendance(${i}, 'herido')">Herido</button>
                </td>
            </tr>
        `).join('');

        document.getElementById('attendanceActions').style.display = 'flex';

    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Error al cargar asistencia</td></tr>';
        console.error(e);
    }
}

function setAttendance(index, status) {
    if (!attendanceStudents[index]) return;
    attendanceStudents[index].status = status;

    const statusEl = document.getElementById(`att-status-${index}`);
    if (statusEl) {
        statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusEl.className = `school-attendance-status ${status}`;
    }

    const row = statusEl?.closest('tr');
    if (row) {
        const btns = row.querySelectorAll('.school-attendance-btn');
        btns.forEach(btn => btn.classList.remove('active'));
        const target = row.querySelector(`.school-attendance-btn[onclick*="${status}"]`);
        if (target) target.classList.add('active');
    }
}

async function saveAttendance() {
    if (!currentDrillId || attendanceStudents.length === 0) {
        ndaAlert('No hay datos de asistencia para guardar');
        return;
    }

    const attendance = attendanceStudents.map(s => ({
        estudiante_id: s.estudiantes_id,
        estado: s.status || 'pendiente'
    }));

    try {
        const response = await fetch('?url=school/save-attendance', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ drill_id: currentDrillId, attendance })
        });
        const result = await response.json();

        if (result.success) {
            ndaAlert('✅ Asistencia guardada correctamente');
        } else {
            ndaAlert('❌ Error al guardar: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// ─── INCIDENTES / DAÑOS ───
let __incidentsCache = [];

async function loadIncidents() {
    const container = document.getElementById('incidentList');
    if (!container) return;

    container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando incidentes...</div>';

    try {
        const response = await fetch('?url=school/incidents');
        const incidents = await response.json();

        if (incidents.error) {
            container.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);">Error: ${incidents.error}</div>`;
            return;
        }
        __incidentsCache = Array.isArray(incidents) ? incidents : [];

        if (incidents.length === 0) {
            container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">No hay incidentes reportados</div>';
            return;
        }

        container.innerHTML = incidents.map(inc => `
            <div class="school-incident-item">
                ${inc.imagen ? `<img class="school-incident-photo" src="${inc.imagen}" alt="Foto del daño" onclick="window.open('${inc.imagen}','_blank')">` : ''}
                <div class="school-incident-item-header">
                    <span class="school-incident-type">${inc.tipo}</span>
                    <span class="school-incident-time">${new Date(inc.created_at).toLocaleString('es-SV')}</span>
                </div>
                ${inc.ubicacion ? `<div class="school-incident-location">${svgPin()} ${inc.ubicacion}</div>` : ''}
                <div class="school-incident-desc">${inc.descripcion}</div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;gap:6px;flex-wrap:wrap;">
                    ${inc.estado === 'resuelto' ? '<span class="school-incident-resolved">' + svgCheck() + ' Resuelto</span>' : '<span></span>'}
                    ${inc.reporter ? `<span style="font-size:0.7rem;color:var(--text3);">Reportado por: ${inc.reporter}</span>` : ''}
                    <span>
                        ${window.__ndaIsSchoolStaff ? `<button class="school-attendance-btn" onclick="editIncident(${inc.incidentes_id})">Editar</button>` : ''}
                        ${window.__ndaIsSchoolStaff && inc.estado !== 'resuelto' ? `<button class="school-attendance-btn" onclick="resolveIncident(${inc.incidentes_id})">${svgCheck()} Resolver</button>` : ''}
                        ${window.__ndaIsSchoolAdmin ? `<button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteIncident(${inc.incidentes_id})">Eliminar</button>` : ''}
                    </span>
                </div>
            </div>
        `).join('');
    } catch (e) {
        container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar incidentes</div>';
        console.error(e);
    }
}

function editIncident(id) {
    const inc = __incidentsCache.find(x => String(x.incidentes_id) === String(id));
    if (!inc) { ndaAlert('No se encontró el incidente.'); return; }
    document.getElementById('editIncidentId').value = inc.incidentes_id;
    document.getElementById('editIncidentType').value = inc.tipo || '';
    document.getElementById('editIncidentLocation').value = inc.ubicacion || '';
    document.getElementById('editIncidentDescription').value = inc.descripcion || '';
    document.getElementById('editIncidentPriority').value = inc.prioridad || 'media';
    openModal('editIncidentModal');
}

document.getElementById('editIncidentForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editIncidentId').value,
        tipo: document.getElementById('editIncidentType').value,
        ubicacion: document.getElementById('editIncidentLocation').value,
        descripcion: document.getElementById('editIncidentDescription').value,
        prioridad: document.getElementById('editIncidentPriority').value,
    };
    try {
        const response = await fetch('?url=school/update-incident', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editIncidentModal');
            loadIncidents();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteIncident(id) {
    if (!(await ndaConfirm('¿Eliminar este incidente permanentemente?'))) return;
    try {
        const response = await fetch(`?url=school/delete-incident&id=${id}`);
        const result = await response.json();
        if (result.success) {
            loadIncidents();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

function svgPin() { return '📍'; }
function svgCheck() { return '✅'; }

document.getElementById('addIncidentForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('tipo', document.getElementById('incidentType').value);
    formData.append('ubicacion', document.getElementById('incidentLocation').value);
    formData.append('descripcion', document.getElementById('incidentDescription').value);
    formData.append('prioridad', document.getElementById('incidentPriority').value);
    const fileInput = document.getElementById('incidentImage');
    if (fileInput && fileInput.files[0]) {
        formData.append('imagen', fileInput.files[0]);
    }

    try {
        const response = await fetch('?url=school/add-incident', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            closeModal('addIncidentModal');
            this.reset();
            loadIncidents();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
        console.error(e);
    }
});

async function resolveIncident(id) {
    if (!(await ndaConfirm('¿Marcar este incidente como resuelto?'))) return;
    try {
        const response = await fetch(`?url=school/resolve-incident&id=${id}`);
        const result = await response.json();
        if (result.success) {
            loadIncidents();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
        console.error(e);
    }
}

// ─── SIMULACROS ───
let __drillsCache = [];

async function loadDrills() {
    const tbody = document.getElementById('drillsTableBody');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Cargando simulacros...</td></tr>';

    try {
        const response = await fetch('?url=school/drills');
        const drills = await response.json();

        if (drills.error) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Error: ${drills.error}</td></tr>`;
            return;
        }
        __drillsCache = Array.isArray(drills) ? drills : [];

        if (drills.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay simulacros registrados</td></tr>';
            return;
        }

        tbody.innerHTML = drills.map(d => `
            <tr>
                <td><strong>${d.nombre}</strong></td>
                <td>${d.fecha}</td>
                <td>${d.hora}</td>
                <td>${d.total_asistencia || 0} registros</td>
                <td>${d.estado === 'activo'
                        ? '<span class="drill-status active">En curso</span>'
                        : d.estado === 'finalizado'
                            ? '<span class="drill-status done">Finalizado</span>'
                            : '<span class="drill-status planned">Programado</span>'}</td>
                <td>
                    ${window.__ndaIsSchoolStaff ? `<button class="school-attendance-btn" onclick="showAttendanceForDrill(${d.simulacros_id})">Ver</button>` : ''}
                    ${window.__ndaIsSchoolStaff && d.estado !== 'activo' && d.estado !== 'finalizado' ? `<button class="school-attendance-btn" onclick="editDrill(${d.simulacros_id})">Editar</button>` : ''}
                    ${window.__ndaIsSchoolStaff && d.estado !== 'activo' && d.estado !== 'finalizado' ? `<button class="school-attendance-btn" style="color:var(--green);" onclick="activateDrillAlert(${d.simulacros_id})">Activar alerta</button>` : ''}
                    ${window.__ndaIsSchoolStaff && d.estado === 'activo' ? `<button class="school-attendance-btn" style="color:var(--acc3);" onclick="finishDrillAlert(${d.simulacros_id})">Finalizar</button>` : ''}
                    ${window.__ndaIsSchoolAdmin ? `<button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteDrill(${d.simulacros_id})">Eliminar</button>` : ''}
                </td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar simulacros</td></tr>';
        console.error(e);
    }
}

function editDrill(id) {
    const d = __drillsCache.find(x => String(x.simulacros_id) === String(id));
    if (!d) { ndaAlert('No se encontró el simulacro.'); return; }
    document.getElementById('editDrillId').value = d.simulacros_id;
    document.getElementById('editDrillName').value = d.nombre || '';
    document.getElementById('editDrillDate').value = d.fecha || '';
    document.getElementById('editDrillTime').value = d.hora || '';
    document.getElementById('editDrillType').value = d.tipo || 'Sísmico';
    document.getElementById('editDrillDescription').value = d.descripcion || '';
    openModal('editDrillModal');
}

document.getElementById('editDrillForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editDrillId').value,
        nombre: document.getElementById('editDrillName').value,
        fecha: document.getElementById('editDrillDate').value,
        hora: document.getElementById('editDrillTime').value,
        tipo: document.getElementById('editDrillType').value,
        descripcion: document.getElementById('editDrillDescription').value,
    };
    try {
        const response = await fetch('?url=school/update-drill', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editDrillModal');
            loadDrills();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function activateDrillAlert(id) {
    if (!(await ndaConfirm('Esto enviará una alerta en vivo a toda la comunidad de la institución. ¿Continuar?'))) return;
    try {
        const response = await fetch('?url=school/activate-alert', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await response.json();
        if (result.success) {
            loadDrills();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

async function finishDrillAlert(id) {
    if (!(await ndaConfirm('¿Marcar este simulacro como finalizado?'))) return;
    try {
        const response = await fetch('?url=school/finish-alert', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await response.json();
        if (result.success) {
            loadDrills();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

document.getElementById('addDrillForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('drillName').value,
        tipo: document.getElementById('drillType').value,
        fecha: document.getElementById('drillDate').value,
        hora: document.getElementById('drillTime').value
    };

    try {
        const response = await fetch('?url=school/add-drill', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Simulacro creado correctamente');
            closeModal('addDrillModal');
            this.reset();
            loadDrills();
            loadDrillSelect();
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

function showAttendanceForDrill(id) {
    // Cambiar a la pestaña de asistencia y seleccionar el simulacro
    const select = document.getElementById('drillSelect');
    if (select) {
        select.value = id;
        showSchoolTab('attendance');
        setTimeout(loadAttendance, 300);
    }
}

async function deleteDrill(id) {
    if (!(await ndaConfirm('¿Eliminar este simulacro?'))) return;
    try {
        const response = await fetch(`?url=school/delete-drill&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Simulacro eliminado');
            loadDrills();
            loadDrillSelect();
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// ─── REPORTES ───
let __ndaLastReportData = null;

async function loadReports() {
    const container = document.getElementById('reportsContainer');
    if (!container) return;

    container.innerHTML = '<div class="text-center" style="padding:40px;color:var(--text3);">Cargando reportes...</div>';

    try {
        const response = await fetch('?url=school/reports');
        const data = await response.json();

        if (data.error) {
            container.innerHTML = `<div class="text-center" style="padding:40px;color:var(--text3);">Error: ${data.error}</div>`;
            return;
        }
        __ndaLastReportData = data;

        const att = data.attendance || {};
        const incidentsByType = data.incidents_by_type || [];
        const studentsByClassroom = data.students_by_classroom || [];
        const drillsByStatus = data.drills_by_status || [];
        const drillStatusLabel = { programado: 'Programados', activo: 'En curso', finalizado: 'Finalizados' };

        container.innerHTML = `
            <div class="school-grid-2">
                <div class="school-report-card">
                    <h4>📊 Estadísticas de Asistencia</h4>
                    <div class="school-report-stat"><span>Total registros</span><span class="value">${att.total || 0}</span></div>
                    <div class="school-report-stat"><span>✅ Presentes</span><span class="value" style="color:var(--teal);">${att.presentes || 0}</span></div>
                    <div class="school-report-stat"><span>❌ Ausentes</span><span class="value" style="color:var(--acc2);">${att.ausentes || 0}</span></div>
                    <div class="school-report-stat"><span>⚠️ Heridos</span><span class="value" style="color:var(--acc3);">${att.heridos || 0}</span></div>
                </div>

                <div class="school-report-card">
                    <h4>📋 Incidentes por Tipo</h4>
                    ${incidentsByType.length === 0 ? '<p style="color:var(--text3);">No hay incidentes registrados</p>' :
                        incidentsByType.map(i => `
                            <div class="school-report-stat"><span>${i.tipo}</span><span class="value">${i.total}</span></div>
                        `).join('')
                    }
                </div>

                <div class="school-report-card">
                    <h4>🔔 Simulacros por Estado</h4>
                    ${drillsByStatus.length === 0 ? '<p style="color:var(--text3);">No hay simulacros registrados</p>' :
                        drillsByStatus.map(d => `
                            <div class="school-report-stat"><span>${drillStatusLabel[d.estado] || d.estado}</span><span class="value">${d.total}</span></div>
                        `).join('')
                    }
                </div>

                <div class="school-report-card" style="grid-column:1/-1;">
                    <h4>🏢 Alumnos por Aula</h4>
                    ${studentsByClassroom.length === 0 ? '<p style="color:var(--text3);">No hay datos de alumnos por aula</p>' :
                        `<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:8px;">
                            ${studentsByClassroom.map(c => `
                                <div style="background:var(--bg3);padding:10px;border-radius:8px;text-align:center;border:1px solid var(--border);">
                                    <div style="font-weight:700;color:var(--text);">${c.nombre}</div>
                                    <div style="color:var(--acc);font-size:1.2rem;font-weight:800;">${c.total}</div>
                                    <div style="font-size:0.65rem;color:var(--text3);">alumnos</div>
                                </div>
                            `).join('')}
                        </div>`
                    }
                </div>
            </div>
        `;
    } catch (e) {
        container.innerHTML = '<div class="text-center" style="padding:40px;color:var(--text3);">Error al cargar reportes</div>';
        console.error(e);
    }
}

function exportReport() {
    if (!window.__ndaIsSchoolAdmin) {
        ndaAlert('Solo un administrador puede exportar reportes.', 'error');
        return;
    }
    if (!__ndaLastReportData) {
        ndaAlert('Espera a que carguen los reportes antes de exportar.', 'error');
        return;
    }
    const data = __ndaLastReportData;
    const att = data.attendance || {};
    const rows = [];

    rows.push(['Asistencia a simulacros']);
    rows.push(['Total registros', att.total || 0]);
    rows.push(['Presentes', att.presentes || 0]);
    rows.push(['Ausentes', att.ausentes || 0]);
    rows.push(['Heridos', att.heridos || 0]);
    rows.push([]);

    rows.push(['Incidentes por tipo']);
    rows.push(['Tipo', 'Total']);
    (data.incidents_by_type || []).forEach(i => rows.push([i.tipo, i.total]));
    rows.push([]);

    rows.push(['Simulacros por estado']);
    rows.push(['Estado', 'Total']);
    const drillStatusLabel = { programado: 'Programados', activo: 'En curso', finalizado: 'Finalizados' };
    (data.drills_by_status || []).forEach(d => rows.push([drillStatusLabel[d.estado] || d.estado, d.total]));
    rows.push([]);

    rows.push(['Alumnos por aula']);
    rows.push(['Aula', 'Total']);
    (data.students_by_classroom || []).forEach(c => rows.push([c.nombre, c.total]));

    const csv = rows.map(row => row.map(cell => {
        const v = String(cell ?? '');
        return /[",\n;]/.test(v) ? '"' + v.replace(/"/g, '""') + '"' : v;
    }).join(';')).join('\n');

    const blob = new Blob(['﻿' + csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    const fecha = new Date().toISOString().slice(0, 10);
    a.href = url;
    a.download = `reporte-escolar-${fecha}.csv`;
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(url);
    ndaAlert('📤 Reporte exportado.', 'success');
}

// ─── CARGAR AULAS PARA EL FORMULARIO ───
async function loadClassroomSelect() {
    const selects = ['studentClassroom'];
    for (const id of selects) {
        const select = document.getElementById(id);
        if (!select) continue;

        try {
            const response = await fetch('?url=school/classrooms');
            const classrooms = await response.json();

            if (!classrooms.error && classrooms.length > 0) {
                select.innerHTML = `<option value="">Seleccionar aula</option>` +
                    classrooms.map(c => `<option value="${c.aulas_id}">${c.nombre}</option>`).join('');
            }
        } catch (e) {
            console.error('Error loading classrooms:', e);
        }
    }
}

// ─── SECCIONES (18 aulas de bachillerato) ───
async function loadSections() {
    const grid = document.getElementById('sectionsGrid');
    if (!grid) return;
    grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando secciones...</div>';

    const showAll = document.getElementById('sectionsShowAll')?.checked ? '?all=1' : '';
    try {
        const response = await fetch('?url=school/sections' + showAll);
        const sections = await response.json();

        if (!Array.isArray(sections) || sections.length === 0) {
            grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">No hay secciones para mostrar. Si eres director, crea tu institución para generarlas automáticamente.</div>';
            return;
        }

        let teachers = [];
        if (window.__ndaIsSchoolAdmin) {
            try {
                const tRes = await fetch('?url=school/assignable-teachers');
                teachers = await tRes.json();
                if (!Array.isArray(teachers)) teachers = [];
            } catch (e) { teachers = []; }
        }

        const grados = {};
        sections.forEach(s => {
            const g = s.grado || 'Sin año';
            if (!grados[g]) grados[g] = [];
            grados[g].push(s);
        });

        grid.innerHTML = Object.keys(grados).sort().map(grado => `
            <div class="section-group">
                <h4>${grado}</h4>
                <div class="section-cards">
                    ${grados[grado].map(s => `
                        <div class="section-card">
                            <div class="section-card-top" onclick="filterStudentsBySection(${s.aulas_id}, '${s.nombre}')" style="cursor:pointer;">
                                <strong>Sección ${s.seccion}</strong>
                                <span class="section-count">${s.total_alumnos || 0} alumnos</span>
                            </div>
                            ${window.__ndaIsSchoolAdmin ? `
                                <select class="section-teacher-select" onchange="assignSectionTeacher(${s.aulas_id}, this.value)" onclick="event.stopPropagation()">
                                    <option value="">Sin docente asignado</option>
                                    ${teachers.map(t => `<option value="${t.usuarios_id}" ${String(t.usuarios_id) === String(s.maestro_id) ? 'selected' : ''}>${t.nombre}</option>`).join('')}
                                </select>
                            ` : `<div class="section-teacher">${s.teacher ? s.teacher : 'Sin docente asignado'}</div>`}
                        </div>
                    `).join('')}
                </div>
            </div>
        `).join('');
    } catch (e) {
        grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar secciones</div>';
        console.error(e);
    }
}

async function assignSectionTeacher(aulaId, maestroId) {
    try {
        const response = await fetch('?url=school/assign-teacher', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ aula_id: aulaId, maestro_id: maestroId || null })
        });
        const result = await response.json();
        if (!result.success) ndaAlert('Error: ' + (result.error || 'Desconocido'));
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

function filterStudentsBySection(aulaId, nombre) {
    showSchoolTab('students');
    setTimeout(async () => {
        const tbody = document.getElementById('studentsTableBody');
        if (!tbody) return;
        tbody.innerHTML = `<tr><td colspan="6" class="text-center">Cargando alumnos de ${nombre}...</td></tr>`;
        try {
            const response = await fetch('?url=school/students&aula_id=' + aulaId + '&per_page=100');
            const result = await response.json();
            const students = result.data || [];
            if (students.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center">No hay alumnos registrados en ${nombre}</td></tr>`;
                return;
            }
            tbody.innerHTML = students.map(s => `
                <tr>
                    <td>${s.codigo || ''}</td>
                    <td>${s.nombre} ${s.apellido || ''}</td>
                    <td>${s.classroom || nombre}</td>
                    <td>${s.telefono_emergencia || '-'}</td>
                    <td>${s.teacher || '-'}</td>
                    <td><button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteStudent(${s.estudiantes_id})">Eliminar</button></td>
                </tr>
            `).join('');
        } catch (e) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar alumnos</td></tr>';
        }
    }, 50);
}

// ─── CROQUIS INTERACTIVO ───
const CROQUIS_LABELS = {
    encuentro: 'Punto de encuentro',
    zona_segura: 'Zona segura',
    extintor: 'Extintor',
    botiquin: 'Botiquín',
    salida: 'Salida de emergencia',
    otro: 'Otro'
};

async function loadCroquis() {
    const board = document.getElementById('croquisBoard');
    if (!board) return;
    board.innerHTML = '<div class="text-center" style="padding:30px;color:var(--text3);">Cargando croquis...</div>';

    try {
        const response = await fetch('?url=school/croquis');
        const data = await response.json();

        if (!data.imagen) {
            board.innerHTML = `<div class="croquis-empty">
                <p>Todavía no se ha subido un plano de la institución.</p>
                <p class="school-hint">El director puede subir una imagen del croquis con el botón "Subir plano".</p>
            </div>`;
            return;
        }

        board.innerHTML = `<div class="croquis-image-wrap" id="croquisImageWrap">
            <img src="${data.imagen}" alt="Croquis de la institución" draggable="false">
        </div>`;

        const wrap = document.getElementById('croquisImageWrap');
        (data.puntos || []).forEach(p => {
            const dot = document.createElement('div');
            dot.className = 'croquis-marker ' + p.tipo;
            dot.style.left = p.pos_x + '%';
            dot.style.top = p.pos_y + '%';
            dot.title = p.nombre;
            dot.innerHTML = `<span class="croquis-marker-tooltip"><strong>${p.nombre}</strong><br>${CROQUIS_LABELS[p.tipo] || p.tipo}${p.descripcion ? '<br>' + p.descripcion : ''}${window.__ndaIsSchoolStaff ? `<br><a href="#" onclick="deleteCroquisPoint(${p.puntos_croquis_id});return false;">Eliminar</a>` : ''}</span>`;
            wrap.appendChild(dot);
        });

        if (window.__ndaIsSchoolStaff) {
            wrap.addEventListener('click', function (e) {
                if (e.target.closest('.croquis-marker')) return;
                const rect = wrap.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                document.getElementById('croquisPointX').value = x.toFixed(2);
                document.getElementById('croquisPointY').value = y.toFixed(2);
                openModal('addCroquisPointModal');
            });
        }
    } catch (e) {
        board.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar el croquis</div>';
        console.error(e);
    }
}

async function uploadCroquisImage(input) {
    if (!input.files[0]) return;
    const formData = new FormData();
    formData.append('imagen', input.files[0]);
    try {
        const response = await fetch('?url=school/croquis-upload', { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            loadCroquis();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
    input.value = '';
}

document.getElementById('addCroquisPointForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        tipo: document.getElementById('croquisPointType').value,
        nombre: document.getElementById('croquisPointName').value,
        descripcion: document.getElementById('croquisPointDesc').value,
        pos_x: document.getElementById('croquisPointX').value,
        pos_y: document.getElementById('croquisPointY').value
    };
    try {
        const response = await fetch('?url=school/croquis-add-point', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('addCroquisPointModal');
            this.reset();
            loadCroquis();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteCroquisPoint(id) {
    if (!(await ndaConfirm('¿Quitar este punto del croquis?'))) return;
    try {
        await fetch(`?url=school/croquis-del-point&id=${id}`);
        loadCroquis();
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

// ─── TABLERO DE CORCHO ───
async function loadBoard() {
    const board = document.getElementById('corkboard');
    if (!board) return;
    board.innerHTML = '<div class="text-center" style="padding:30px;color:var(--text3);">Cargando tablero...</div>';

    try {
        const response = await fetch('?url=school/board');
        const notes = await response.json();

        if (!Array.isArray(notes) || notes.length === 0) {
            board.innerHTML = '<div class="corkboard-empty">Aún no hay notas. ¡Sé el primero en pegar una!</div>';
            return;
        }

        board.innerHTML = notes.map(n => `
            <div class="sticky-note ${n.color}" data-id="${n.corcho_notas_id}" style="left:${n.pos_x}%; top:${n.pos_y}%; transform: rotate(${n.rotacion}deg);">
                <button class="sticky-note-del" onclick="deleteBoardNote(${n.corcho_notas_id})" title="Quitar nota">&times;</button>
                <p>${escapeHtml(n.texto)}</p>
                <span class="sticky-note-author">${n.autor}${n.visibilidad && n.visibilidad !== 'todos' ? ' · 🔒' : ''}</span>
            </div>
        `).join('');

        enableStickyNoteDrag(board);
    } catch (e) {
        board.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar el tablero</div>';
        console.error(e);
    }
}

// Arrastrar y soltar un post-it dentro del tablero; guarda la nueva
// posicion (%) al soltar. Solo el autor (o el director) puede moverla —
// si el servidor rechaza el cambio, se recarga el tablero para revertir.
function enableStickyNoteDrag(board) {
    board.querySelectorAll('.sticky-note').forEach(note => {
        note.addEventListener('pointerdown', function (e) {
            if (e.target.closest('.sticky-note-del')) return;
            e.preventDefault();
            note.setPointerCapture(e.pointerId);
            note.classList.add('dragging');
            const boardRect = board.getBoundingClientRect();

            function onMove(ev) {
                let x = ((ev.clientX - boardRect.left) / boardRect.width) * 100;
                let y = ((ev.clientY - boardRect.top) / boardRect.height) * 100;
                x = Math.max(0, Math.min(94, x));
                y = Math.max(0, Math.min(90, y));
                note.style.left = x + '%';
                note.style.top = y + '%';
            }
            function onUp() {
                note.classList.remove('dragging');
                note.removeEventListener('pointermove', onMove);
                note.removeEventListener('pointerup', onUp);
                const x = parseFloat(note.style.left);
                const y = parseFloat(note.style.top);
                fetch('?url=school/board-move', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: note.dataset.id, pos_x: x.toFixed(2), pos_y: y.toFixed(2) })
                }).then(r => r.json()).then(result => {
                    if (!result.success) loadBoard();
                }).catch(() => loadBoard());
            }
            note.addEventListener('pointermove', onMove);
            note.addEventListener('pointerup', onUp);
        });
    });
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

// Muestra/oculta la lista de roles especificos segun el checkbox "Todos".
function toggleNoteVisAll(checkbox) {
    const rolesBox = document.getElementById('noteVisRoles');
    if (rolesBox) rolesBox.style.display = checkbox.checked ? 'none' : 'inline-flex';
}

document.getElementById('addBoardNoteForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const isAll = document.getElementById('noteVisTodos')?.checked ?? true;
    const visibilidad = isAll
        ? 'todos'
        : Array.from(document.querySelectorAll('.noteVisRole:checked')).map(el => el.value);

    const data = {
        texto: document.getElementById('noteText').value,
        color: document.querySelector('input[name="noteColor"]:checked')?.value || 'amarillo',
        visibilidad: visibilidad,
        pos_x: Math.random() * 70 + 5,
        pos_y: Math.random() * 60 + 5,
        rotacion: (Math.random() * 12 - 6).toFixed(1)
    };
    try {
        const response = await fetch('?url=school/board-add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('addBoardNoteModal');
            this.reset();
            const rolesBox = document.getElementById('noteVisRoles');
            if (rolesBox) rolesBox.style.display = 'none';
            loadBoard();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteBoardNote(id) {
    if (!(await ndaConfirm('¿Quitar esta nota del corcho?'))) return;
    try {
        await fetch(`?url=school/board-delete&id=${id}`);
        loadBoard();
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

// ─── SOLICITUDES DE INGRESO (director) ───
async function loadJoinRequests() {
    const list = document.getElementById('requestsList');
    if (!list) return;
    list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando solicitudes...</div>';

    const roleLabels = { docente: 'Docente', alumno: 'Alumno', padre: 'Padre / Encargado', administrativo: 'Personal administrativo' };

    try {
        const response = await fetch('?url=school/join-requests');
        const requests = await response.json();

        if (!Array.isArray(requests) || requests.length === 0) {
            list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">No hay solicitudes pendientes</div>';
            return;
        }

        list.innerHTML = requests.map(r => `
            <div class="request-card">
                <div>
                    <strong>${r.usuario_nombre}</strong>
                    <span class="request-role">${roleLabels[r.rol_solicitado] || r.rol_solicitado}</span>
                    <p class="school-hint" style="margin:4px 0 0;">${r.usuario_email}</p>
                    ${r.mensaje ? `<p class="request-message">"${escapeHtml(r.mensaje)}"</p>` : ''}
                </div>
                <div class="request-actions">
                    <button class="school-btn primary" onclick="approveRequest(${r.solicitudes_institucion_id})">Aprobar</button>
                    <button class="school-btn secondary" onclick="rejectRequest(${r.solicitudes_institucion_id})">Rechazar</button>
                </div>
            </div>
        `).join('');
    } catch (e) {
        list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar solicitudes</div>';
        console.error(e);
    }
}

async function approveRequest(id) {
    try {
        const response = await fetch('?url=school/approve-request', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id })
        });
        const result = await response.json();
        if (result.success) loadJoinRequests(); else ndaAlert('Error: ' + (result.error || 'Desconocido'));
    } catch (e) { ndaAlert('Error de conexión'); }
}

async function rejectRequest(id) {
    if (!(await ndaConfirm('¿Rechazar esta solicitud?'))) return;
    try {
        const response = await fetch('?url=school/reject-request', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id })
        });
        const result = await response.json();
        if (result.success) loadJoinRequests(); else ndaAlert('Error: ' + (result.error || 'Desconocido'));
    } catch (e) { ndaAlert('Error de conexión'); }
}

// ─── INSTITUCIONES (Admin General) ───
let __institutionsCache = [];
let __institutionsPage = 1;

async function loadInstitutions(page) {
    const tbody = document.getElementById('institutionsTableBody');
    if (!tbody) return;
    __institutionsPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Cargando instituciones...</td></tr>';

    const q = document.getElementById('institutionsSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/institutions&q=${encodeURIComponent(q)}&page=${__institutionsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __institutionsCache = result.data || [];

        if (__institutionsCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay instituciones registradas</td></tr>';
            renderPagination('institutionsPagination', 1, 1, 'loadInstitutions');
            return;
        }

        tbody.innerHTML = __institutionsCache.map(i => `
            <tr>
                <td><strong>${i.nombre}</strong></td>
                <td>${i.correo || '—'}</td>
                <td>${i.telefono || '—'}</td>
                <td>${i.direccion || '—'}</td>
                <td>${i.total_usuarios || 0}</td>
                <td>
                    <button class="school-attendance-btn" onclick="viewInstitutionStats(${i.instituciones_id}, '${(i.nombre || '').replace(/'/g, "\\'")}')">Ver detalle</button>
                    <button class="school-attendance-btn" onclick="editInstitution(${i.instituciones_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteInstitution(${i.instituciones_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('institutionsPagination', result.page, result.total_pages, 'loadInstitutions');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar instituciones</td></tr>';
        console.error(e);
    }
}

async function viewInstitutionStats(id, nombre) {
    document.getElementById('institutionStatsTitle').textContent = 'Detalle — ' + nombre;
    const grid = document.getElementById('institutionStatsGrid');
    grid.innerHTML = '<div class="text-center" style="padding:12px;grid-column:1/-1;">Cargando...</div>';
    openModal('institutionStatsModal');
    try {
        const response = await fetch(`?url=school/institution-stats&id=${id}`);
        const result = await response.json();
        if (result.error) {
            grid.innerHTML = `<div class="text-center" style="grid-column:1/-1;">Error: ${result.error}</div>`;
            return;
        }
        const s = result.stats;
        const tiles = [
            ['Docentes', s.docentes],
            ['Alumnos', s.alumnos],
            ['Personal administrativo', s.administrativos],
            ['Padres/Encargados', s.padres],
            ['Rutas de evacuación', s.rutas],
            ['Incidentes abiertos', s.incidentes_abiertos],
            ['Incidentes resueltos', s.incidentes_resueltos],
        ];
        grid.innerHTML = tiles.map(([label, val]) => `
            <div class="school-stat">
                <div class="school-stat-number">${val}</div>
                <div class="school-stat-label">${label}</div>
            </div>
        `).join('');
    } catch (e) {
        grid.innerHTML = '<div class="text-center" style="grid-column:1/-1;">Error al cargar el detalle</div>';
        console.error(e);
    }
}

const debounceInstitutionsSearch = debounce(() => loadInstitutions(1), 350);

document.getElementById('addInstitutionForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('institutionName').value,
        correo: document.getElementById('institutionEmail').value,
        telefono: document.getElementById('institutionPhone').value,
        direccion: document.getElementById('institutionAddress').value,
    };
    try {
        const response = await fetch('?url=school/add-institution', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Institución agregada correctamente');
            closeModal('addInstitutionModal');
            this.reset();
            loadInstitutions(__institutionsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
});

function editInstitution(id) {
    const i = __institutionsCache.find(x => String(x.instituciones_id) === String(id));
    if (!i) { ndaAlert('No se encontró la institución.'); return; }
    document.getElementById('editInstitutionId').value = i.instituciones_id;
    document.getElementById('editInstitutionName').value = i.nombre || '';
    document.getElementById('editInstitutionEmail').value = i.correo || '';
    document.getElementById('editInstitutionPhone').value = i.telefono || '';
    document.getElementById('editInstitutionAddress').value = i.direccion || '';
    openModal('editInstitutionModal');
}

document.getElementById('editInstitutionForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editInstitutionId').value,
        nombre: document.getElementById('editInstitutionName').value,
        correo: document.getElementById('editInstitutionEmail').value,
        telefono: document.getElementById('editInstitutionPhone').value,
        direccion: document.getElementById('editInstitutionAddress').value,
    };
    try {
        const response = await fetch('?url=school/update-institution', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editInstitutionModal');
            loadInstitutions(__institutionsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteInstitution(id) {
    if (!(await ndaConfirm('¿Eliminar esta institución? Se eliminarán también sus usuarios, aulas y datos asociados.'))) return;
    try {
        const response = await fetch(`?url=school/delete-institution&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Institución eliminada');
            loadInstitutions(__institutionsPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
}

// ─── USUARIOS Y ROLES ───
let __usersCache = [];
let __usersPage = 1;
const roleLabelMap = {
    admin: 'Admin General', director: 'Admin Institucional', docente: 'Docente',
    alumno: 'Estudiante', padre: 'Padre', administrativo: 'Personal', user: 'Usuario registrado'
};

async function populateInstitutionSelect(selectId, selectedId) {
    const select = document.getElementById(selectId);
    if (!select) return;
    if (!window.__ndaIsGlobalAdmin) {
        // Un director solo gestiona su propia institucion: no necesita elegir.
        select.innerHTML = `<option value="${window.__ndaMyInstitutionId || ''}">Mi institución</option>`;
        select.disabled = true;
        return;
    }
    select.disabled = false;
    try {
        const res = await fetch('?url=school/institutions&per_page=100');
        const result = await res.json();
        const list = result.data || [];
        select.innerHTML = '<option value="">Sin institución</option>' +
            list.map(i => `<option value="${i.instituciones_id}" ${String(i.instituciones_id) === String(selectedId) ? 'selected' : ''}>${i.nombre}</option>`).join('');
    } catch (e) { /* deja el select con la opcion vacia */ }
}

async function loadUsers(page) {
    const tbody = document.getElementById('usersTableBody');
    if (!tbody) return;
    __usersPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Cargando usuarios...</td></tr>';

    const q = document.getElementById('usersSearch')?.value.trim() || '';
    const role = document.getElementById('usersRoleFilter')?.value || '';

    try {
        const response = await fetch(`?url=school/users&q=${encodeURIComponent(q)}&role=${encodeURIComponent(role)}&page=${__usersPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __usersCache = result.data || [];

        if (__usersCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay usuarios que coincidan</td></tr>';
            renderPagination('usersPagination', 1, 1, 'loadUsers');
            return;
        }

        tbody.innerHTML = __usersCache.map(u => `
            <tr>
                <td><strong>${u.nombre}</strong></td>
                <td>${u.email}</td>
                <td><span class="chip b">${roleLabelMap[u.role] || u.role}</span></td>
                <td>${u.institucion_nombre || '—'}</td>
                <td>${u.estado_institucional || '—'}</td>
                <td>
                    <button class="school-attendance-btn" onclick="editUser(${u.usuarios_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteUser(${u.usuarios_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('usersPagination', result.page, result.total_pages, 'loadUsers');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar usuarios</td></tr>';
        console.error(e);
    }
}

const debounceUsersSearch = debounce(() => loadUsers(1), 350);

document.getElementById('userRole')?.addEventListener('change', function () {
    document.getElementById('userInstitutionGroup').style.display = this.value === 'user' ? 'none' : '';
});

document.getElementById('addUserModal')?.addEventListener('click', function (e) {
    if (e.target === this) return;
});
document.querySelector('[onclick="openModal(\'addUserModal\')"]')?.addEventListener('click', () => populateInstitutionSelect('userInstitutionId'));

document.getElementById('addUserForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('userName').value,
        email: document.getElementById('userEmail').value,
        password: document.getElementById('userPassword').value,
        role: document.getElementById('userRole').value,
        institucion_id: document.getElementById('userInstitutionId').value || null,
        telefono: document.getElementById('userPhone').value,
    };
    try {
        const response = await fetch('?url=school/add-user', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Usuario agregado correctamente');
            closeModal('addUserModal');
            this.reset();
            loadUsers(__usersPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
});

function editUser(id) {
    const u = __usersCache.find(x => String(x.usuarios_id) === String(id));
    if (!u) { ndaAlert('No se encontró el usuario.'); return; }
    document.getElementById('editUserId').value = u.usuarios_id;
    document.getElementById('editUserName').value = u.nombre || '';
    document.getElementById('editUserRole').value = u.role || 'user';
    document.getElementById('editUserEstado').value = u.estado_institucional || 'ninguno';
    document.getElementById('editUserPhone').value = u.telefono || '';
    openModal('editUserModal');
}

document.getElementById('editUserForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editUserId').value,
        nombre: document.getElementById('editUserName').value,
        role: document.getElementById('editUserRole').value,
        estado_institucional: document.getElementById('editUserEstado').value,
        telefono: document.getElementById('editUserPhone').value,
    };
    try {
        const response = await fetch('?url=school/update-user', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editUserModal');
            loadUsers(__usersPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteUser(id) {
    if (!(await ndaConfirm('¿Eliminar este usuario? Se eliminarán también sus datos asociados (alumno, docente, etc.).'))) return;
    try {
        const response = await fetch(`?url=school/delete-user&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Usuario eliminado');
            loadUsers(__usersPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
}

// ─── NOTICIAS INTERNAS ───
let __newsCache = [];
let __newsPage = 1;

async function loadNews(page) {
    const list = document.getElementById('newsList');
    if (!list) return;
    __newsPage = page || 1;
    list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando noticias...</div>';

    try {
        const response = await fetch(`?url=school/news&page=${__newsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            list.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);">Error: ${result.error}</div>`;
            return;
        }
        __newsCache = result.data || [];

        if (__newsCache.length === 0) {
            list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">No hay noticias publicadas todavía</div>';
            renderPagination('newsPagination', 1, 1, 'loadNews');
            return;
        }

        list.innerHTML = __newsCache.map(n => `
            <div class="school-card" style="margin-bottom:12px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                    <h3 style="margin:0;">${n.titulo}${!n.instituciones_id ? ' <span class="chip b">Global</span>' : ''}</h3>
                    ${window.__ndaIsSchoolAdmin ? `<span>
                        <button class="school-attendance-btn" onclick="editNews(${n.noticias_internas_id})">Editar</button>
                        <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteNews(${n.noticias_internas_id})">Eliminar</button>
                    </span>` : ''}
                </div>
                <p style="white-space:pre-wrap;">${n.contenido}</p>
                <span style="font-size:0.7rem;color:var(--text3);">Por ${n.autor || 'Administración'} · ${new Date(n.created_at).toLocaleString('es-SV')}</span>
            </div>
        `).join('');

        renderPagination('newsPagination', result.page, result.total_pages, 'loadNews');
    } catch (e) {
        list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar noticias</div>';
        console.error(e);
    }
}

document.getElementById('addNewsForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        titulo: document.getElementById('newsTitle').value,
        contenido: document.getElementById('newsContent').value,
    };
    try {
        const response = await fetch('?url=school/add-news', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('addNewsModal');
            this.reset();
            loadNews(__newsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

function editNews(id) {
    const n = __newsCache.find(x => String(x.noticias_internas_id) === String(id));
    if (!n) { ndaAlert('No se encontró la noticia.'); return; }
    document.getElementById('editNewsId').value = n.noticias_internas_id;
    document.getElementById('editNewsTitle').value = n.titulo || '';
    document.getElementById('editNewsContent').value = n.contenido || '';
    openModal('editNewsModal');
}

document.getElementById('editNewsForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editNewsId').value,
        titulo: document.getElementById('editNewsTitle').value,
        contenido: document.getElementById('editNewsContent').value,
    };
    try {
        const response = await fetch('?url=school/update-news', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            closeModal('editNewsModal');
            loadNews(__newsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteNews(id) {
    if (!(await ndaConfirm('¿Eliminar esta noticia?'))) return;
    try {
        const response = await fetch(`?url=school/delete-news&id=${id}`);
        const result = await response.json();
        if (result.success) {
            loadNews(__newsPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

// ─── BLOG DE LUGARES EN RIESGO ───
let __blogPage = 1;

async function loadBlog(page) {
    const list = document.getElementById('blogList');
    if (!list) return;
    __blogPage = page || 1;
    list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando publicaciones...</div>';

    try {
        const response = await fetch(`?url=school/blog&page=${__blogPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            list.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);">Error: ${result.error}</div>`;
            return;
        }
        const rows = result.data || [];

        if (rows.length === 0) {
            list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Nadie ha publicado todavía. ¡Sé el primero en reportar un lugar en riesgo!</div>';
            renderPagination('blogPagination', 1, 1, 'loadBlog');
            return;
        }

        list.innerHTML = rows.map(b => `
            <div class="school-card" style="margin-bottom:12px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                    <h3 style="margin:0;">📍 ${b.titulo}</h3>
                    ${(window.__ndaIsSchoolAdmin || String(b.usuarios_id) === String(window.__ndaMyUserId)) ? `
                        <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteBlogPost(${b.blog_riesgos_id})">Eliminar</button>
                    ` : ''}
                </div>
                ${b.imagen ? `<img class="school-incident-photo" src="${b.imagen}" alt="Foto del lugar" onclick="window.open('${b.imagen}','_blank')">` : ''}
                ${b.ubicacion ? `<div class="school-incident-location">📍 ${b.ubicacion}</div>` : ''}
                <p style="white-space:pre-wrap;">${escapeHtml(b.descripcion)}</p>
                <span style="font-size:0.7rem;color:var(--text3);">Por ${b.autor} (${roleLabelMap[b.autor_role] || b.autor_role}) · ${new Date(b.created_at).toLocaleString('es-SV')}</span>
            </div>
        `).join('');

        renderPagination('blogPagination', result.page, result.total_pages, 'loadBlog');
    } catch (e) {
        list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar el blog</div>';
        console.error(e);
    }
}

document.getElementById('addBlogForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('titulo', document.getElementById('blogTitle').value);
    formData.append('ubicacion', document.getElementById('blogLocation').value);
    formData.append('descripcion', document.getElementById('blogDescription').value);
    const fileInput = document.getElementById('blogImage');
    if (fileInput && fileInput.files[0]) {
        formData.append('imagen', fileInput.files[0]);
    }

    try {
        const response = await fetch('?url=school/add-blog', { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            closeModal('addBlogModal');
            this.reset();
            loadBlog(__blogPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
        console.error(e);
    }
});

async function deleteBlogPost(id) {
    if (!(await ndaConfirm('¿Eliminar esta publicación?'))) return;
    try {
        const response = await fetch(`?url=school/delete-blog&id=${id}`);
        const result = await response.json();
        if (result.success) {
            loadBlog(__blogPage);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

// ─── BLOG PÚBLICO: ARTÍCULOS Y NOTICIAS (Admin General) ───
let __articulosCache = [];
let __articulosPage = 1;

async function loadArticulos(page) {
    const tbody = document.getElementById('articulosTableBody');
    if (!tbody) return;
    __articulosPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando artículos...</td></tr>';

    const q = document.getElementById('articulosSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=admin/articulos&q=${encodeURIComponent(q)}&page=${__articulosPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __articulosCache = result.data || [];

        if (__articulosCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay artículos todavía</td></tr>';
            renderPagination('articulosPagination', 1, 1, 'loadArticulos');
            return;
        }

        tbody.innerHTML = __articulosCache.map(a => `
            <tr>
                <td><strong>${escapeHtml(a.titulo)}</strong></td>
                <td>${escapeHtml(a.cat)}</td>
                <td>${escapeHtml(a.autor_nombre)}</td>
                <td>${a.destacado == 1 ? '⭐ Sí' : '—'}</td>
                <td>
                    <button class="school-attendance-btn" onclick="editArticulo(${a.blog_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteArticulo(${a.blog_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('articulosPagination', result.page, result.total_pages, 'loadArticulos');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Error al cargar artículos</td></tr>';
        console.error(e);
    }
}

const debounceArticulosSearch = debounce(() => loadArticulos(1), 350);

function openArticuloModal() {
    document.getElementById('articuloForm').reset();
    document.getElementById('articuloId').value = '';
    document.getElementById('articuloModalTitle').textContent = 'Agregar artículo';
    document.getElementById('articuloColor').value = '#f29f05';
    document.getElementById('articuloAutor').value = 'Equipo NDA';
    document.getElementById('articuloTiempo').value = '5 min';
    openModal('articuloModal');
}

function editArticulo(id) {
    const a = __articulosCache.find(x => String(x.blog_id) === String(id));
    if (!a) { ndaAlert('No se encontró el artículo.'); return; }
    document.getElementById('articuloId').value = a.blog_id;
    document.getElementById('articuloModalTitle').textContent = 'Editar artículo';
    document.getElementById('articuloTitulo').value = a.titulo || '';
    document.getElementById('articuloSlug').value = a.slug || '';
    document.getElementById('articuloCat').value = a.cat || 'prevencion';
    document.getElementById('articuloTag').value = a.tag || '';
    document.getElementById('articuloColor').value = a.color || '#f29f05';
    document.getElementById('articuloAutor').value = a.autor_nombre || 'Equipo NDA';
    document.getElementById('articuloTiempo').value = a.tiempo || '5 min';
    document.getElementById('articuloExtracto').value = a.extracto || '';
    document.getElementById('articuloCuerpo').value = a.cuerpo || '';
    document.getElementById('articuloDestacado').checked = a.destacado == 1;
    openModal('articuloModal');
}

document.getElementById('articuloForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const id = document.getElementById('articuloId').value;
    const formData = new FormData();
    if (id) formData.append('id', id);
    formData.append('titulo', document.getElementById('articuloTitulo').value);
    formData.append('slug', document.getElementById('articuloSlug').value);
    formData.append('cat', document.getElementById('articuloCat').value);
    formData.append('tag', document.getElementById('articuloTag').value);
    formData.append('color', document.getElementById('articuloColor').value);
    formData.append('autor_nombre', document.getElementById('articuloAutor').value);
    formData.append('tiempo', document.getElementById('articuloTiempo').value);
    formData.append('extracto', document.getElementById('articuloExtracto').value);
    formData.append('cuerpo', document.getElementById('articuloCuerpo').value);
    if (document.getElementById('articuloDestacado').checked) formData.append('destacado', '1');
    const fileInput = document.getElementById('articuloImagen');
    if (fileInput && fileInput.files[0]) {
        formData.append('imagen', fileInput.files[0]);
    }

    try {
        const url = id ? '?url=admin/update-articulo' : '?url=admin/add-articulo';
        const response = await fetch(url, { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Artículo guardado correctamente');
            closeModal('articuloModal');
            this.reset();
            loadArticulos(__articulosPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

async function deleteArticulo(id) {
    if (!(await ndaConfirm('¿Eliminar este artículo? Ya no aparecerá en el blog público.'))) return;
    try {
        const response = await fetch(`?url=admin/delete-articulo&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Artículo eliminado');
            loadArticulos(__articulosPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
}

// ─── RECURSOS PDF DESCARGABLES (Admin General) ───
let __recursosCache = [];
let __recursosPage = 1;

function formatFileSize(bytes) {
    if (!bytes || bytes <= 0) return '—';
    const mb = bytes / (1024 * 1024);
    return mb >= 1 ? mb.toFixed(1) + ' MB' : (bytes / 1024).toFixed(0) + ' KB';
}

async function loadRecursos(page) {
    const tbody = document.getElementById('recursosTableBody');
    if (!tbody) return;
    __recursosPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando recursos...</td></tr>';

    const q = document.getElementById('recursosSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=admin/recursos&q=${encodeURIComponent(q)}&page=${__recursosPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __recursosCache = result.data || [];

        if (__recursosCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay recursos todavía</td></tr>';
            renderPagination('recursosPagination', 1, 1, 'loadRecursos');
            return;
        }

        tbody.innerHTML = __recursosCache.map(r => `
            <tr>
                <td><strong>${escapeHtml(r.titulo)}</strong></td>
                <td>${escapeHtml(r.categoria)}</td>
                <td>${formatFileSize(r.tamano_bytes)}</td>
                <td>${r.orden}</td>
                <td>
                    <button class="school-attendance-btn" onclick="editRecurso(${r.recursos_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteRecurso(${r.recursos_id})">Eliminar</button>
                </td>
            </tr>
        `).join('');

        renderPagination('recursosPagination', result.page, result.total_pages, 'loadRecursos');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Error al cargar recursos</td></tr>';
        console.error(e);
    }
}

const debounceRecursosSearch = debounce(() => loadRecursos(1), 350);

function openRecursoModal() {
    document.getElementById('recursoForm').reset();
    document.getElementById('recursoId').value = '';
    document.getElementById('recursoModalTitle').textContent = 'Agregar recurso';
    document.getElementById('recursoArchivoLabel').textContent = 'Archivo PDF *';
    document.getElementById('recursoArchivo').required = true;
    openModal('recursoModal');
}

function editRecurso(id) {
    const r = __recursosCache.find(x => String(x.recursos_id) === String(id));
    if (!r) { ndaAlert('No se encontró el recurso.'); return; }
    document.getElementById('recursoId').value = r.recursos_id;
    document.getElementById('recursoModalTitle').textContent = 'Editar recurso';
    document.getElementById('recursoTitulo').value = r.titulo || '';
    document.getElementById('recursoDescripcion').value = r.descripcion || '';
    document.getElementById('recursoCategoria').value = r.categoria || 'evacuacion';
    document.getElementById('recursoTags').value = r.tags || '';
    document.getElementById('recursoOrden').value = r.orden || 0;
    document.getElementById('recursoArchivoLabel').textContent = 'Reemplazar archivo PDF (opcional)';
    document.getElementById('recursoArchivo').required = false;
    openModal('recursoModal');
}

document.getElementById('recursoForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const id = document.getElementById('recursoId').value;
    const fileInput = document.getElementById('recursoArchivo');
    if (!id && (!fileInput.files || !fileInput.files[0])) {
        ndaAlert('❌ Debes seleccionar un archivo PDF');
        return;
    }
    const formData = new FormData();
    if (id) formData.append('id', id);
    formData.append('titulo', document.getElementById('recursoTitulo').value);
    formData.append('descripcion', document.getElementById('recursoDescripcion').value);
    formData.append('categoria', document.getElementById('recursoCategoria').value);
    formData.append('tags', document.getElementById('recursoTags').value);
    formData.append('orden', document.getElementById('recursoOrden').value);
    if (fileInput.files[0]) {
        formData.append('archivo', fileInput.files[0]);
    }

    try {
        const url = id ? '?url=admin/update-recurso' : '?url=admin/add-recurso';
        const response = await fetch(url, { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Recurso guardado correctamente');
            closeModal('recursoModal');
            this.reset();
            loadRecursos(__recursosPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
});

async function deleteRecurso(id) {
    if (!(await ndaConfirm('¿Eliminar este recurso? Ya no aparecerá en la página de recursos.'))) return;
    try {
        const response = await fetch(`?url=admin/delete-recurso&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Recurso eliminado');
            loadRecursos(__recursosPage);
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
    }
}

// ─── EDITOR DE CONTENIDO: "QUÉ HACER AHORA" Y "ACERCA DE NDA" (Admin General) ───
async function loadContentForm(pagina) {
    const form = document.getElementById(pagina + 'ContentForm');
    if (!form) return;
    try {
        const response = await fetch(`?url=admin/get-${pagina}-content`);
        const result = await response.json();
        if (result.error) {
            ndaAlert('Error: ' + result.error);
            return;
        }
        (result.data || []).forEach(f => {
            const el = form.querySelector(`[data-campo="${CSS.escape(f.campo)}"]`);
            if (el) el.value = f.valor;
        });
    } catch (e) {
        ndaAlert('Error al cargar el contenido');
        console.error(e);
    }
}

async function saveContentForm(pagina) {
    const form = document.getElementById(pagina + 'ContentForm');
    if (!form) return;
    const valores = {};
    form.querySelectorAll('[data-campo]').forEach(el => {
        valores[el.dataset.campo] = el.value;
    });

    try {
        const response = await fetch(`?url=admin/save-${pagina}-content`, {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ valores })
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Contenido guardado correctamente');
        } else {
            ndaAlert('❌ Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('❌ Error de conexión');
        console.error(e);
    }
}

// ─── MI ASISTENCIA (Estudiante) ───
async function loadMyAttendance() {
    const tbody = document.getElementById('myAttendanceTableBody');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="3" class="text-center">Cargando...</td></tr>';

    try {
        const response = await fetch('?url=school/my-attendance');
        const records = await response.json();

        if (records.error) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center">Error: ${records.error}</td></tr>`;
            return;
        }
        if (!Array.isArray(records) || records.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">Todavía no tienes asistencia registrada</td></tr>';
            return;
        }

        tbody.innerHTML = records.map(r => `
            <tr>
                <td>${r.nombre}</td>
                <td>${r.fecha}</td>
                <td><span class="school-attendance-status ${r.status || 'pendiente'}">${r.status || 'Pendiente'}</span></td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-center">Error al cargar tu asistencia</td></tr>';
        console.error(e);
    }
}

// ─── INIT ───
// El panel inicial visible es siempre "dashboard"; cada rol solo incluye los
// demás tabs que le corresponden, así que solo se precargan sus formularios
// si de verdad existen en el DOM (evita peticiones innecesarias en los
// paneles de solo lectura como Estudiante/Padre).
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('studentClassroom')) loadClassroomSelect();
    if (document.getElementById('studentsTableBody')) loadStudents();
    if (document.getElementById('institutionsTableBody')) loadInstitutions();
    if (document.getElementById('myClassroomInfo')) loadMyClassroom();
});

// ─── MI AULA (Estudiante) ───
async function loadMyClassroom() {
    const el = document.getElementById('myClassroomInfo');
    if (!el) return;
    try {
        const response = await fetch('?url=school/my-classroom');
        const c = await response.json();
        if (!c || !c.classroom) {
            el.innerHTML = 'Todavía no te han asignado un aula. Pídele a tu docente o al director que te asigne una.';
            el.classList.add('text-center');
            return;
        }
        el.classList.remove('text-center');
        el.innerHTML = `
            <div class="school-grid-2">
                <div><strong>Aula:</strong> ${c.classroom} (${c.grado || ''} ${c.seccion || ''})</div>
                <div><strong>Docente:</strong> ${c.teacher || 'Sin asignar'}</div>
                <div><strong>Compañeros:</strong> ${c.total_alumnos || 0} alumnos</div>
            </div>
        `;
    } catch (e) {
        el.innerHTML = 'Error al cargar tu aula';
    }
}