<?php

require_once "database.php";

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

        $sql = "INSERT INTO users (first_name, last_name, email, age)
                VALUES (:first_name, :last_name, :email, :age)";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "age" => $age
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $errors[] = "Email already exists.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="form-container">

    <h1>Add User</h1>

    <?php foreach ($errors as $error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form action="create.php" method="POST">

        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Age</label>
        <input type="number" name="age" required>

        <button type="submit">Add User</button>

    </form>

    <a href="index.php" class="back-btn">Back</a>

</div>

</body>
</html>