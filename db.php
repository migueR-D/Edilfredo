<?php
// Estos datos los obtienes en Supabase: Settings > Database > Connection string > PHP
$host = 'aws-1-us-west-2.pooler.supabase.com'; // Ejemplo de host de Supabase
$db   = 'postgres';                            // Por defecto es postgres
$user = 'postgres.ztzxulkwqswbimcqknzw';        // Usuario específico de tu proyecto
$pass = 'Sanmiguel#10mR.';                  // La contraseña que pusiste al crear el proyecto
$port = '6543';                                // Puerto estándar de PostgreSQL
$charset = 'utf8';

// Cambiamos 'mysql' por 'pgsql' y agregamos el puerto
$dsn = "pgsql:host=$host;port=$port;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // PDO se encarga de gestionar la conexión con los nuevos parámetros
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Es mejor no mostrar el error completo en producción, pero para desarrollo está bien
    die('Error de conexión a Supabase: ' . $e->getMessage());
}