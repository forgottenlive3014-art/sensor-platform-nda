<?php require_once __DIR__ . '/../../../models/ContenidoModel.php'; ?>
        <!-- ========================================================== -->
        <!--  EDITOR: "ACERCA DE NDA" (solo Admin General) -->
        <!-- ========================================================== -->
        <div id="tab-acercade-content" class="school-panel">
            <div class="school-panel-header">
                <h3>Contenido — Acerca de NDA</h3>
                <button class="school-btn primary" onclick="saveContentForm('acercade')">
                    Guardar cambios
                </button>
            </div>
            <p class="school-hint">Edita los textos que se muestran en ?url=acercade. Los campos vacíos no se sobrescriben.</p>
            <form id="acercadeContentForm">
                <?php
                $lastGroup = null;
                foreach (ContenidoModel::acercadeFieldDefs() as $def):
                    if ($def['group'] !== $lastGroup):
                        if ($lastGroup !== null) echo '</details>';
                        $lastGroup = $def['group'];
                        echo '<details class="school-content-group"><summary>' . htmlspecialchars($lastGroup) . '</summary>';
                    endif;
                ?>
                    <div class="school-form-group">
                        <label><?= htmlspecialchars($def['label']) ?></label>
                        <?php if ($def['type'] === 'textarea'): ?>
                            <textarea rows="2" data-campo="<?= htmlspecialchars($def['campo']) ?>"></textarea>
                        <?php else: ?>
                            <input type="text" data-campo="<?= htmlspecialchars($def['campo']) ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; if ($lastGroup !== null) echo '</details>'; ?>
            </form>
        </div>
