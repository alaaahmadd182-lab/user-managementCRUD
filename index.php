<?php

require_once "database.php";

$sql = "SELECT * FROM users ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>User Management</h1>

    <a href="create.php" class="add-btn">Add User</a>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($users as $user): ?>

            <tr>
                <td><?= $user["id"] ?></td>

                <td>
                    <?= htmlspecialchars($user["first_name"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($user["last_name"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($user["email"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($user["age"]) ?>
                </td>

                <td>
                    <a href="edit.php?id=<?= $user["id"] ?>">Edit</a>

                    <a href="delete.php?id=<?= $user["id"] ?>"
                       onclick="return confirm('Are you sure you want to delete this user?')">
                        Delete
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>
</html>