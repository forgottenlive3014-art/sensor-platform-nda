-- ================================================================
-- NDA — Migracion: sistema de notificaciones
-- Correr UNA sola vez sobre una base de datos que ya tiene
-- sql/nda_project.sql importado. No borra ni modifica datos
-- existentes; solo agrega la tabla nueva.
-- ================================================================

CREATE TABLE IF NOT EXISTS notificaciones (
    notificaciones_id INT PRIMARY KEY AUTO_INCREMENT,

    -- Origen de la notificacion: de donde viene el evento.
    tipo ENUM('sismica', 'escolar', 'sensor', 'sistema') NOT NULL,

    -- Reutiliza exactamente la escala de 5 estados del Design System
    -- (Fase 2), para que el color en la UI sea siempre consistente.
    severidad ENUM('seguro', 'informativo', 'precaucion', 'alerta', 'emergencia') NOT NULL DEFAULT 'informativo',

    -- Alcance del destinatario: uno de los tres, o ninguno si es_global = TRUE.
    destinatario_usuario_id INT NULL,
    destinatario_institucion_id INT NULL,
    es_global BOOLEAN NOT NULL DEFAULT FALSE,

    mensaje VARCHAR(255) NOT NULL,

    -- Referencia opcional a la fila que origino la notificacion
    -- (ej. 'lecturas_sensor', 'simulacros', 'solicitudes_institucion'),
    -- para poder enlazar a mas detalle sin duplicar datos.
    referencia_tipo VARCHAR(40) NULL,
    referencia_id INT NULL,

    leida BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (destinatario_usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,

    INDEX idx_notif_usuario (destinatario_usuario_id, leida),
    INDEX idx_notif_institucion (destinatario_institucion_id, leida),
    INDEX idx_notif_global (es_global, leida)
);
