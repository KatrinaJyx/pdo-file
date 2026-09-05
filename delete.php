<?php
require_once "db.php";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $id = $_POST["id"] ?? null;
 
    if ($id !== null) {
        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
    }
}
 
header("Location: students.php");
exit;
?>
