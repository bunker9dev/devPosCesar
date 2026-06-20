<?php

namespace App\Core;

/**
 * Database
 * Conexión única (singleton) a MySQL usando mysqli.
 * Centraliza configuración y manejo de errores, evitando que
 * cada Controller/Model abra su propia conexión por separado.
 */
class Database
{
    private static ?\mysqli $instance = null;

    /**
     * Devuelve la conexión activa (la crea si no existe aún).
     */
    public static function getConnection(): \mysqli
    {
        if (self::$instance === null) {
            self::$instance = self::connect();
        }

        return self::$instance;
    }

    private static function connect(): \mysqli
    {
        $host   = getenv('DB_HOST')     ?: 'localhost';
        $user   = getenv('DB_USER')     ?: 'root';
        $pass   = getenv('DB_PASSWORD') ?: '';
        $dbname = getenv('DB_NAME')     ?: 'devpos_cesar';
        $port   = (int)(getenv('DB_PORT') ?: 3306);

        mysqli_report(MYSQLI_REPORT_OFF);

        $conn = new \mysqli($host, $user, $pass, $dbname, $port);

        if ($conn->connect_error) {
            error_log('[DB ERROR] ' . $conn->connect_error);
            http_response_code(500);
            die('Error de conexión a la base de datos.');
        }

        $conn->set_charset('utf8mb4');

        return $conn;
    }

    /**
     * Cierra la conexión manualmente (uso poco común, ej. scripts CLI).
     */
    public static function close(): void
    {
        if (self::$instance !== null) {
            self::$instance->close();
            self::$instance = null;
        }
    }

    private function __construct() {}
    private function __clone() {}
}