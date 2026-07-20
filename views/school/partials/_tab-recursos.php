        <!-- ========================================================== -->
        <!--  RECURSOS PDF DESCARGABLES (solo Admin General) -->
        <!-- ========================================================== -->
        <div id="tab-recursos" class="school-panel">
            <div class="school-panel-header">
                <h3>Recursos y guías PDF</h3>
                <button class="school-btn primary" onclick="openRecursoModal()">
                    Agregar recurso
                </button>
            </div>
            <p class="school-hint">Controla las guías descargables que se ven en ?url=resources.</p>
            <div class="school-panel-header" style="margin-top:0;">
                <input type="text" id="recursosSearch" class="school-select" placeholder="Buscar por título..." oninput="debounceRecursosSearch()" style="max-width:280px;">
            </div>
            <div class="school-table-wrap">
                <table class="school-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Tamaño</th>
                            <th>Orden</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="recursosTableBody">
                        <tr><td colspan="5" class="text-center">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="school-pagination" id="recursosPagination"></div>
        </div>

        <div class="school-modal" id="recursoModal">
            <div class="school-modal-content">
                <div class="school-modal-header">
                    <h3 id="recursoModalTitle">Agregar recurso</h3>
                    <button class="school-modal-close" onclick="closeModal('recursoModal')">&times;</button>
                </div>
                <div class="school-modal-body">
                    <form id="recursoForm">
                        <input type="hidden" id="recursoId">
                        <div class="school-form-group">
                            <label>Título *</label>
                            <input type="text" id="recursoTitulo" required>
                        </div>
                        <div class="school-form-group">
                            <label>Descripción</label>
                            <textarea id="recursoDescripcion" rows="2"></textarea>
                        </div>
                        <div class="school-form-group">
                            <label>Categoría *</label>
                            <select id="recursoCategoria">
                                <option value="evacuacion">Evacuación</option>
                                <option value="mochila">Mochila</option>
                                <option value="plan">Plan Familiar</option>
                                <option value="sismo">Sismos</option>
                                <option value="lluvias">Lluvias</option>
                            </select>
                        </div>
                        <div class="school-form-group">
                            <label>Etiquetas (separadas por coma)</label>
                            <input type="text" id="recursoTags" placeholder="ej: Evacuación,Escolar">
                        </div>
                        <div class="school-form-group">
                            <label>Orden (menor número aparece primero)</label>
                            <input type="number" id="recursoOrden" value="0">
                        </div>
                        <div class="school-form-group">
                            <label id="recursoArchivoLabel">Archivo PDF *</label>
                            <input type="file" id="recursoArchivo" accept="application/pdf">
                        </div>
                        <button type="submit" class="school-btn primary">Guardar recurso</button>
                    </form>
                </div>
            </div>
        </div>
