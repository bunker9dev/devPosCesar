<?php

namespace App\Services;

class ScheduleService
{
    /**
     * ¿Puede este usuario acceder al sistema en este momento?
     */
    public static function isAllowedNow(int $userId, int $rolId): bool
    {
        global $db;

        $schedule = self::getActiveSchedule($db, $userId, $rolId);

        // Sin horario definido en absoluto → sin restricción
        if (empty($schedule)) {
            return true;
        }

        $diaActual = (int) date('w');   // 0=Domingo ... 6=Sábado
        $horaActual = date('H:i:s');

        foreach ($schedule as $franja) {
            if ((int)$franja['dia_semana'] === $diaActual
                && $horaActual >= $franja['hora_inicio']
                && $horaActual <= $franja['hora_fin']) {
                return true;
            }
        }

        // Hay horario definido, pero ninguna franja cubre el momento actual
        return false;
    }

    /**
     * Prioridad: horario propio del usuario > horario del rol > sin restricción
     */
    private static function getActiveSchedule(\mysqli $db, int $userId, int $rolId): array
    {
        $userSchedule = self::fetchSchedule($db, 'user', $userId);

        if (!empty($userSchedule)) {
            return $userSchedule;
        }

        return self::fetchSchedule($db, 'role', $rolId);
    }

    private static function fetchSchedule(\mysqli $db, string $scopeType, int $scopeId): array
    {
        $stmt = $db->prepare("
            SELECT dia_semana, hora_inicio, hora_fin
            FROM access_schedules
            WHERE scope_type = ?
              AND scope_id = ?
              AND estado = 1
              AND deleted_at IS NULL
        ");

        $stmt->bind_param("si", $scopeType, $scopeId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}