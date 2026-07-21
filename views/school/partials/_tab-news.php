        <div id="tab-news" class="school-panel">
            <div class="school-panel-header">
                <h3>Noticias internas</h3>
                <?php if (!empty($isSchoolAdmin)): ?>
                <button class="school-btn primary" onclick="openModal('addNewsModal')">
                    Publicar noticia
                </button>
                <?php endif; ?>
            </div>
            <p class="school-hint">Comunicados del director o del Admin General hacia la comunidad institucional.</p>
            <div class="school-filters" id="newsFilters">
                <button class="sfilter active" data-cat="all">Todas</button>
                <button class="sfilter" data-cat="institucion">Mi institución</button>
                <button class="sfilter" data-cat="global">Global</button>
            </div>
            <div id="newsList" class="school-card-grid">
                <div class="text-center" style="padding:20px;color:var(--text3);grid-column:1/-1;">Cargando noticias...</div>
            </div>
            <div class="school-pagination" id="newsPagination"></div>
        </div>

        <?php if (!empty($isSchoolAdmin)): ?>
        <div class="school-modal" id="addNewsModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Publicar noticia</h3>
                    <button class="school-modal-close" onclick="closeModal('addNewsModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="addNewsForm">
                        <div class="school-form-group">
                            <label>Título *</label>
                            <input type="text" id="newsTitle" required>
                        </div>
                        <div class="school-form-group">
                            <label>Resumen (opcional)</label>
                            <input type="text" id="newsResumen" maxlength="300" placeholder="Extracto corto para la tarjeta — si lo dejas vacío, se genera del contenido.">
                        </div>
                        <div class="school-form-group">
                            <label>Imagen (opcional)</label>
                            <input type="file" id="newsImage" accept="image/*">
                        </div>
                        <div class="school-form-group">
                            <label>Contenido *</label>
                            <textarea id="newsContent" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="school-btn primary">Publicar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="school-modal" id="editNewsModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3>Editar noticia</h3>
                    <button class="school-modal-close" onclick="closeModal('editNewsModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="editNewsForm">
                        <input type="hidden" id="editNewsId">
                        <div class="school-form-group">
                            <label>Título *</label>
                            <input type="text" id="editNewsTitle" required>
                        </div>
                        <div class="school-form-group">
                            <label>Resumen (opcional)</label>
                            <input type="text" id="editNewsResumen" maxlength="300">
                        </div>
                        <div class="school-form-group">
                            <label>Imagen (opcional — deja vacío para conservar la actual)</label>
                            <input type="file" id="editNewsImage" accept="image/*">
                        </div>
                        <div class="school-form-group">
                            <label>Contenido *</label>
                            <textarea id="editNewsContent" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="school-btn primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
