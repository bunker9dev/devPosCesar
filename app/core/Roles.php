<?php

namespace App\Core;

class Roles
{
    const SUPER = 1;
    const ADMIN = 2;
    const SECRETARIA = 3;
    const BODEGUERO = 4;
    const VENDEDOR = 5;
    const ASISTENTE = 6;
    public static function canEdit($rolId)
    {
        return in_array((int)$rolId, [
            self::SUPER,
            self::ADMIN,
            self::SECRETARIA,

        ]);
    }

    public static function canDelete($rolId)
    {
        return in_array((int)$rolId, [
            self::SUPER,
            self::ADMIN
        ]);
    }

    public static function canRestore($rolId)
    {
        return $rolId === self::SUPER;
    }


    public function create()
    {
        global $db;

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        // 🔥 FILTRAR ROLES
        if ($rolId === Roles::SUPER) {
            $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);
        } else {
            // ❌ no puede ver SUPER
            $roles = $db->query("SELECT * FROM roles WHERE id != " . Roles::SUPER)
                ->fetch_all(MYSQLI_ASSOC);
        }

        $this->render('Modules/Users/Views/create', [
            'roles' => $roles
        ]);
    }
}
