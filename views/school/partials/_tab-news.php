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
            <div id="newsList" class="school-news-list">
                <div class="text-center" style="padding:20px;color:var(--text3);">Cargando noticias...</div>
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
                            <label>Contenido *</label>
                            <textarea id="editNewsContent" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="school-btn primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
