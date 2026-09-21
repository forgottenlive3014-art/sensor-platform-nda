        <!-- ========================================================== -->
        <!--  BLOG PUBLICO: ARTICULOS Y NOTICIAS (solo Admin General) -->
        <!-- ========================================================== -->
        <div id="tab-quehacer-content" class="school-panel">
            <div class="school-panel-header">
                <h3>Blog público (artículos y noticias)</h3>
                <button class="school-btn primary" onclick="openArticuloModal()">
                    Agregar artículo
                </button>
            </div>
            <p class="school-hint">Controla lo que se ve en ?url=blog. El artículo marcado como "Destacado" aparece en portada.</p>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="articulosSearch" class="school-select" placeholder="Buscar por título..." oninput="debounceArticulosSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table school-table-wide">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Autor</th>
                            <th>Destacado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="articulosTableBody">
                        <tr><td colspan="5" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="articulosPagination"></div>
        </div>

        <div class="school-modal" id="articuloModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3 id="articuloModalTitle">Agregar artículo</h3>
                    <button type="button" class="school-modal-close" onclick="closeModal('articuloModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="articuloForm">
                        <input type="hidden" id="articuloId">
                        <div class="school-form-group">
                            <label>Título *</label>
                            <input type="text" id="articuloTitulo" required>
                        </div>
                        <div class="school-form-group">
                            <label>Slug (URL, opcional — se genera del título si se deja vacío)</label>
                            <input type="text" id="articuloSlug" placeholder="ej: mi-nuevo-articulo">
                        </div>
                        <div class="school-form-group">
                            <label>Categoría *</label>
                            <select id="articuloCat">
                                <option value="prevencion">Prevención</option>
                                <option value="sismos">Sismos</option>
                                <option value="volcanes">Volcanes</option>
                                <option value="lluvias">Lluvias</option>
                                <option value="huracanes">Huracanes</option>
                                <option value="comunidad">Comunidad</option>
                                <option value="testimonios">Testimonios</option>
                            </select>
                        </div>
                        <div class="school-form-group">
                            <label>Etiqueta visible (ej: "Sismos", "Prevención")</label>
                            <input type="text" id="articuloTag">
                        </div>
                        <div class="school-form-group">
                            <label>Color de acento</label>
                            <input type="color" id="articuloColor" value="#f29f05">
                        </div>
                        <div class="school-form-group">
                            <label>Autor</label>
                            <input type="text" id="articuloAutor" value="Equipo NDA">
                        </div>
                        <div class="school-form-group">
                            <label>Tiempo de lectura</label>
                            <input type="text" id="articuloTiempo" value="5 min">
                        </div>
                        <div class="school-form-group">
                            <label>Imagen de portada (opcional)</label>
                            <input type="file" id="articuloImagen" accept="image/*">
                        </div>
                        <div class="school-form-group">
                            <label>Extracto (resumen corto) *</label>
                            <textarea id="articuloExtracto" rows="2" required></textarea>
                        </div>
                        <div class="school-form-group">
                            <label>Contenido del artículo</label>
                            <div id="articuloCuerpoEditor"
                                class="art-editor"
                                contenteditable="true"
                                data-placeholder="Escribe aquí el contenido del artículo."></div>
                            <div class="art-toolbar" role="toolbar" aria-label="Formato">
                                <button type="button" class="art-tool" data-action="h2" title="Subtítulo">H</button>
                                <button type="button" class="art-tool" data-action="p" title="Párrafo">¶</button>
                                <button type="button" class="art-tool" data-action="bold" title="Negrita"><b>B</b></button>
                                <button type="button" class="art-tool" data-action="italic" title="Cursiva"><i>I</i></button>
                                <button type="button" class="art-tool" data-action="list" title="Lista">☰</button>
                                <button type="button" class="art-tool" data-action="quote" title="Cita">“ ”</button>
                                <button type="button" class="art-tool" data-action="key" title="Dato clave">★</button>
                                <button type="button" class="art-tool" data-action="link" title="Enlace">🔗</button>
                            </div>
                            <input type="hidden" id="articuloCuerpo" name="cuerpo">
                        </div>
                        <div class="school-form-group" style="display:flex;align-items:center;gap:8px;">
                            <input type="checkbox" id="articuloDestacado" style="width:auto;">
                            <label style="margin:0;">Marcar como destacado (portada del blog)</label>
                        </div>
                        <button type="submit" class="school-btn primary">Guardar artículo</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="school-modal" id="articleLinkModal">
            <div class="school-modal-content article-link-modal-content">
                <div class="school-modal-header">
                    <h3>Insertar enlace</h3>
                    <button type="button" class="school-modal-close" onclick="closeModal('articleLinkModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="articleLinkForm">
                        <div class="school-form-group">
                            <label>URL del enlace</label>
                            <input type="url" id="articleLinkUrl" placeholder="https://" required>
                        </div>
                        <div class="school-form-group">
                            <label>Texto visible (opcional)</label>
                            <input type="text" id="articleLinkText" placeholder="Ej: Ver más">
                        </div>
                        <div class="article-link-actions">
                            <button type="button" class="school-btn secondary" onclick="closeModal('articleLinkModal')">Cancelar</button>
                            <button type="submit" class="school-btn primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
