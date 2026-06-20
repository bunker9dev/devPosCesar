<?php

namespace App\Core;

/**
 * Model
 * Clase base opcional para los Models del sistema.
 * No reemplaza la lógica de cada módulo: solo centraliza lo que
 * todos necesitan (conexión + helpers de consulta repetidos).
 * Los Models existentes que reciben $db por constructor pueden
 * seguir funcionando igual sin heredar de esta clase.
 */
abstract class Model
{
    protected \mysqli $db;

    /**
     * Si no se inyecta una conexión explícita, usa la conexión
     * única gestionada por Database::getConnection().
     */
    public function __construct(?\mysqli $db = null)
    {
        $this->db = $db ?? Database::getConnection();
    }

    /**
     * SELECT preparado → devuelve todas las filas.
     */
    protected function fetchAll(string $sql, string $types = '', array $params = []): array
    {
        $stmt = $this->db->prepare($sql);

        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * SELECT preparado → devuelve una sola fila (o null).
     */
    protected function fetchOne(string $sql, string $types = '', array $params = []): ?array
    {
        $stmt = $this->db->prepare($sql);

        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        return $row ?: null;
    }

    /**
     * INSERT/UPDATE/DELETE preparado.
     * Devuelve insert_id si fue INSERT, o affected_rows si fue UPDATE/DELETE.
     */
    protected function execute(string $sql, string $types = '', array $params = []): int
    {
        $stmt = $this->db->prepare($sql);

        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        return $stmt->insert_id ?: $stmt->affected_rows;
    }
}