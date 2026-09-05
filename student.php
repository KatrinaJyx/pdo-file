<?php
require_once "db.php";
 
$search = $_GET["search"] ?? "";
$sort   = $_GET["sort"]   ?? "id";
$allowedSorts = ["id", "student_id", "name", "course", "section"];
if (!in_array($sort, $allowedSorts)) {
    $sort = "id";
}
 
if ($search !== "") {
    $sql = "SELECT * FROM students
            WHERE name LIKE :search OR student_id LIKE :search
            ORDER BY $sort DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":search" => "%$search%"]);
} else {
    $sql = "SELECT * FROM students ORDER BY $sort DESC";
    $stmt = $pdo->query($sql);
}
 
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<h1>Student List</h1>
 
<form method="GET">
    <input type="text" name="search" placeholder="Search name or ID"
           value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>
 
<table>
    <tr>
        <th><a href="?sort=id">ID</a></th>
        <th><a href="?sort=student_id">Student ID</a></th>
        <th><a href="?sort=name">Name</a></th>
        <th><a href="?sort=course">Course</a></th>
        <th><a href="?sort=section">Section</a></th>
        <th>Actions</th>
    </tr>
 
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?= $student["id"] ?></td>
        <td><?= htmlspecialchars($student["student_id"]) ?></td>
        <td><?= htmlspecialchars($student["name"]) ?></td>
        <td><?= htmlspecialchars($student["course"]) ?></td>
        <td><?= htmlspecialchars($student["section"]) ?></td>
        <td>
            <a href="update.php?id=<?= $student['id'] ?>">Edit</a> |
            <form action="delete.php" method="POST" style="display:inline"
                  onsubmit="return confirm('Delete this student?');">
                <input type="hidden" name="id" value="<?= $student['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
 
    <?php if (empty($students)): ?>
    <tr><td colspan="6">No students found.</td></tr>
    <?php endif; ?>
</table>
 
</body>
</html>
