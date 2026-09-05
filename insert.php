<?php
require_once "db.php";
 
$sql = "INSERT INTO students
        (student_id, name, course, section)
        VALUES
        (:student_id, :name, :course, :section)";
 
$stmt = $pdo->prepare($sql);
 
$students = [
    ["student_id" => "2026-002", "name" => "Maria Santos", "course" => "BSIT", "section" => "BSIT 2A"],
    ["student_id" => "2026-003", "name" => "Pedro Cruz",   "course" => "BSIT", "section" => "BSIT 2B"],
    ["student_id" => "2026-004", "name" => "Ana Reyes",    "course" => "BSIT", "section" => "BSIT 2B"],
    ["student_id" => "2026-005", "name" => "Mark Benedict",    "course" => "BSIT", "section" => "BSIT 3B"],
];
 
$added = 0;
foreach ($students as $student) {
    try {
        $stmt->execute([
            ":student_id" => $student["student_id"],
            ":name" => $student["name"],
            ":course" => $student["course"],
            ":section" => $student["section"]
            ":year" => $student["year"]
        ]);
        $added++;
    } catch (PDOException $e) {
        echo "Skipped {$student['student_id']}: " . $e->getMessage() . "<br>";
    }
}
 
echo "$added students successfully added.";
?>
