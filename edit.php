<?php

require_once "database.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "id" => $id
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: index.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $age = $_POST["age"];

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($age)
    ) {
        $errors[] = "Please fill in all fields.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email.";
    }

    if (empty($errors)) {

        $sql = "UPDATE users
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    age = :age
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "age" => $age,
                "id" => $id
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $errors[] = "Email already exists.";
        }
    }

    $user["first_name"] = $first_name;
    $user["last_name"] = $last_name;
    $user["email"] = $email;
    $user["age"] = $age;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="form-container">

    <h1>Edit User</h1>

    <?php foreach ($errors as $error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form action="edit.php?id=<?= $user["id"] ?>" method="POST">

        <label>First Name</label>
        <input
            type="text"
            name="first_name"
            value="<?= htmlspecialchars($user["first_name"]) ?>"
            required
        >

        <label>Last Name</label>
        <input
            type="text"
            name="last_name"
            value="<?= htmlspecialchars($user["last_name"]) ?>"
            required
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($user["email"]) ?>"
            required
        >

        <label>Age</label>
        <input
            type="number"
            name="age"
            value="<?= htmlspecialchars($user["age"]) ?>"
            required
        >

        <button type="submit">Update User</button>

    </form>

    <a href="index.php" class="back-btn">Back</a>

</div>

</body>
</html>