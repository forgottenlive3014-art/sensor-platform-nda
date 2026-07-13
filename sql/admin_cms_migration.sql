-- ============================================================
-- MIGRACION: CRUD amplio del superadmin
-- - Reutiliza la tabla `blog` (existia pero no la usaba ningun
--   controlador/modelo) para el blog publico del sitio.
-- - Crea `recursos` para las guias PDF descargables.
-- - Crea `contenido_paginas` (clave-valor) para el contenido editable
--   de "Que hacer ahora" y "Acerca de NDA".
-- Correr UNA sola vez.
-- ============================================================

ALTER TABLE blog
  ADD COLUMN slug VARCHAR(150) NOT NULL DEFAULT '' AFTER blog_id,
  ADD COLUMN cat VARCHAR(30) NOT NULL DEFAULT 'prevencion' AFTER titulo,
  ADD COLUMN tag VARCHAR(40) NOT NULL DEFAULT '' AFTER cat,
  ADD COLUMN color VARCHAR(7) NOT NULL DEFAULT '#f29f05' AFTER tag,
  ADD COLUMN autor_nombre VARCHAR(120) NOT NULL DEFAULT 'Equipo NDA' AFTER autor_id,
  ADD COLUMN tiempo VARCHAR(20) NOT NULL DEFAULT '5 min' AFTER autor_nombre,
  ADD COLUMN destacado TINYINT(1) NOT NULL DEFAULT 0 AFTER tiempo,
  ADD COLUMN extracto VARCHAR(300) NOT NULL DEFAULT '' AFTER destacado,
  ADD COLUMN cuerpo LONGTEXT NULL AFTER contenido;

-- La tabla `blog` traia filas de prueba viejas (con encoding roto, nunca
-- mostradas en el sitio ya que nada las leia). Se limpian antes de poner
-- slug como UNIQUE, porque todas comparten slug='' por defecto.
DELETE FROM blog;

ALTER TABLE blog ADD UNIQUE KEY uq_blog_slug (slug);

-- Nota: todas las tablas de este proyecto son MyISAM (sin llaves foraneas
-- reales, ni siquiera cuando el .sql original las declaraba -- ver `blog`).
-- usuarios_id aqui es solo una referencia simple, igual que el resto del
-- esquema; no se agrega FOREIGN KEY para no romper la creacion de la tabla.
CREATE TABLE recursos (
  recursos_id INT PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  descripcion VARCHAR(300) NULL,
  categoria VARCHAR(30) NOT NULL,
  tags VARCHAR(150) NULL,
  archivo VARCHAR(255) NOT NULL,
  tamano_bytes INT NULL,
  orden INT NOT NULL DEFAULT 0,
  usuarios_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM;

CREATE TABLE contenido_paginas (
  contenido_paginas_id INT PRIMARY KEY AUTO_INCREMENT,
  pagina VARCHAR(30) NOT NULL,
  campo VARCHAR(100) NOT NULL,
  valor TEXT NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_pagina_campo (pagina, campo)
) ENGINE=MyISAM;
