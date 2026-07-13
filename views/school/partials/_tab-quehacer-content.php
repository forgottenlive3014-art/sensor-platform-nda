<?php require_once __DIR__ . '/../../../models/ContenidoModel.php'; ?>
        <!-- ========================================================== -->
        <!--  EDITOR: "¿QUÉ HACER AHORA?" (solo Admin General) -->
        <!-- ========================================================== -->
        <div id="tab-quehacer-content" class="school-panel">
            <div class="school-panel-header">
                <h3>Contenido — ¿Qué hacer ahora?</h3>
                <button class="school-btn primary" onclick="saveContentForm('quehacer')">
                    Guardar cambios
                </button>
            </div>
            <p class="school-hint">Edita los textos que se muestran en ?url=quehacer. Los campos vacíos no se sobrescriben.</p>
            <form id="quehacerContentForm">
                <?php
                $lastGroup = null;
                foreach (ContenidoModel::quehacerFieldDefs() as $def):
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
