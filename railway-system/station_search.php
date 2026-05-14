    <?php

include("config/db.php");

header("Content-Type: application/json");

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if($q == ''){
    echo json_encode([]);
    exit;
}

$sql = "SELECT code, name 
        FROM stations
        WHERE code LIKE ? 
        OR name LIKE ?
        LIMIT 10";

$stmt = $conn->prepare($sql);

$search = "%".$q."%";

$stmt->bind_param("ss", $search, $search);

$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = [
        "station_code" => $row['code'],
        "station_name" => $row['name']
    ];
}

echo json_encode($data);

?>