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

// Filtro por categoria de tarjetas (mismo patron que .blog-filters/.bfilter
// de views/blog.php): filtra que tarjetas se muestran, no restringe quien
// puede verlas. barId = contenedor de los botones .sfilter[data-cat]; las
// tarjetas a filtrar son las siguientes hermanas con [data-cat].
function initCardFilterBar(barId) {
    const bar = document.getElementById(barId);
    if (!bar) return;
    bar.addEventListener('click', function (e) {
        const btn = e.target.closest('.sfilter');
        if (!btn) return;
        bar.querySelectorAll('.sfilter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cat = btn.dataset.cat;
        const grid = bar.nextElementSibling;
        if (!grid) return;
        grid.querySelectorAll('[data-cat]').forEach(card => {
            card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
        });
    });
}

function debounce(fn, wait) {
    let t;
    return function (...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), wait);
    };
}

// ─── BARRA INFERIOR DEL PANEL: Tablero/Aulas tienen subopciones que
// aparecen en un abanico de círculos flotando arriba de su botón. Se
// abren solo al pasar el mouse justo sobre el círculo del botón (no
// sobre toda el área del ítem, que es más ancha por el espacio que
// dejan los círculos del abanico) y se mantienen abiertas mientras el
// mouse siga sobre el botón o ya dentro del abanico — con un pequeño
// margen antes de cerrar (en JS, no solo con :hover de CSS, para que
// no se cierre a medio camino al mover el mouse del botón hacia los
// círculos de arriba). También con click/tap (para pantallas
// táctiles, donde no existe hover) ───
let bnavCloseTimer = null;
document.querySelectorAll('.school-bnav-item').forEach(item => {
    const popover = item.querySelector('.school-bnav-popover');
    const btn = item.querySelector(':scope > .school-bnav-btn');
    if (!popover || !btn) return;

    const openBnavItem = () => {
        clearTimeout(bnavCloseTimer);
        document.querySelectorAll('.school-bnav-item.open').forEach(el => {
            if (el !== item) el.classList.remove('open');
        });
        item.classList.add('open');
    };
    const closeBnavItem = () => {
        clearTimeout(bnavCloseTimer);
        bnavCloseTimer = setTimeout(() => item.classList.remove('open'), 250);
    };

    btn.addEventListener('mouseenter', openBnavItem);
    btn.addEventListener('mouseleave', closeBnavItem);
    popover.addEventListener('mouseenter', openBnavItem);
    popover.addEventListener('mouseleave', closeBnavItem);
});

document.addEventListener('click', function (e) {
    const item = e.target.closest('.school-bnav-item');
    const clickedBtn = e.target.closest('.school-bnav-item > .school-bnav-btn');
    const clickedSub = e.target.closest('.school-bnav-sub');

    document.querySelectorAll('.school-bnav-item.open').forEach(el => {
        if (el !== item) el.classList.remove('open');
    });

    if (clickedSub) {
        item?.classList.remove('open');
    } else if (clickedBtn && item.querySelector('.school-bnav-popover')) {
        item.classList.toggle('open');
    }
});

// ─── SALUDO SEGÚN LA HORA (usa la hora local del navegador) ───
// También marca el bloque de saludo con la franja horaria (mañana/
// tarde/noche) en un data-attribute, para darle a la mascota del
// chatbot un halo de color distinto según la hora (no hay una imagen
// distinta por franja, pero el tono cambia la sensación).
(function () {
    const el = document.getElementById('schoolGreetingWord');
    const greeting = document.getElementById('schoolGreeting');
    if (!el) return;
    const h = new Date().getHours();
    const period = (h >= 5 && h < 12) ? 'morning' : (h >= 12 && h < 19) ? 'afternoon' : 'night';
    el.textContent = period === 'morning' ? 'Buenos días' : period === 'afternoon' ? 'Buenas tardes' : 'Buenas noches';
    if (greeting) greeting.dataset.period = period;
})();

// ─── TABS ───
function showSchoolTab(tabId) {
    // Guarda la pestaña activa en el hash de la URL (sin agregar
    // entradas al historial) para que un F5 / recarga vuelva al mismo
    // apartado en vez de siempre al Tablero.
    try { history.replaceState(null, '', '#' + tabId); } catch (e) { /* noop */ }

    document.querySelectorAll('.school-panel').forEach(p => p.classList.remove('active'));
    const panel = document.getElementById('tab-' + tabId);
    if (panel) panel.classList.add('active');

    // .school-tab: sidebar de texto de panel-docente / Admin General.
    // .school-bnav-btn / .school-bnav-sub: barra de abajo de panel-director.
    document.querySelectorAll('.school-tab, .school-bnav-btn, .school-bnav-sub').forEach(t => t.classList.remove('active'));
    const activeBtn = document.querySelector(`.school-tab[data-tab="${tabId}"], .school-bnav-btn[data-tab="${tabId}"], .school-bnav-sub[data-tab="${tabId}"]`);
    activeBtn?.classList.add('active');

    // Barra inferior: si la pestaña activa es una subopción dentro del
    // popover (ej. "Docentes" dentro de Usuarios), el botón del grupo
    // también se marca activo para que se note cuál sección es, y el
    // popover se cierra (ya se navegó a donde el usuario quería).
    document.querySelectorAll('.school-bnav-item').forEach(item => {
        const btn = item.querySelector(':scope > .school-bnav-btn');
        if (!btn) return;
        if (item.querySelector('.school-bnav-sub.active')) {
            btn.classList.add('active');
            item.classList.remove('open');
        }
    });

    // Cargar datos según la pestaña
    const loaders = {
        'students': loadStudents,
        'teachers': loadTeachers,
        'classrooms': loadClassroomSections,
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

// Al cargar/recargar la página, si la URL ya trae un hash (dejado por
// showSchoolTab en una visita anterior) y existe esa pestaña en este
// panel, se abre esa en vez de quedarse en el Tablero por defecto.
// Si el hash trae además el filtro de sección (dejado por
// filterStudentsBySection), se restaura también esa sección en vez de
// caer en el listado general de Estudiantes.
(function () {
    const rawHash = (location.hash || '').replace('#', '');
    if (!rawHash) return;
    const [tabId, queryStr] = rawHash.split('?');
    if (!tabId || !document.getElementById('tab-' + tabId)) return;
    if (tabId === 'students' && queryStr) {
        const params = new URLSearchParams(queryStr);
        const aulaId = params.get('aula');
        const nombre = params.get('nombre');
        if (aulaId && nombre) {
            filterStudentsBySection(aulaId, nombre, params.get('origin') || 'classrooms');
            return;
        }
    }
    showSchoolTab(tabId);
})();

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
    // loadStudents() es la lista SIN filtrar por sección — si había un
    // filtro activo (venías de una tarjeta de Sección), se limpia aquí.
    __studentsActiveAula = null;
    const badge = document.getElementById('studentsFilterBadge');
    if (badge) badge.style.display = 'none';
    __studentsPage = page || 1;
    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Cargando estudiantes...</td></tr>';

    const q = document.getElementById('studentsSearch')?.value.trim() || '';

    try {
        const response = await fetch(`?url=school/students&q=${encodeURIComponent(q)}&page=${__studentsPage}&per_page=10`);
        const result = await response.json();

        if (result.error) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center">Error: ${result.error}</td></tr>`;
            return;
        }
        __studentsCache = result.data || [];

        if (__studentsCache.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay estudiantes registrados</td></tr>';
            renderPagination('studentsPagination', 1, 1, 'loadStudents');
            return;
        }

        tbody.innerHTML = __studentsCache.map(s => `
            <tr>
                <td>${s.numero_lista ?? '—'}</td>
                <td><code>${escapeHtml(s.codigo || '—')}</code></td>
                <td>${escapeHtml(s.nombre)} ${escapeHtml(s.apellido || '')}</td>
                <td>${escapeHtml(s.classroom || 'Sin aula')}</td>
                <td>${escapeHtml(s.teacher || 'Sin asignar')}</td>
                <td><span style="color:var(--teal);">Activo</span></td>
                <td>
                    ${window.__ndaIsSchoolStaff ? `<button class="school-attendance-btn" onclick="editStudent(${s.estudiantes_id})">Editar</button>` : ''}
                    ${window.__ndaIsSchoolAdmin ? `<button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteStudent(${s.estudiantes_id})">Eliminar</button>` : ''}
                </td>
            </tr>
        `).join('');

        renderPagination('studentsPagination', result.page, result.total_pages, 'loadStudents');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">Error al cargar estudiantes</td></tr>';
        console.error(e);
    }
}

// Si hay una sección activa (viniste de una tarjeta de Sección), la
// búsqueda y los refrescos tras agregar/editar/eliminar se quedan
// dentro de esa sección en vez de saltar a la lista completa.
let __studentsActiveAula = null;
// Para refrescos tras agregar/editar/eliminar: se queda en la misma
// página/sección donde estabas.
function reloadStudents() {
    if (__studentsActiveAula) {
        loadFilteredStudents(__studentsActiveAula.id, __studentsActiveAula.nombre);
    } else {
        loadStudents(__studentsPage || 1);
    }
}
// Para una búsqueda nueva: si hay sección activa, se queda ahí; si
// no, vuelve a la página 1 (una búsqueda nueva no debe quedarse en
// medio de una paginación vieja).
const debounceStudentsSearch = debounce(() => {
    if (__studentsActiveAula) {
        loadFilteredStudents(__studentsActiveAula.id, __studentsActiveAula.nombre);
    } else {
        loadStudents(1);
    }
}, 350);

document.getElementById('addStudentForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('studentName').value,
        apellido: document.getElementById('studentLastName').value,
        email: document.getElementById('studentEmail').value,
        telefono: document.getElementById('studentPhone').value,
        aula_id: document.getElementById('studentClassroom').value || null,
        numero_lista: document.getElementById('studentListNumber').value || null
    };

    try {
        const response = await fetch('?url=school/add-student', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Estudiante agregado correctamente. Contraseña temporal: ' + result.password_temporal);
            closeModal('addStudentModal');
            this.reset();
            reloadStudents();
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
    if (!s) { ndaAlert('No se encontró el estudiante.'); return; }

    document.getElementById('editStudentId').value = s.estudiantes_id;
    document.getElementById('editStudentName').value = s.nombre || '';
    document.getElementById('editStudentLastName').value = s.apellido || '';
    document.getElementById('editStudentPhone').value = s.telefono_emergencia || '';
    document.getElementById('editStudentListNumber').value = s.numero_lista || '';

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
        numero_lista: document.getElementById('editStudentListNumber').value || null,
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
            reloadStudents();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteStudent(id) {
    if (!(await ndaConfirm('¿Eliminar este estudiante?'))) return;
    try {
        const response = await fetch(`?url=school/delete-student&id=${id}`);
        const result = await response.json();
        if (result.success) {
            ndaAlert('✅ Estudiante eliminado');
            reloadStudents();
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
                <td><strong>${escapeHtml(t.nombre)}</strong></td>
                <td>${escapeHtml(t.email)}</td>
                <td>${escapeHtml(t.materia || '—')}</td>
                <td>${escapeHtml(t.aulas || 'Sin asignar')}</td>
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
                <td><strong>${escapeHtml(p.nombre)}</strong></td>
                <td>${escapeHtml(p.email)}</td>
                <td>${escapeHtml(p.hijos || 'Ninguno vinculado')}</td>
                <td>
                    <button class="school-attendance-btn" onclick="openLinkChildModal(${p.usuarios_id})">Vincular hijo</button>
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
                `${escapeHtml(l.nombre)} ${escapeHtml(l.apellido)} (${escapeHtml(l.parentesco)}) <button class="school-attendance-btn" onclick="unlinkChild(${l.padres_estudiantes_id}, ${parentId})">Quitar</button>`
            ).join(' · ');
        } else {
            currentList.innerHTML = 'Todavía no tiene hijos vinculados.';
        }
    } catch (e) { currentList.innerHTML = ''; }

    const select = document.getElementById('linkChildStudent');
    select.innerHTML = '<option value="">Cargando estudiantes...</option>';
    try {
        const res = await fetch('?url=school/students&per_page=200');
        const result = await res.json();
        const students = result.data || [];
        select.innerHTML = students.map(s => `<option value="${s.estudiantes_id}">${escapeHtml(s.nombre)} ${escapeHtml(s.apellido)} (${escapeHtml(s.codigo || '')})</option>`).join('');
    } catch (e) { select.innerHTML = '<option value="">Error al cargar estudiantes</option>'; }

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
                <td><code>${escapeHtml(c.codigo || '—')}</code></td>
                <td>${escapeHtml(c.nombre)} ${escapeHtml(c.apellido || '')}</td>
                <td>${escapeHtml(c.classroom || 'Sin aula')}</td>
                <td>${escapeHtml(c.teacher || 'Sin asignar')}</td>
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
                <td>${escapeHtml(r.nombre)} ${escapeHtml(r.apellido || '')}</td>
                <td>${escapeHtml(r.simulacro || 'Sin simulacros registrados')}</td>
                <td>${r.status ? `<span class="school-attendance-status ${escapeHtml(r.status)}">${escapeHtml(r.status)}</span>` : '—'}</td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-center">Error al cargar el estado</td></tr>';
        console.error(e);
    }
}

document.getElementById('notifyChildrenForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        mensaje: document.getElementById('notifyChildrenMessage').value,
        severidad: document.getElementById('notifyChildrenSeveridad').value,
    };
    try {
        const response = await fetch('?url=school/send-to-my-children', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert(`✅ Notificación enviada a ${result.enviados} hijo(s)`);
            this.reset();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

// ─── NOTIFICAR A MIS ALUMNOS (Docente) ───
document.getElementById('notifyStudentsForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        mensaje: document.getElementById('notifyStudentsMessage').value,
        severidad: document.getElementById('notifyStudentsSeveridad').value,
    };
    try {
        const response = await fetch('?url=school/send-to-my-students', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            ndaAlert(`✅ Notificación enviada a ${result.enviados} estudiante(s)`);
            this.reset();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

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
                <td><strong>${escapeHtml(s.nombre)}</strong></td>
                <td>${escapeHtml(s.email)}</td>
                <td>${escapeHtml(s.telefono || '—')}</td>
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
                <td>${escapeHtml(n.mensaje)}</td>
                <td><span class="chip b">${escapeHtml(severityLabelMap[n.severidad] || n.severidad)}</span></td>
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
                <td><strong>${escapeHtml(c.nombre)}</strong></td>
                <td>${escapeHtml(c.grado || '—')}</td>
                <td>${escapeHtml(c.nivel || '—')}</td>
                <td>${escapeHtml(c.seccion || '—')}</td>
                <td>${escapeHtml(c.teacher || 'Sin asignar')}</td>
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
let __routesMap = null;
let __routesMapMarkers = [];

// CARTO (basemaps.cartocdn.com) ahora exige API key hasta para su tier
// gratuito -- los tiles salian con el watermark "API KEY REQUIRED". Esri
// World Imagery (satelital) es gratis, sin key, y se ve mejor que un mapa
// de calles plano en zonas poco mapeadas en OpenStreetMap.
function ndaTileLayerUrl() {
    return 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
}

const ROUTE_STATE_COLOR = { despejada: '#2a9d5c', bloqueada: '#e08a1e', peligro: '#e63946' };

function initRoutesMap() {
    const el = document.getElementById('routesMap');
    if (!el || typeof L === 'undefined') return null;
    if (__routesMap) return __routesMap;
    __routesMap = L.map('routesMap', { center: [13.7942, -88.8965], zoom: 8 });
    L.tileLayer(ndaTileLayerUrl(), { attribution: '© Esri', maxZoom: 19 }).addTo(__routesMap);
    return __routesMap;
}

async function renderRoutesMap(routes) {
    const map = initRoutesMap();
    if (!map) return;
    __routesMapMarkers.forEach(m => map.removeLayer(m));
    __routesMapMarkers = [];

    const withCoords = routes.filter(r => r.lat !== null && r.lat !== '' && r.lng !== null && r.lng !== '' && r.lat !== undefined && r.lng !== undefined);
    withCoords.forEach(r => {
        const color = ROUTE_STATE_COLOR[r.estado] || ROUTE_STATE_COLOR.despejada;
        const marker = L.circleMarker([parseFloat(r.lat), parseFloat(r.lng)], {
            radius: 9, color, fillColor: color, fillOpacity: 0.85, weight: 2
        }).addTo(map);
        marker.bindPopup(`<strong>${escapeHtml(r.nombre)}</strong><br>${escapeHtml(r.descripcion || '')}<br><em>${escapeHtml(r.estado || 'despejada')}</em>`);
        __routesMapMarkers.push(marker);
    });

    // Puntos del croquis (Punto de encuentro, Zona segura, Extintor, etc.)
    // de la institución, igual que ya se ven en el mapa de Inicio — para
    // tener contexto de seguridad junto a las rutas, no solo las rutas.
    let institutionLatLng = null;
    try {
        const res = await fetch('?url=school/croquis');
        const data = await res.json();
        if (data.lat !== null && data.lat !== undefined && data.lat !== '') {
            const latN = parseFloat(data.lat), lngN = parseFloat(data.lng);
            institutionLatLng = [latN, lngN];
            (data.puntos || []).forEach(p => {
                const px = parseFloat(p.pos_x), py = parseFloat(p.pos_y);
                if (isNaN(px) || isNaN(py)) return;
                const dLat = (((50 - py) / 50) * 60) / 111320;
                const dLng = (((px - 50) / 50) * 60) / (111320 * Math.cos(latN * Math.PI / 180));
                const color = CROQUIS_COLORS[p.tipo] || CROQUIS_COLORS.otro;
                const marker = L.circleMarker([latN + dLat, lngN + dLng], { radius: 8, color: '#fff', fillColor: color, fillOpacity: 0.95, weight: 2 })
                    .addTo(map)
                    .bindPopup(`<strong>${escapeHtml(p.nombre)}</strong><br>${escapeHtml(CROQUIS_LABELS[p.tipo] || p.tipo)}`);
                __routesMapMarkers.push(marker);
            });
        }
    } catch (e) { /* sin puntos si falla */ }

    if (__routesMapMarkers.length > 0) {
        map.fitBounds(L.featureGroup(__routesMapMarkers).getBounds().pad(0.3));
    } else if (institutionLatLng) {
        // Sin rutas ni puntos todavia: centra en la institución en vez de
        // quedarse en la vista generica de todo El Salvador (zoom 8) con
        // la que arranca initRoutesMap().
        map.setView(institutionLatLng, 16);
    }
    setTimeout(() => map.invalidateSize(), 50);
}

// Mapa embebido en los modales de agregar/editar ruta: clic para colocar el
// pin. centerLat/centerLng: solo para centrar la vista al abrir (ej. la
// ubicación de la institución), sin poner marcador -- initialLat/initialLng
// SI ponen marcador (ruta que ya tiene coordenadas guardadas, al editar).
function setupRoutePickerMap(mapId, latInputId, lngInputId, initialLat, initialLng, centerLat, centerLng) {
    const el = document.getElementById(mapId);
    if (!el || typeof L === 'undefined') return null;
    if (el._ndaLeafletMap) {
        el._ndaLeafletMap.remove();
        el._ndaLeafletMap = null;
    }
    const hasInitial = initialLat !== null && initialLat !== undefined && !isNaN(initialLat);
    const hasCenter = centerLat !== null && centerLat !== undefined && !isNaN(centerLat);
    const startLat = hasInitial ? initialLat : (hasCenter ? centerLat : 13.7942);
    const startLng = hasInitial ? initialLng : (hasCenter ? centerLng : -88.8965);
    const map = L.map(mapId, { center: [startLat, startLng], zoom: (hasInitial || hasCenter) ? 16 : 8 });
    L.tileLayer(ndaTileLayerUrl(), { attribution: '© Esri', maxZoom: 19 }).addTo(map);

    let marker = hasInitial ? L.marker([startLat, startLng]).addTo(map) : null;
    map.on('click', function (e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById(latInputId).value = e.latlng.lat.toFixed(7);
        document.getElementById(lngInputId).value = e.latlng.lng.toFixed(7);
    });

    el._ndaLeafletMap = map;
    setTimeout(() => map.invalidateSize(), 80);
    return map;
}

function useMyLocationForRoute(which) {
    if (!navigator.geolocation) { ndaAlert('Tu navegador no soporta geolocalización.'); return; }
    const latId = which === 'add' ? 'routeLat' : 'editRouteLat';
    const lngId = which === 'add' ? 'routeLng' : 'editRouteLng';
    const mapId = which === 'add' ? 'addRouteMap' : 'editRouteMap';
    navigator.geolocation.getCurrentPosition(function (pos) {
        const lat = pos.coords.latitude, lng = pos.coords.longitude;
        document.getElementById(latId).value = lat.toFixed(7);
        document.getElementById(lngId).value = lng.toFixed(7);
        const el = document.getElementById(mapId);
        if (el && el._ndaLeafletMap) {
            el._ndaLeafletMap.setView([lat, lng], 16);
            L.marker([lat, lng]).addTo(el._ndaLeafletMap);
        }
    }, function () {
        ndaAlert('No pudimos obtener tu ubicación. Revisa los permisos del navegador.');
    });
}

function openAddRouteModal() {
    openModal('addRouteModal');
    setTimeout(async () => {
        let centerLat = null, centerLng = null;
        try {
            const res = await fetch('?url=school/croquis');
            const data = await res.json();
            if (data.lat !== null && data.lat !== undefined && data.lat !== '') {
                centerLat = parseFloat(data.lat);
                centerLng = parseFloat(data.lng);
            }
        } catch (e) { /* si falla, el mapa arranca en el centro generico */ }
        setupRoutePickerMap('addRouteMap', 'routeLat', 'routeLng', null, null, centerLat, centerLng);
    }, 50);
}

// ─── INICIO (Pagina Principal): mapa Leaflet con institucion + rutas + puntos de croquis ───
let __inicioMap = null;
const INICIO_MAP_RADIUS_M = 60;

// Mapa interactivo de Inicio: institucion + rutas + puntos de croquis. Si
// eres staff, hacer clic en el mapa agrega un punto de croquis ahi mismo
// (mismo modal y mismo endpoint que el clic sobre la imagen del croquis en
// tabCroquis.php — es la misma funcionalidad, solo con otra entrada).
async function initInicioMap() {
    const el = document.getElementById('inicioMap');
    if (!el || typeof L === 'undefined') return;

    // Se re-consulta en vez de usar solo los datos embebidos al cargar la
    // pagina, para que un punto agregado (desde el mapa o desde la imagen
    // del croquis) aparezca sin recargar toda la pagina.
    let lat = window.__ndaInstitutionLat, lng = window.__ndaInstitutionLng, puntos = window.__ndaInicioCroquisPoints || [];
    try {
        const response = await fetch('?url=school/croquis');
        const data = await response.json();
        if (data.lat !== null && data.lat !== undefined) lat = data.lat;
        if (data.lng !== null && data.lng !== undefined) lng = data.lng;
        puntos = data.puntos || puntos;
    } catch (e) { /* si falla, se usan los datos ya embebidos por PHP */ }

    const hasLoc = lat !== null && lat !== undefined && lat !== '';
    const latN = hasLoc ? parseFloat(lat) : 13.7942;
    const lngN = hasLoc ? parseFloat(lng) : -88.8965;

    if (__inicioMap) {
        __inicioMap.remove();
        __inicioMap = null;
    }

    const map = L.map('inicioMap', { center: [latN, lngN], zoom: hasLoc ? 16 : 8 });
    L.tileLayer(ndaTileLayerUrl(), { attribution: '© Esri', maxZoom: 19 }).addTo(map);
    __inicioMap = map;

    const markers = [];
    if (hasLoc) {
        markers.push(L.marker([latN, lngN]).addTo(map).bindPopup('<strong>' + escapeHtml(window.__ndaInstitutionName || 'Tu institución') + '</strong>'));
    }

    (window.__ndaInicioRoutes || []).forEach(r => {
        if (r.lat === null || r.lat === undefined || r.lat === '' || r.lng === null || r.lng === undefined || r.lng === '') return;
        const color = ROUTE_STATE_COLOR[r.estado] || ROUTE_STATE_COLOR.despejada;
        markers.push(
            L.circleMarker([parseFloat(r.lat), parseFloat(r.lng)], { radius: 8, color, fillColor: color, fillOpacity: 0.85, weight: 2 })
                .addTo(map)
                .bindPopup(`<strong>${escapeHtml(r.nombre)}</strong><br>${escapeHtml(r.descripcion || '')}<br><em>${escapeHtml(r.estado || 'despejada')}</em>`)
        );
    });

    // Puntos del croquis proyectados alrededor del centro (misma aproximacion
    // de offset fijo que renderCroquisMapMarkers() usa en la vista MapLibre
    // del croquis — no es geo-referenciacion de precision).
    if (hasLoc) {
        puntos.forEach(p => {
            const px = parseFloat(p.pos_x), py = parseFloat(p.pos_y);
            if (isNaN(px) || isNaN(py)) return;
            const dLat = (((50 - py) / 50) * INICIO_MAP_RADIUS_M) / 111320;
            const dLng = (((px - 50) / 50) * INICIO_MAP_RADIUS_M) / (111320 * Math.cos(latN * Math.PI / 180));
            const color = CROQUIS_COLORS[p.tipo] || CROQUIS_COLORS.otro;
            markers.push(
                L.circleMarker([latN + dLat, lngN + dLng], { radius: 8, color: '#fff', fillColor: color, fillOpacity: 0.95, weight: 2 })
                    .addTo(map)
                    .bindPopup(`<strong>${escapeHtml(p.nombre)}</strong><br>${escapeHtml(CROQUIS_LABELS[p.tipo] || p.tipo)}`)
            );
        });

        // Clic en el mapa = agregar un punto de croquis ahi (solo el
        // director/admin edita los puntos, no docentes).
        if (window.__ndaIsSchoolAdmin) {
            map.on('click', function (e) {
                const offsetYm = (e.latlng.lat - latN) * 111320;
                const offsetXm = (e.latlng.lng - lngN) * 111320 * Math.cos(latN * Math.PI / 180);
                const px = Math.min(100, Math.max(0, 50 + (offsetXm / INICIO_MAP_RADIUS_M) * 50));
                const py = Math.min(100, Math.max(0, 50 - (offsetYm / INICIO_MAP_RADIUS_M) * 50));
                document.getElementById('croquisPointX').value = px.toFixed(2);
                document.getElementById('croquisPointY').value = py.toFixed(2);
                openModal('addCroquisPointModal');
            });
        }
    }

    if (markers.length > 1) {
        map.fitBounds(L.featureGroup(markers).getBounds().pad(0.3));
    }
    setTimeout(() => map.invalidateSize(), 50);
}

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
        renderRoutesMap(__routesCache);

        if (routes.length === 0) {
            container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">No hay rutas registradas</div>';
            return;
        }

        container.innerHTML = routes.map(r => `
            <div class="school-route-card">
                <div class="school-route-header">
                    <h4>${escapeHtml(r.nombre)}</h4>
                    <span class="school-route-status ${escapeHtml(r.estado || 'despejada')}">${escapeHtml(r.estado || 'Despejada')}</span>
                </div>
                <p style="font-size:0.82rem;color:var(--text2);">${escapeHtml(r.descripcion || 'Sin descripción')}</p>
                <div style="margin-top:8px;display:flex;gap:6px;">
                    ${window.__ndaIsSchoolAdmin ? `<button class="school-attendance-btn" onclick="editRoute(${r.rutas_evacuacion_id})"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></button>` : ''}
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
        estado: document.getElementById('routeStatus').value,
        lat: document.getElementById('routeLat').value,
        lng: document.getElementById('routeLng').value
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
    document.getElementById('editRouteLat').value = r.lat || '';
    document.getElementById('editRouteLng').value = r.lng || '';
    openModal('editRouteModal');
    const lat = r.lat ? parseFloat(r.lat) : null;
    const lng = r.lng ? parseFloat(r.lng) : null;
    setTimeout(async () => {
        let centerLat = null, centerLng = null;
        if (lat === null) {
            // Esta ruta no tiene coordenadas propias todavia: centra el
            // mapa en la institución en vez del centro genérico lejano
            // (mismo arreglo que openAddRouteModal()).
            try {
                const res = await fetch('?url=school/croquis');
                const data = await res.json();
                if (data.lat !== null && data.lat !== undefined && data.lat !== '') {
                    centerLat = parseFloat(data.lat);
                    centerLng = parseFloat(data.lng);
                }
            } catch (e) { /* si falla, el mapa arranca en el centro generico */ }
        }
        setupRoutePickerMap('editRouteMap', 'editRouteLat', 'editRouteLng', lat, lng, centerLat, centerLng);
    }, 50);
}

document.getElementById('editRouteForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const data = {
        id: document.getElementById('editRouteId').value,
        nombre: document.getElementById('editRouteName').value,
        descripcion: document.getElementById('editRouteDescription').value,
        estado: document.getElementById('editRouteStatus').value,
        lat: document.getElementById('editRouteLat').value,
        lng: document.getElementById('editRouteLng').value,
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
                drills.map(d => `<option value="${d.simulacros_id}">${escapeHtml(d.nombre)} (${escapeHtml(d.fecha)})</option>`).join('');
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
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay estudiantes para este simulacro</td></tr>';
            return;
        }

        attendanceStudents = students;
        currentDrillId = drillId;

        tbody.innerHTML = students.map((s, i) => `
            <tr>
                <td>${escapeHtml(s.nombre)} ${escapeHtml(s.apellido || '')}</td>
                <td>${escapeHtml(s.aula || '—')}</td>
                <td>
                    <span class="school-attendance-status ${escapeHtml(s.status || 'pendiente')}" id="att-status-${i}">
                        ${escapeHtml(s.status || 'Pendiente')}
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

// Prioridad -> variante de .chip (mismo sistema de chips que el resto del sitio)
const prioridadChip = { alta: 'r', media: 'o', baja: 'g' };

async function loadIncidents() {
    const container = document.getElementById('incidentList');
    if (!container) return;

    container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando incidentes...</div>';

    try {
        const response = await fetch('?url=school/incidents');
        const incidents = await response.json();

        if (incidents.error) {
            container.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error: ${incidents.error}</div>`;
            return;
        }
        __incidentsCache = Array.isArray(incidents) ? incidents : [];

        if (incidents.length === 0) {
            container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">No hay incidentes reportados</div>';
            return;
        }

        container.innerHTML = incidents.map(inc => `
            <div class="school-blog-card" data-cat="${escapeHtml(inc.tipo)}" onclick="location.href='?url=school/incident-detail&id=${inc.incidentes_id}'">
                ${inc.imagen
                    ? `<img class="school-blog-card-thumb" src="${escapeHtml(inc.imagen)}" alt="${escapeHtml(inc.tipo)}">`
                    : `<div class="school-blog-card-thumb placeholder">Sin imagen</div>`}
                <div class="school-blog-card-body">
                    <h4>${escapeHtml(inc.tipo)}
                        <span class="chip ${prioridadChip[inc.prioridad] || 'o'}">${escapeHtml(inc.prioridad || 'media')}</span>
                        ${inc.estado === 'resuelto' ? '<span class="chip t">Resuelto</span>' : ''}
                    </h4>
                    ${inc.ubicacion ? `<div class="school-incident-location">${escapeHtml(inc.ubicacion)}</div>` : ''}
                    <p class="school-blog-card-excerpt">${escapeHtml(inc.descripcion).slice(0, 140)}</p>
                    <div class="school-blog-card-meta">
                        <span>${inc.reporter ? escapeHtml(inc.reporter) : 'Comunidad'}</span>
                        <span>${new Date(inc.created_at).toLocaleDateString('es-SV')}</span>
                    </div>
                </div>
                <div class="school-blog-card-actions" onclick="event.stopPropagation()">
                    ${(window.__ndaIsSchoolStaff || String(inc.usuario_id) === String(window.__ndaMyUserId)) ? `<button class="school-attendance-btn" onclick="editIncident(${inc.incidentes_id})">Editar</button>` : ''}
                    ${window.__ndaIsSchoolStaff && inc.estado !== 'resuelto' ? `<button class="school-attendance-btn" onclick="resolveIncident(${inc.incidentes_id})">Resolver</button>` : ''}
                    ${(window.__ndaIsSchoolAdmin || String(inc.usuario_id) === String(window.__ndaMyUserId)) ? `<button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteIncident(${inc.incidentes_id})">Eliminar</button>` : ''}
                </div>
            </div>
        `).join('');
    } catch (e) {
        container.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error al cargar incidentes</div>';
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
                <td><strong>${escapeHtml(d.nombre)}</strong></td>
                <td>${escapeHtml(d.fecha)}</td>
                <td>${escapeHtml(d.hora)}</td>
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
                    <h4>Estadísticas de Asistencia</h4>
                    <div class="school-report-stat"><span>Total registros</span><span class="value">${att.total || 0}</span></div>
                    <div class="school-report-stat"><span>Presentes</span><span class="value" style="color:var(--teal);">${att.presentes || 0}</span></div>
                    <div class="school-report-stat"><span>Ausentes</span><span class="value" style="color:var(--acc2);">${att.ausentes || 0}</span></div>
                    <div class="school-report-stat"><span>Heridos</span><span class="value" style="color:var(--acc3);">${att.heridos || 0}</span></div>
                </div>

                <div class="school-report-card">
                    <h4>Incidentes por Tipo</h4>
                    ${incidentsByType.length === 0 ? '<p style="color:var(--text3);">No hay incidentes registrados</p>' :
                        incidentsByType.map(i => `
                            <div class="school-report-stat"><span>${escapeHtml(i.tipo)}</span><span class="value">${i.total}</span></div>
                        `).join('')
                    }
                </div>

                <div class="school-report-card">
                    <h4>Simulacros por Estado</h4>
                    ${drillsByStatus.length === 0 ? '<p style="color:var(--text3);">No hay simulacros registrados</p>' :
                        drillsByStatus.map(d => `
                            <div class="school-report-stat"><span>${drillStatusLabel[d.estado] || d.estado}</span><span class="value">${d.total}</span></div>
                        `).join('')
                    }
                </div>

                <div class="school-report-card" style="grid-column:1/-1;">
                    <h4>Estudiantes por Aula</h4>
                    ${studentsByClassroom.length === 0 ? '<p style="color:var(--text3);">No hay datos de estudiantes por aula</p>' :
                        `<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:8px;">
                            ${studentsByClassroom.map(c => `
                                <div style="background:var(--bg3);padding:10px;border-radius:8px;text-align:center;border:1px solid var(--border);">
                                    <div style="font-weight:700;color:var(--text);">${escapeHtml(c.nombre)}</div>
                                    <div style="color:var(--acc);font-size:1.2rem;font-weight:800;">${c.total}</div>
                                    <div style="font-size:0.65rem;color:var(--text3);">estudiantes</div>
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

    rows.push(['Estudiantes por aula']);
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
                    classrooms.map(c => `<option value="${c.aulas_id}">${escapeHtml(c.nombre)}</option>`).join('');
            }
        } catch (e) {
            console.error('Error loading classrooms:', e);
        }
    }
}

// ─── Helper compartido por Aulas (director) y Secciones (docente):
// arma el HTML del grid de tarjetas (A-F) de un año/grado ───
function renderSectionCardsHtml(items, teachers, isAdmin, originTab) {
    return `
        <div class="section-cards">
            ${items.map((s, idx) => `
                <div class="section-card">
                    <div class="cc-banner cc-color-${idx % 6}"></div>
                    <span class="cc-letter-badge">${escapeHtml(s.seccion)}</span>
                    <div class="cc-body">
                        <div class="cc-meta">${s.total_alumnos || 0} ${s.total_alumnos === 1 ? 'estudiante' : 'estudiantes'}</div>
                        <div class="cc-title" data-aula-id="${s.aulas_id}" data-aula-nombre="${escapeHtml(s.nombre)}" onclick="filterStudentsBySection(this.dataset.aulaId, this.dataset.aulaNombre, '${originTab || 'classrooms'}')">Sección ${escapeHtml(s.seccion)}</div>
                        <div class="cc-bottom">
                            <span class="cc-avatar">${escapeHtml((s.teacher || 'S').trim().charAt(0).toUpperCase())}</span>
                            ${isAdmin ? `
                                <select class="section-teacher-select" onchange="assignSectionTeacher(${s.aulas_id}, this.value)" onclick="event.stopPropagation()">
                                    <option value="">Sin docente asignado</option>
                                    ${teachers.map(t => `<option value="${t.usuarios_id}" ${String(t.usuarios_id) === String(s.maestro_id) ? 'selected' : ''}>${escapeHtml(t.nombre)}</option>`).join('')}
                                </select>
                            ` : `
                                <div class="cc-teacher-info">
                                    <div class="cc-teacher-name">${escapeHtml(s.teacher || 'Sin docente asignado')}</div>
                                    <div class="cc-teacher-role">Docente</div>
                                </div>
                                <span class="cc-count-badge">Sección ${escapeHtml(s.seccion)}</span>
                            `}
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

// ─── AULAS (director): paginado por año — 6 secciones (A-F) a la
// vez, con Anterior/Siguiente ───
let __classroomsGrados = [];
let __classroomsGradoIdx = 0;
let __classroomsTeachers = [];

async function loadClassroomSections() {
    const grid = document.getElementById('classroomsSectionsGrid');
    if (!grid) return;
    grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando...</div>';

    try {
        const response = await fetch('?url=school/sections');
        const sections = await response.json();

        if (!Array.isArray(sections) || sections.length === 0) {
            __classroomsGrados = [];
            renderClassroomsYear();
            return;
        }

        __classroomsTeachers = [];
        if (window.__ndaIsSchoolAdmin) {
            try {
                const tRes = await fetch('?url=school/assignable-teachers');
                __classroomsTeachers = await tRes.json();
                if (!Array.isArray(__classroomsTeachers)) __classroomsTeachers = [];
            } catch (e) { __classroomsTeachers = []; }
        }

        const grados = {};
        sections.forEach(s => {
            const g = s.grado || 'Sin año';
            if (!grados[g]) grados[g] = [];
            grados[g].push(s);
        });
        __classroomsGrados = Object.keys(grados).sort().map(g => ({ grado: g, items: grados[g] }));
        if (__classroomsGradoIdx >= __classroomsGrados.length) __classroomsGradoIdx = 0;

        renderClassroomsYear();
    } catch (e) {
        grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar secciones</div>';
        console.error(e);
    }
}

function renderClassroomsYear() {
    const grid = document.getElementById('classroomsSectionsGrid');
    const label = document.getElementById('classroomsYearLabel');
    const prevBtn = document.getElementById('classroomsYearPrev');
    const nextBtn = document.getElementById('classroomsYearNext');
    if (!grid) return;

    if (__classroomsGrados.length === 0) {
        grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">No hay secciones para mostrar. Si eres director, crea tu institución para generarlas automáticamente.</div>';
        if (label) label.textContent = '—';
        if (prevBtn) prevBtn.disabled = true;
        if (nextBtn) nextBtn.disabled = true;
        return;
    }

    const group = __classroomsGrados[__classroomsGradoIdx];
    if (label) label.textContent = group.grado;
    grid.innerHTML = renderSectionCardsHtml(group.items, __classroomsTeachers, !!window.__ndaIsSchoolAdmin, 'classrooms');

    if (prevBtn) prevBtn.disabled = __classroomsGradoIdx <= 0;
    if (nextBtn) nextBtn.disabled = __classroomsGradoIdx >= __classroomsGrados.length - 1;
}

function changeClassroomsYear(step) {
    const next = __classroomsGradoIdx + step;
    if (next < 0 || next >= __classroomsGrados.length) return;
    __classroomsGradoIdx = next;
    renderClassroomsYear();
}

// ─── SECCIONES (docente/admin): mismo patrón paginado que Aulas ───
let __sectionsGrados = [];
let __sectionsGradoIdx = 0;
let __sectionsTeachers = [];

async function loadSections() {
    const grid = document.getElementById('sectionsGrid');
    if (!grid) return;
    grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Cargando secciones...</div>';

    const showAll = document.getElementById('sectionsShowAll')?.checked ? '?all=1' : '';
    try {
        const response = await fetch('?url=school/sections' + showAll);
        const sections = await response.json();

        if (!Array.isArray(sections) || sections.length === 0) {
            __sectionsGrados = [];
            renderSectionsYear();
            return;
        }

        __sectionsTeachers = [];
        if (window.__ndaIsSchoolAdmin) {
            try {
                const tRes = await fetch('?url=school/assignable-teachers');
                __sectionsTeachers = await tRes.json();
                if (!Array.isArray(__sectionsTeachers)) __sectionsTeachers = [];
            } catch (e) { __sectionsTeachers = []; }
        }

        const grados = {};
        sections.forEach(s => {
            const g = s.grado || 'Sin año';
            if (!grados[g]) grados[g] = [];
            grados[g].push(s);
        });
        __sectionsGrados = Object.keys(grados).sort().map(g => ({ grado: g, items: grados[g] }));
        if (__sectionsGradoIdx >= __sectionsGrados.length) __sectionsGradoIdx = 0;

        renderSectionsYear();
    } catch (e) {
        grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">Error al cargar secciones</div>';
        console.error(e);
    }
}

function renderSectionsYear() {
    const grid = document.getElementById('sectionsGrid');
    const label = document.getElementById('sectionsYearLabel');
    const prevBtn = document.getElementById('sectionsYearPrev');
    const nextBtn = document.getElementById('sectionsYearNext');
    if (!grid) return;

    if (__sectionsGrados.length === 0) {
        grid.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);">No hay secciones para mostrar. Si eres director, crea tu institución para generarlas automáticamente.</div>';
        if (label) label.textContent = '—';
        if (prevBtn) prevBtn.disabled = true;
        if (nextBtn) nextBtn.disabled = true;
        return;
    }

    const group = __sectionsGrados[__sectionsGradoIdx];
    if (label) label.textContent = group.grado;
    grid.innerHTML = renderSectionCardsHtml(group.items, __sectionsTeachers, !!window.__ndaIsSchoolAdmin, 'sections');

    if (prevBtn) prevBtn.disabled = __sectionsGradoIdx <= 0;
    if (nextBtn) nextBtn.disabled = __sectionsGradoIdx >= __sectionsGrados.length - 1;
}

function changeSectionsYear(step) {
    const next = __sectionsGradoIdx + step;
    if (next < 0 || next >= __sectionsGrados.length) return;
    __sectionsGradoIdx = next;
    renderSectionsYear();
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

// originTab: a qué pestaña regresar con el enlace "Volver" de aquí
// abajo — 'classrooms' (Aulas, director) o 'sections' (Secciones,
// docente/admin), según desde dónde se hizo click en la sección.
function filterStudentsBySection(aulaId, nombre, originTab) {
    originTab = originTab || 'classrooms';
    // showSchoolTab('students') dispara internamente loadStudents()
    // (la lista SIN filtro, vía el mapa "loaders"), que borra
    // __studentsActiveAula al iniciar — por eso esta variable se
    // asigna DESPUÉS de showSchoolTab, no antes, si no loadStudents()
    // la pisa de inmediato y el filtro se "pierde" apenas se toca la
    // búsqueda o se agrega/edita/elimina un estudiante.
    showSchoolTab('students');
    setTimeout(async () => {
        __studentsActiveAula = { id: aulaId, nombre: nombre };
        // Deja el filtro codificado en el hash (showSchoolTab de arriba
        // ya puso '#students' a secas) para que un F5 lo restaure en
        // vez de caer en el listado general — ver IIFE de restauración
        // más arriba en este archivo.
        try {
            history.replaceState(null, '', '#students?aula=' + encodeURIComponent(aulaId) + '&nombre=' + encodeURIComponent(nombre) + '&origin=' + encodeURIComponent(originTab));
        } catch (e) { /* noop */ }
        const search = document.getElementById('studentsSearch');
        if (search) search.value = '';
        renderStudentsFilterBar(aulaId, nombre, originTab);
        await loadFilteredStudents(aulaId, nombre);
    }, 50);
}

function renderStudentsFilterBar(aulaId, nombre, originTab) {
    const badge = document.getElementById('studentsFilterBadge');
    if (!badge) return;
    badge.style.display = '';

    // Para ver otra sección hay que volver a Aulas/Secciones y elegir
    // ahí — no hay selector para saltar de sección desde esta lista.
    const backLabel = originTab === 'sections' ? 'Secciones' : 'Aulas';
    const backLink = `<button type="button" class="school-filter-back" onclick="showSchoolTab('${originTab}')">&laquo; ${backLabel}</button>`;
    badge.innerHTML = `${backLink}<span class="school-filter-pill">${escapeHtml(nombre)}</span>`;
}

async function loadFilteredStudents(aulaId, nombre) {
    const tbody = document.getElementById('studentsTableBody');
    if (!tbody) return;
    // La vista filtrada trae hasta 100 estudiantes de una sola vez (no
    // pagina), así que limpia los botones de Anterior/Siguiente que
    // hayan quedado de la última vez que se vio la lista completa —
    // si no, esos botones viejos siguen llamando a loadStudents(page)
    // y sacan de la sección filtrada sin querer.
    const pagination = document.getElementById('studentsPagination');
    if (pagination) pagination.innerHTML = '';
    tbody.innerHTML = `<tr><td colspan="7" class="text-center">Cargando estudiantes de ${escapeHtml(nombre)}...</td></tr>`;
    const q = document.getElementById('studentsSearch')?.value.trim() || '';
    try {
        const response = await fetch('?url=school/students&aula_id=' + aulaId + '&per_page=100&q=' + encodeURIComponent(q));
        const result = await response.json();
        const students = result.data || [];
        if (students.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center">No hay estudiantes registrados en ${escapeHtml(nombre)}</td></tr>`;
            return;
        }
        tbody.innerHTML = students.map(s => `
            <tr>
                <td>${s.numero_lista ?? '—'}</td>
                <td>${escapeHtml(s.codigo || '')}</td>
                <td>${escapeHtml(s.nombre)} ${escapeHtml(s.apellido || '')}</td>
                <td>${escapeHtml(s.classroom || nombre)}</td>
                <td>${escapeHtml(s.telefono_emergencia || '-')}</td>
                <td>${escapeHtml(s.teacher || '-')}</td>
                <td><button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteStudent(${s.estudiantes_id})">Eliminar</button></td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">Error al cargar estudiantes</td></tr>';
    }
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
// Mismos colores que .croquis-dot en school.css, para que los marcadores del
// mapa real y del board 2D se lean igual que la leyenda.
const CROQUIS_COLORS = {
    encuentro: '#5c7a54',
    zona_segura: '#3d6f8f',
    extintor: '#b8433f',
    botiquin: '#c9a63f',
    salida: '#a85736',
    otro: '#6b73a0'
};

async function loadCroquis() {
    const board = document.getElementById('croquisBoard');
    if (!board) return;
    board.innerHTML = '<div class="text-center" style="padding:30px;color:var(--text3);">Cargando croquis...</div>';

    try {
        const response = await fetch('?url=school/croquis');
        const data = await response.json();
        __croquisLastData = data;

        if (!data.imagen) {
            board.innerHTML = `<div class="croquis-empty">
                <p>Todavía no se ha subido un plano de la institución.</p>
                <p class="school-hint">El director puede subir una imagen del croquis con el botón "Subir plano".</p>
            </div>`;
            return;
        }

        board.innerHTML = `<div class="croquis-image-wrap" id="croquisImageWrap">
            <img src="${escapeHtml(data.imagen)}" alt="Croquis de la institución" draggable="false">
        </div>`;

        const wrap = document.getElementById('croquisImageWrap');
        (data.puntos || []).forEach(p => {
            const dot = document.createElement('div');
            dot.className = 'croquis-marker ' + p.tipo;
            dot.style.left = p.pos_x + '%';
            dot.style.top = p.pos_y + '%';
            dot.title = p.nombre;
            dot.innerHTML = `<span class="croquis-marker-tooltip"><strong>${escapeHtml(p.nombre)}</strong><br>${escapeHtml(CROQUIS_LABELS[p.tipo] || p.tipo)}${p.descripcion ? '<br>' + escapeHtml(p.descripcion) : ''}${window.__ndaIsSchoolAdmin ? `<br><a href="#" onclick="deleteCroquisPoint(${p.puntos_croquis_id});return false;">Eliminar</a>` : ''}</span>`;
            wrap.appendChild(dot);
        });

        // Clic sobre el plano = agregar un punto (solo el director/admin
        // edita los puntos del croquis, no docentes).
        if (window.__ndaIsSchoolAdmin) {
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

// ─── CROQUIS: vista en mapa real (MapLibre GL, mismo patron de terreno que hero-globe.js) ───
let __croquisLastData = null;
let __croquisMap = null;
let __croquisMapMarkers = [];
let __croquisEditLocationMode = false;

// Botón "Editar ubicación": mientras no está activo, hacer clic en el mapa
// no mueve nada (evita corregir la ubicación sin querer). Se desactiva
// solo despues de guardar un clic (ver saveInstitutionLocation).
function toggleCroquisEditLocation(forceOff) {
    __croquisEditLocationMode = forceOff ? false : !__croquisEditLocationMode;
    const btn = document.getElementById('croquisEditLocationBtn');
    if (btn) {
        btn.textContent = __croquisEditLocationMode ? 'Cancelar' : 'Editar ubicación';
        btn.classList.toggle('primary', __croquisEditLocationMode);
        btn.classList.toggle('secondary', !__croquisEditLocationMode);
    }
    const hint = document.getElementById('croquisMapHint');
    if (hint && __croquisEditLocationMode) {
        hint.textContent = 'Haz clic en el mapa para fijar la ubicación.';
    }
}

function showCroquisView(view) {
    document.querySelectorAll('[data-croquis-view]').forEach(btn => {
        btn.style.opacity = btn.dataset.croquisView === view ? '1' : '0.6';
    });
    const view2d = document.getElementById('croquisView2d');
    const viewMap = document.getElementById('croquisViewMap');
    if (view2d) view2d.style.display = view === '2d' ? '' : 'none';
    if (viewMap) viewMap.style.display = view === 'map' ? '' : 'none';
    // "Subir plano" solo tiene sentido en la Vista 2D (sube la imagen del
    // croquis) -- en la vista de mapa real no hay nada que subir.
    const uploadBtn = document.getElementById('croquisUploadBtn');
    if (uploadBtn) uploadBtn.style.display = view === '2d' ? '' : 'none';
    if (view === 'map') initCroquisMap();
}

function initCroquisMap() {
    const hint = document.getElementById('croquisMapHint');
    if (!document.getElementById('croquisMap') || typeof ensureMapLibreLoaded !== 'function') {
        if (hint) hint.textContent = 'No se pudo cargar el mapa.';
        return;
    }
    const data = __croquisLastData || { lat: null, lng: null, puntos: [] };
    const hasLoc = data.lat !== null && data.lat !== undefined && data.lat !== '' && data.lng !== null && data.lng !== undefined && data.lng !== '';

    ensureMapLibreLoaded().then(() => {
        if (!window.maplibregl) { if (hint) hint.textContent = 'No se pudo cargar el mapa.'; return; }

        const lat = hasLoc ? parseFloat(data.lat) : 13.7942;
        const lng = hasLoc ? parseFloat(data.lng) : -88.8965;
        // Un mapa de calles (vector u Esri Gray) se ve vacío en zonas rurales
        // poco mapeadas en OpenStreetMap. Imágenes satelitales (Esri World
        // Imagery, gratis y sin key) muestran el terreno real -vegetación,
        // construcciones- sin depender de qué tan mapeada esté la zona; tiene
        // más sentido ademas para una pestaña que se llama "Vista en mapa real".
        const satelliteTiles = ['https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'];

        if (__croquisMap) {
            __croquisMap.remove();
            __croquisMap = null;
            __croquisMapMarkers = [];
        }

        __croquisMap = new maplibregl.Map({
            container: 'croquisMap',
            style: {
                version: 8,
                sources: {
                    'nda-base': { type: 'raster', tiles: satelliteTiles, tileSize: 256, maxzoom: 19, attribution: '© Esri' },
                },
                layers: [{ id: 'nda-base-layer', type: 'raster', source: 'nda-base' }],
            },
            center: [lng, lat],
            zoom: hasLoc ? 17 : 8,
            pitch: 0,
            bearing: 0,
        });

        __croquisMap.on('load', function () {
            renderCroquisMapMarkers(lat, lng, hasLoc, data.puntos || []);
        });

        if (hint) {
            hint.textContent = hasLoc
                ? 'Ubicación aproximada de tu institución (los puntos del croquis son una proyección aproximada, no coordenadas exactas).'
                : (window.__ndaIsSchoolAdmin ? 'Tu institución todavía no tiene coordenadas registradas — usa "Editar ubicación" para fijarlas.' : 'Tu institución todavía no tiene coordenadas registradas.');
        }

        // El clic solo mueve la ubicación con el modo de edición activo (ver
        // toggleCroquisEditLocation) -- antes cualquier clic la movía, lo
        // cual era fácil de disparar sin querer.
        if (window.__ndaIsSchoolAdmin) {
            __croquisMap.on('click', function (e) {
                if (!__croquisEditLocationMode) return;
                saveInstitutionLocation(e.lngLat.lat, e.lngLat.lng);
            });
        }
    }).catch(() => {
        if (hint) hint.textContent = 'No se pudo cargar el mapa.';
    });
}

// Se abre un popup a la vez: MapLibre no cierra otros popups por su cuenta
// (a diferencia de Leaflet), asi que sin esto dos puntos cercanos podian
// quedar con su popup abierto al mismo tiempo, encimados y illegibles.
let __croquisOpenPopup = null;
function registerCroquisPopup(popup) {
    popup.on('open', () => {
        if (__croquisOpenPopup && __croquisOpenPopup !== popup) __croquisOpenPopup.remove();
        __croquisOpenPopup = popup;
    });
    popup.on('close', () => {
        if (__croquisOpenPopup === popup) __croquisOpenPopup = null;
    });
    return popup;
}

function renderCroquisMapMarkers(lat, lng, hasLoc, puntos) {
    if (!__croquisMap || typeof maplibregl === 'undefined') return;
    __croquisMapMarkers.forEach(m => m.remove());
    __croquisMapMarkers = [];
    __croquisOpenPopup = null;

    if (hasLoc) {
        const centerPopup = registerCroquisPopup(new maplibregl.Popup({ maxWidth: '220px' }).setHTML('<strong>Institución</strong>'));
        const centerMarker = new maplibregl.Marker({ color: '#c98a3d' })
            .setLngLat([lng, lat])
            .setPopup(centerPopup)
            .addTo(__croquisMap);
        __croquisMapMarkers.push(centerMarker);
    }

    // Los puntos del croquis se guardan como % (0-100) sobre la imagen 2D, no
    // como coordenadas reales: se proyectan alrededor del centro con un radio
    // fijo aproximado (~60m), no es geo-referenciacion de precision.
    const RADIUS_M = 60;
    puntos.forEach(p => {
        const px = parseFloat(p.pos_x), py = parseFloat(p.pos_y);
        if (isNaN(px) || isNaN(py)) return;
        const offsetXm = ((px - 50) / 50) * RADIUS_M;
        const offsetYm = ((50 - py) / 50) * RADIUS_M;
        const dLat = offsetYm / 111320;
        const dLng = offsetXm / (111320 * Math.cos(lat * Math.PI / 180));

        const color = CROQUIS_COLORS[p.tipo] || CROQUIS_COLORS.otro;
        const el = document.createElement('div');
        el.className = 'croquis-map-marker';
        el.style.cssText = `width:20px;height:20px;border-radius:50%;background:${color};border:3px solid #fff;box-shadow:0 0 0 2px ${color},0 2px 8px rgba(0,0,0,.5);cursor:pointer;`;
        const popup = registerCroquisPopup(new maplibregl.Popup({ maxWidth: '240px' }).setHTML(`<strong>${escapeHtml(p.nombre)}</strong><br>${escapeHtml(CROQUIS_LABELS[p.tipo] || p.tipo)}`));
        const marker = new maplibregl.Marker({ element: el })
            .setLngLat([lng + dLng, lat + dLat])
            .setPopup(popup)
            .addTo(__croquisMap);
        __croquisMapMarkers.push(marker);
    });
}

async function saveInstitutionLocation(lat, lng) {
    try {
        const response = await fetch('?url=school/institution-location', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ lat, lng })
        });
        const result = await response.json();
        if (result.success) {
            if (__croquisLastData) { __croquisLastData.lat = lat; __croquisLastData.lng = lng; }
            toggleCroquisEditLocation(true);
            const hint = document.getElementById('croquisMapHint');
            if (hint) hint.textContent = 'Ubicación guardada.';
            renderCroquisMapMarkers(lat, lng, true, (__croquisLastData && __croquisLastData.puntos) || []);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
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
            if (document.getElementById('inicioMap')) initInicioMap();
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
            <div class="sticky-note ${escapeHtml(n.color)}" data-id="${n.corcho_notas_id}" style="left:${n.pos_x}%; top:${n.pos_y}%; transform: rotate(${n.rotacion}deg);">
                <button class="sticky-note-del" onclick="deleteBoardNote(${n.corcho_notas_id})" title="Quitar nota">&times;</button>
                <p>${escapeHtml(n.texto)}</p>
                <span class="sticky-note-author">${escapeHtml(n.autor)}${n.visibilidad && n.visibilidad !== 'todos' ? ' · Privado' : ''}</span>
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

    const roleLabels = { docente: 'Docente', alumno: 'Estudiante', padre: 'Padre / Encargado', administrativo: 'Personal administrativo' };

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
                    <strong>${escapeHtml(r.usuario_nombre)}</strong>
                    <span class="request-role">${escapeHtml(roleLabels[r.rol_solicitado] || r.rol_solicitado)}</span>
                    <p class="school-hint" style="margin:4px 0 0;">${escapeHtml(r.usuario_email)}</p>
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
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">No hay instituciones registradas</td></tr>';
            renderPagination('institutionsPagination', 1, 1, 'loadInstitutions');
            return;
        }

        const tipoLabelMap = { colegio: 'Colegio', escuela: 'Escuela', instituto: 'Instituto', universidad: 'Universidad', otro: 'Otro' };
        tbody.innerHTML = __institutionsCache.map(i => `
            <tr>
                <td><strong>${escapeHtml(i.nombre)}</strong></td>
                <td>${escapeHtml(tipoLabelMap[i.tipo] || '—')}</td>
                <td>${escapeHtml(i.correo || '—')}</td>
                <td>${escapeHtml(i.telefono || '—')}</td>
                <td>${escapeHtml(i.direccion || '—')}</td>
                <td>${i.estado_verificacion === 'verificado' ? 'Verificada' : 'Pendiente'}</td>
                <td>${i.total_usuarios || 0}</td>
                <td>
                    <button class="school-attendance-btn" data-inst-id="${i.instituciones_id}" data-inst-nombre="${escapeHtml(i.nombre)}" onclick="viewInstitutionStats(this.dataset.instId, this.dataset.instNombre)">Ver detalle</button>
                    <a class="school-attendance-btn" href="?url=school/view-institution&id=${i.instituciones_id}">Ver página general</a>
                    <a class="school-attendance-btn" href="?url=school/view-institution&id=${i.instituciones_id}&dest=panel">Ver panel completo</a>
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
            ['Estudiantes', s.alumnos],
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
        tipo: document.getElementById('institutionTipo').value,
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
    document.getElementById('editInstitutionTipo').value = i.tipo || 'colegio';
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
        tipo: document.getElementById('editInstitutionTipo').value,
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
            list.map(i => `<option value="${i.instituciones_id}" ${String(i.instituciones_id) === String(selectedId) ? 'selected' : ''}>${escapeHtml(i.nombre)}</option>`).join('');
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
                <td><strong>${escapeHtml(u.nombre)}</strong></td>
                <td>${escapeHtml(u.email)}</td>
                <td><span class="chip b">${escapeHtml(roleLabelMap[u.role] || u.role)}</span></td>
                <td>${escapeHtml(u.institucion_nombre || '—')}</td>
                <td>${escapeHtml(u.estado_institucional || '—')}</td>
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
    if (!(await ndaConfirm('¿Eliminar este usuario? Se eliminarán también sus datos asociados (estudiante, docente, etc.).'))) return;
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

// ─── NOTICIAS INTERNAS (grid de tarjetas + modal de lectura completa) ───
let __newsCache = [];
let __newsPage = 1;

async function loadNews(page) {
    const list = document.getElementById('newsList');
    if (!list) return;
    __newsPage = page || 1;
    list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando noticias...</div>';

    try {
        const response = await fetch(`?url=school/news&page=${__newsPage}&per_page=12`);
        const result = await response.json();

        if (result.error) {
            list.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error: ${result.error}</div>`;
            return;
        }
        __newsCache = result.data || [];

        if (__newsCache.length === 0) {
            list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">No hay noticias publicadas todavía</div>';
            renderPagination('newsPagination', 1, 1, 'loadNews');
            return;
        }

        list.innerHTML = __newsCache.map(n => `
            <div class="school-blog-card" data-cat="${n.instituciones_id ? 'institucion' : 'global'}" onclick="location.href='?url=school/news-detail&id=${n.noticias_internas_id}'">
                ${n.imagen
                    ? `<img class="school-blog-card-thumb" src="${escapeHtml(n.imagen)}" alt="${escapeHtml(n.titulo)}">`
                    : `<div class="school-blog-card-thumb placeholder">Sin imagen</div>`}
                <div class="school-blog-card-body">
                    <h4>${escapeHtml(n.titulo)}${!n.instituciones_id ? ' <span class="chip b">Global</span>' : ''}</h4>
                    <p class="school-blog-card-excerpt">${escapeHtml(n.resumen || n.contenido).slice(0, 140)}</p>
                    <div class="school-blog-card-meta">
                        <span>${escapeHtml(n.autor || 'Administración')}</span>
                        <span>${new Date(n.created_at).toLocaleDateString('es-SV')}</span>
                    </div>
                    <div class="school-blog-card-stats">${n.total_likes || 0} me gusta · ${n.total_comments || 0} comentarios</div>
                </div>
                ${window.__ndaIsSchoolAdmin ? `<div class="school-blog-card-actions" onclick="event.stopPropagation()">
                    <button class="school-attendance-btn" onclick="editNews(${n.noticias_internas_id})">Editar</button>
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteNews(${n.noticias_internas_id})">Eliminar</button>
                </div>` : ''}
            </div>
        `).join('');

        renderPagination('newsPagination', result.page, result.total_pages, 'loadNews');
    } catch (e) {
        list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error al cargar noticias</div>';
        console.error(e);
    }
}

document.getElementById('addNewsForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('titulo', document.getElementById('newsTitle').value);
    formData.append('resumen', document.getElementById('newsResumen').value);
    formData.append('contenido', document.getElementById('newsContent').value);
    const fileInput = document.getElementById('newsImage');
    if (fileInput && fileInput.files[0]) {
        formData.append('imagen', fileInput.files[0]);
    }
    try {
        const response = await fetch('?url=school/add-news', { method: 'POST', body: formData });
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
    document.getElementById('editNewsResumen').value = n.resumen || '';
    document.getElementById('editNewsContent').value = n.contenido || '';
    openModal('editNewsModal');
}

document.getElementById('editNewsForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('id', document.getElementById('editNewsId').value);
    formData.append('titulo', document.getElementById('editNewsTitle').value);
    formData.append('resumen', document.getElementById('editNewsResumen').value);
    formData.append('contenido', document.getElementById('editNewsContent').value);
    const fileInput = document.getElementById('editNewsImage');
    if (fileInput && fileInput.files[0]) {
        formData.append('imagen', fileInput.files[0]);
    }
    try {
        const response = await fetch('?url=school/update-news', { method: 'POST', body: formData });
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

// ─── LUGARES EN RIESGO (grid de tarjetas + modal de lectura completa) ───
let __blogPage = 1;
let __blogCache = [];

async function loadBlog(page) {
    const list = document.getElementById('blogList');
    if (!list) return;
    __blogPage = page || 1;
    list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando publicaciones...</div>';

    try {
        const response = await fetch(`?url=school/blog&page=${__blogPage}&per_page=12`);
        const result = await response.json();

        if (result.error) {
            list.innerHTML = `<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error: ${result.error}</div>`;
            return;
        }
        __blogCache = result.data || [];

        if (__blogCache.length === 0) {
            list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Nadie ha publicado todavía. ¡Sé el primero en reportar un lugar en riesgo!</div>';
            renderPagination('blogPagination', 1, 1, 'loadBlog');
            return;
        }

        list.innerHTML = __blogCache.map(b => `
            <div class="school-blog-card" data-cat="${escapeHtml(b.autor_role)}" onclick="location.href='?url=school/riesgo-detail&id=${b.blog_riesgos_id}'">
                ${b.imagen
                    ? `<img class="school-blog-card-thumb" src="${escapeHtml(b.imagen)}" alt="${escapeHtml(b.titulo)}">`
                    : `<div class="school-blog-card-thumb placeholder">Sin imagen</div>`}
                <div class="school-blog-card-body">
                    <h4>${escapeHtml(b.titulo)}</h4>
                    ${b.ubicacion ? `<div class="school-incident-location">${escapeHtml(b.ubicacion)}</div>` : ''}
                    <p class="school-blog-card-excerpt">${escapeHtml(b.descripcion).slice(0, 140)}</p>
                    <div class="school-blog-card-meta">
                        <span>${escapeHtml(b.autor)} (${roleLabelMap[b.autor_role] || b.autor_role})</span>
                        <span>${new Date(b.created_at).toLocaleDateString('es-SV')}</span>
                    </div>
                    <div class="school-blog-card-stats">${b.total_likes || 0} me gusta · ${b.total_comments || 0} comentarios</div>
                </div>
                ${(window.__ndaIsSchoolAdmin || String(b.usuarios_id) === String(window.__ndaMyUserId)) ? `<div class="school-blog-card-actions" onclick="event.stopPropagation()">
                    <button class="school-attendance-btn" style="color:var(--acc2);" onclick="deleteBlogPost(${b.blog_riesgos_id})">Eliminar</button>
                </div>` : ''}
            </div>
        `).join('');

        renderPagination('blogPagination', result.page, result.total_pages, 'loadBlog');
    } catch (e) {
        list.innerHTML = '<div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Error al cargar el blog</div>';
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

// ─── "ME GUSTA" Y COMENTARIOS (paginas de detalle: Noticias / Riesgos / Incidentes) ───
let __commentsCache = [];

function initInteractionBar() {
    if (!window.__ndaContentTipo || !window.__ndaContentId) return;
    loadInteractionSummary();
    loadComments();
}

async function loadInteractionSummary() {
    try {
        const response = await fetch(`?url=school/interaction-summary&tipo=${window.__ndaContentTipo}&id=${window.__ndaContentId}`);
        const data = await response.json();
        renderLikeButton(data.total_likes || 0, !!data.liked_by_me);
    } catch (e) {
        console.error(e);
    }
}

function renderLikeButton(total, likedByMe) {
    const btn = document.getElementById('likeBtn');
    if (!btn) return;
    btn.classList.toggle('active', likedByMe);
    document.getElementById('likeCount').textContent = total;
}

async function toggleLike() {
    try {
        const response = await fetch('?url=school/toggle-like', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tipo: window.__ndaContentTipo, id: window.__ndaContentId })
        });
        const result = await response.json();
        if (result.success) {
            renderLikeButton(result.total, result.liked);
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
}

async function loadComments() {
    const list = document.getElementById('commentsList');
    if (!list) return;
    list.innerHTML = '<div class="text-center" style="padding:14px;color:var(--text3);">Cargando comentarios...</div>';
    try {
        const response = await fetch(`?url=school/comments&tipo=${window.__ndaContentTipo}&id=${window.__ndaContentId}`);
        const comments = await response.json();
        if (comments.error) {
            list.innerHTML = `<div class="text-center" style="padding:14px;color:var(--text3);">Error: ${comments.error}</div>`;
            return;
        }
        __commentsCache = Array.isArray(comments) ? comments : [];

        if (__commentsCache.length === 0) {
            list.innerHTML = '<div class="text-center" style="padding:14px;color:var(--text3);">Sé el primero en comentar.</div>';
            return;
        }

        list.innerHTML = __commentsCache.map(c => `
            <div class="school-comment">
                <div class="school-comment-head">
                    <strong>${escapeHtml(c.autor)}</strong>
                    <span>${roleLabelMap[c.autor_role] || c.autor_role} · ${new Date(c.created_at).toLocaleString('es-SV')}</span>
                    ${(window.__ndaIsSchoolAdmin || String(c.usuarios_id) === String(window.__ndaMyUserId)) ? `<button class="school-comment-del" onclick="deleteComment(${c.interacciones_comentarios_id})">Eliminar</button>` : ''}
                </div>
                <p>${escapeHtml(c.texto)}</p>
            </div>
        `).join('');
    } catch (e) {
        list.innerHTML = '<div class="text-center" style="padding:14px;color:var(--text3);">Error al cargar comentarios</div>';
        console.error(e);
    }
}

document.getElementById('addCommentForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const textarea = document.getElementById('commentText');
    try {
        const response = await fetch('?url=school/add-comment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tipo: window.__ndaContentTipo, id: window.__ndaContentId, texto: textarea.value })
        });
        const result = await response.json();
        if (result.success) {
            textarea.value = '';
            loadComments();
        } else {
            ndaAlert('Error: ' + (result.error || 'Desconocido'));
        }
    } catch (e) {
        ndaAlert('Error de conexión');
    }
});

async function deleteComment(id) {
    if (!(await ndaConfirm('¿Eliminar este comentario?'))) return;
    try {
        const response = await fetch(`?url=school/delete-comment&id=${id}`);
        const result = await response.json();
        if (result.success) {
            loadComments();
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
                <td>${a.destacado == 1 ? 'Sí' : '—'}</td>
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
                <td>${escapeHtml(r.nombre)}</td>
                <td>${escapeHtml(r.fecha)}</td>
                <td><span class="school-attendance-status ${escapeHtml(r.status || 'pendiente')}">${escapeHtml(r.status || 'Pendiente')}</span></td>
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
    initCardFilterBar('newsFilters');
    initCardFilterBar('blogFilters');
    initCardFilterBar('incidentsFilters');
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
                <div><strong>Aula:</strong> ${escapeHtml(c.classroom)} (${escapeHtml(c.grado || '')} ${escapeHtml(c.seccion || '')})</div>
                <div><strong>Docente:</strong> ${escapeHtml(c.teacher || 'Sin asignar')}</div>
                <div><strong>Compañeros:</strong> ${c.total_alumnos || 0} estudiantes</div>
            </div>
        `;
    } catch (e) {
        el.innerHTML = 'Error al cargar tu aula';
    }
}