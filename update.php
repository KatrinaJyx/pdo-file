<?php
require_once "db.php";
 
$id = $_GET["id"] ?? $_POST["id"] ?? null;
$errors = [];
$student = null;
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $name    = trim($_POST["name"]);
    $course  = trim($_POST["course"]);
    $section = trim($_POST["section"]);
 
    if ($name === "" || $course === "" || $section === "") {
        $errors[] = "All fields are required.";
    } else {
        $sql = "UPDATE students
                SET name = :name, course = :course, section = :section
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":course" => $course,
            ":section" => $section,
            ":id" => $id
        ]);
 
        if ($stmt->rowCount() > 0) {
            header("Location: students.php");
            exit;
        } else {
            $errors[] = "No changes were made, or the student was not found.";
        }
    }
}
 
if ($id !== null) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $student = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<h1>Update Student</h1>
 
<?php foreach ($errors as $error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>
 
<?php if ($student): ?>
<form method="POST">
    <input type="hidden" name="id" value="<?= $student['id'] ?>">
 
    <p><strong>Student ID:</strong> <?= htmlspecialchars($student['student_id']) ?> (not editable)</p>
 
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
    <br><br>
 
    <label>Course:</label><br>
    <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
    <br><br>
 
    <label>Section:</label><br>
    <input type="text" name="section" value="<?= htmlspecialchars($student['section']) ?>" required>
    <br><br>

    <label>Year:</label><br>
    <input type="text" name="year" value="<?= htmlspecialchars($student['year']) ?>" required>
    <br><br>
 
    <button type="submit">Update Student</button>
</form>
<?php else: ?>
    <p>Student not found. <a href="students.php">Back to list</a></p>
<?php endif; ?>
 
</body>
</html>
