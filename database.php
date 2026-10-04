<?php

$env = parse_ini_file(".env");

$host = $env["DB_HOST"];
$dbname = $env["DB_NAME"];
$username = $env["DB_USER"];
$password = $env["DB_PASSWORD"];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>