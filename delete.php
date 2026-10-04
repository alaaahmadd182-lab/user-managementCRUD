<?php

require_once "database.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];

$sql = "DELETE FROM users WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "id" => $id
]);

header("Location: index.php");
exit;

?>