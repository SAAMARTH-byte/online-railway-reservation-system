<?php
include "config/db.php";

header("Content-Type: application/json");

$q = $_GET['q'] ?? '';

if ($q == '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT station_name, station_code 
        FROM stations 
        WHERE station_name LIKE ? OR station_code LIKE ? 
        LIMIT 10";

$stmt = $conn->prepare($sql);

$like = "%$q%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);