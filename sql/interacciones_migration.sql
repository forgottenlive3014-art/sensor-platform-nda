-- ------------------------------------------------------------
-- "Me gusta" y comentarios para Noticias, Lugares en riesgo e
-- Incidentes. Tablas genericas (tipo_contenido + contenido_id) para
-- no triplicar esquema/codigo por cada tipo de contenido.
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS interacciones_likes (
    interacciones_likes_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('noticia','riesgo','incidente') NOT NULL,
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_like (tipo_contenido, contenido_id, usuarios_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_contenido (tipo_contenido, contenido_id)
);

CREATE TABLE IF NOT EXISTS interacciones_comentarios (
    interacciones_comentarios_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('noticia','riesgo','incidente') NOT NULL,
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    texto VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_contenido (tipo_contenido, contenido_id)
);
