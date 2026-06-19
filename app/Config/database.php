<?php


########.  DESDE WINDOWS. #########

function conectarDB() {

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "devpos_cesar";

     $db = new mysqli($host, $user, $pass, $dbname);

    if ($db->connect_error) {
        die("Error de conexión: " . $db->connect_error);
    }

    $db->set_charset("utf8mb4");

    return $db;
}


// ########.  DESDE MAC. #########

// function conectarDB()
// {
//     $conn = new mysqli(
//         '127.0.0.1',
//         'proyecto',
//         '1234',
//         'devpos_cesar',
//         3306
//     );

//     if ($conn->connect_error) {
//         die("DB ERROR: " . $conn->connect_error);
//     }

//     return $conn;
// }
