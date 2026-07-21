        <!-- ========================================================== -->
        <!--  BLOG DE LUGARES EN RIESGO -->
        <!-- ========================================================== -->
        <div id="tab-blog" class="school-panel">
            <div class="school-panel-header">
                <h3>Lugares en riesgo</h3>
                <button class="school-btn primary" onclick="openModal('addBlogModal')">
                    Publicar
                </button>
            </div>
            <p class="school-hint">Reporta un lugar con riesgo (grietas, objetos inestables, zonas obstruidas...) con una foto y descripción para que toda la comunidad lo vea.</p>
            <div class="school-filters" id="blogFilters">
                <button class="sfilter active" data-cat="all">Todos</button>
                <button class="sfilter" data-cat="director">Director</button>
                <button class="sfilter" data-cat="docente">Docentes</button>
                <button class="sfilter" data-cat="alumno">Alumnos</button>
                <button class="sfilter" data-cat="padre">Padres</button>
                <button class="sfilter" data-cat="administrativo">Personal</button>
            </div>
            <div id="blogList" class="school-card-grid">
                <div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando publicaciones...</div>
            </div>
            <div class="school-pagination" id="blogPagination"></div>
        </div>

        <!-- Modal Publicar en el blog -->
        <div class="school-modal" id="addBlogModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Publicar lugar en riesgo</h3>
                    <button class="school-modal-close" onclick="closeModal('addBlogModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="addBlogForm">
                        <div class="school-form-group">
                            <label>Título *</label>
                            <input type="text" id="blogTitle" placeholder="Ej: Grieta en pasillo B" required>
                        </div>
                        <div class="school-form-group">
                            <label>Ubicación</label>
                            <input type="text" id="blogLocation" placeholder="Ej: Pabellón B, segundo piso">
                        </div>
                        <div class="school-form-group">
                            <label>Descripción *</label>
                            <textarea id="blogDescription" rows="3" placeholder="Describe el riesgo..." required></textarea>
                        </div>
                        <div class="school-form-group">
                            <label>Fotografía (opcional)</label>
                            <input type="file" id="blogImage" accept="image/*">
                        </div>
                        <button type="submit" class="school-btn primary">Publicar</button>
                    </form>
                </div>
            </div>
        </div>
