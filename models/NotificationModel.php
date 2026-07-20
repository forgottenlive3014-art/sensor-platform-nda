<?php
class NotificationModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // $data: tipo, severidad, destinatario_usuario_id, destinatario_institucion_id,
    //        es_global, mensaje, referencia_tipo, referencia_id
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO notificaciones
                (tipo, severidad, destinatario_usuario_id, destinatario_institucion_id,
                 es_global, mensaje, referencia_tipo, referencia_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['tipo'],
            $data['severidad'] ?? 'informativo',
            $data['destinatario_usuario_id'] ?? null,
            $data['destinatario_institucion_id'] ?? null,
            !empty($data['es_global']) ? 1 : 0,
            $data['mensaje'],
            $data['referencia_tipo'] ?? null,
            $data['referencia_id'] ?? null,
        ]);
        return $this->db->lastInsertId();
    }

    // Envía una notificación a todos los usuarios de un rol dentro de una
    // institución (o de cualquier institución si $instId es null) — una
    // fila por destinatario, mismo esquema que create() con
    // destinatario_usuario_id, sin agregar columnas nuevas.
    public function createForRole($instId, $role, array $data) {
        $sql = "SELECT usuarios_id FROM usuarios WHERE role = ?";
        $params = [$role];
        if ($instId !== null) {
            $sql .= " AND institucion_id = ?";
            $params[] = $instId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $userIds = array_column($stmt->fetchAll(), 'usuarios_id');
        return $this->createForUsers($userIds, $data);
    }

    // Envía la misma notificación a una lista explícita de usuarios.
    public function createForUsers(array $userIds, array $data) {
        $count = 0;
        foreach (array_unique($userIds) as $uid) {
            $this->create(array_merge($data, ['destinatario_usuario_id' => $uid]));
            $count++;
        }
        return $count;
    }

    // Notificaciones relevantes para el usuario actual: las globales,
    // las de su institucion (si pertenece a una aprobada), y las
    // dirigidas a el directamente. Solo las nuevas desde $sinceId.
    public function latestFor($userId, $institucionId, $sinceId = 0, $limit = 30) {
        $stmt = $this->db->prepare("
            SELECT * FROM notificaciones
            WHERE notificaciones_id > ?
              AND (
                    es_global = TRUE
                    OR destinatario_usuario_id = ?
                    OR (destinatario_institucion_id IS NOT NULL AND destinatario_institucion_id = ?)
                  )
            ORDER BY notificaciones_id ASC
            LIMIT " . intval($limit) . "
        ");
        $stmt->execute([$sinceId, $userId, $institucionId]);
        return $stmt->fetchAll();
    }

    public function maxId() {
        $stmt = $this->db->query("SELECT MAX(notificaciones_id) as max_id FROM notificaciones");
        return (int)($stmt->fetch()['max_id'] ?? 0);
    }

    // Historial completo (leidas y no leidas) del usuario actual, para la
    // bandeja de entrada — a diferencia de latestFor(), que solo trae lo
    // nuevo desde el ultimo poll.
    public function countInboxFor($userId, $institucionId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total FROM notificaciones
            WHERE es_global = TRUE
               OR destinatario_usuario_id = ?
               OR (destinatario_institucion_id IS NOT NULL AND destinatario_institucion_id = ?)
        ");
        $stmt->execute([$userId, $institucionId]);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getInboxPage($userId, $institucionId, $page = 1, $perPage = 15) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("
            SELECT * FROM notificaciones
            WHERE es_global = TRUE
               OR destinatario_usuario_id = ?
               OR (destinatario_institucion_id IS NOT NULL AND destinatario_institucion_id = ?)
            ORDER BY notificaciones_id DESC
            LIMIT $perPage OFFSET $offset
        ");
        $stmt->execute([$userId, $institucionId]);
        return $stmt->fetchAll();
    }

    public function countUnreadFor($userId, $institucionId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total FROM notificaciones
            WHERE leida = FALSE
              AND (
                    es_global = TRUE
                    OR destinatario_usuario_id = ?
                    OR (destinatario_institucion_id IS NOT NULL AND destinatario_institucion_id = ?)
                  )
        ");
        $stmt->execute([$userId, $institucionId]);
        return (int)($stmt->fetch()['total'] ?? 0);
    }

    // Marca como leida solo si el destinatario coincide con el usuario
    // actual (directo, o via su institucion) — evita que un usuario
    // marque como leida una notificacion ajena.
    public function markRead($notifId, $userId, $institucionId) {
        $stmt = $this->db->prepare("
            UPDATE notificaciones SET leida = TRUE
            WHERE notificaciones_id = ?
              AND (
                    es_global = TRUE
                    OR destinatario_usuario_id = ?
                    OR (destinatario_institucion_id IS NOT NULL AND destinatario_institucion_id = ?)
                  )
        ");
        $stmt->execute([$notifId, $userId, $institucionId]);
        return $stmt->rowCount() > 0;
    }

    // --- Gestión (Admin Institucional / Admin General) ---

    public function countSent($instId, $isGlobalAdmin) {
        $sql = "SELECT COUNT(*) as total FROM notificaciones WHERE 1=1";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND destinatario_institucion_id = ?";
            $params[] = $instId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getSentPage($instId, $isGlobalAdmin, $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM notificaciones WHERE 1=1";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND destinatario_institucion_id = ?";
            $params[] = $instId;
        }
        $sql .= " ORDER BY notificaciones_id DESC LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM notificaciones WHERE notificaciones_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM notificaciones WHERE notificaciones_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
