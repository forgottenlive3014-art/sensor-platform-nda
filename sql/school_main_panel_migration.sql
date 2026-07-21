-- ------------------------------------------------------------
-- Reestructuracion del modulo escolar en Pagina Principal (school)
-- + Panel de Gestion (school/panel). Solo agrega columnas para el
-- rediseno de Noticias como tarjetas con imagen + resumen; el resto
-- de la reestructuracion es de codigo/UI, sin cambios de esquema
-- (las notificaciones segmentadas reusan destinatario_usuario_id,
-- que ya existe en sql/notificaciones_migracion.sql).
-- ------------------------------------------------------------

ALTER TABLE noticias_internas
    ADD COLUMN imagen VARCHAR(255) NULL AFTER contenido,
    ADD COLUMN resumen VARCHAR(300) NULL AFTER titulo;
