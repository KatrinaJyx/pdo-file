<?php
require_once "db.php";
 
$errors = [];
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $student_id = trim($_POST["student_id"]);
    $name       = trim($_POST["name"]);
    $course     = trim($_POST["course"]);
    $section    = trim($_POST["section"]);
    $year    = trim($_POST["year"]);
 
    if ($student_id === "") $errors[] = "Student ID is required.";
    if ($name === "")       $errors[] = "Name is required.";
    if ($course === "")     $errors[] = "Course is required.";
    if ($section === "")    $errors[] = "Section is required.";
    if ($year === "")    $errors[] = "Year is required.";
 
    if (empty($errors)) {
        $sql = "INSERT INTO students
                (student_id, name, course, section)
                VALUES
                (:student_id, :name, :course, :section)";
        $stmt = $pdo->prepare($sql);
 
        try {
            $stmt->execute([
                ":student_id" => $student_id,
                ":name" => $name,
                ":course" => $course,
                ":section" => $section
                ":year" => $year
            ]);
            header("Location: students.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = ($e->getCode() == 23000)
                ? "That Student ID already exists."
                : "Insert failed: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<h1>Add Student</h1>
 
<?php foreach ($errors as $error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>
 
<form method="POST">
    <label>Student ID:</label><br>
    <input type="text" name="student_id" required
           value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>">
    <br><br>
 
    <label>Name:</label><br>
    <input type="text" name="name" required
           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
    <br><br>
 
    <label>Course:</label><br>
    <input type="text" name="course" required
           value="<?= htmlspecialchars($_POST['course'] ?? '') ?>">
    <br><br>
 
    <label>Section:</label><br>
    <input type="text" name="section" required
           value="<?= htmlspecialchars($_POST['section'] ?? '') ?>">
    <br><br>

    <label>Year:</label><br>
    <input type="text" name="year" required
           value="<?= htmlspecialchars($_POST['year'] ?? '') ?>">
    <br><br>
 
    <button type="submit">Save Student</button>
</form>
 
</body>
</html>
