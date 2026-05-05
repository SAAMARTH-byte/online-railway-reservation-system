<?php
require_once("config/db.php");

/* GET DATA */
$from  = $_GET['source'] ?? '';
$to    = $_GET['destination'] ?? '';
$date  = $_GET['date'] ?? '';
$class = $_GET['class'] ?? 'ALL';
$quota = $_GET['quota'] ?? 'GN';

$trains = [];

/* FETCH TRAINS (FIXED QUERY) */
if ($from && $to) {

    $stmt = $conn->prepare("
        SELECT * FROM trains 
        WHERE source LIKE CONCAT(?, '%') 
        AND destination LIKE CONCAT(?, '%')
    ");

    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $trains[] = $row;
    }
}

/* STATUS FUNCTION */
function getStatus($seats){
    if($seats > 20) return "<span style='color:green;'>AVAILABLE ($seats)</span>";
    if($seats > 5)  return "<span style='color:orange;'>RAC ($seats)</span>";
    if($seats > 0)  return "<span style='color:red;'>WL ($seats)</span>";
    return "<span style='color:red;'>FULL</span>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>PrimeRail - Search</title>

<style>
body {
    font-family: Segoe UI;
    background:#f4f6f9;
}

/* HEADER */
.header {
    background:#0b1f3a;
    color:#fff;
    padding:15px 40px;
    font-size:20px;
    font-weight:bold;
}

/* SUMMARY */
.summary {
    width:85%;
    margin:20px auto;
    background:#fff;
    padding:15px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
}

/* CONTAINER */
.container {
    width:85%;
    margin:auto;
}

/* CARD */
.card {
    background:#fff;
    margin:20px 0;
    padding:20px;
    border-radius:12px;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

/* CLASS BOX */
.class-box {
    display:flex;
    gap:10px;
    margin-top:10px;
}

.class {
    background:#eef2f7;
    padding:10px;
    border-radius:6px;
    font-size:13px;
}

/* BUTTON */
.btn {
    margin-top:15px;
    padding:10px 20px;
    background:orange;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="header"> PrimeRail Results</div>

<!-- SUMMARY -->
<div class="summary">
    <div><b>From:</b> <?= htmlspecialchars($from) ?></div>
    <div><b>To:</b> <?= htmlspecialchars($to) ?></div>
    <div><b>Date:</b> <?= htmlspecialchars($date) ?></div>
    <div><b>Class:</b> <?= htmlspecialchars($class) ?></div>
    <div><b>Quota:</b> <?= htmlspecialchars($quota) ?></div>
</div>

<div class="container">

<?php if (!$from || !$to): ?>
    <h3>Please enter source and destination</h3>

<?php elseif (empty($trains)): ?>
    <h3>No trains found </h3>

<?php else: ?>

<?php foreach ($trains as $t): ?>

<div class="card">

    <h3><?= $t['train_number'] ?> - <?= $t['train_name'] ?></h3>

    <p>
        <?= $t['source'] ?> → <?= $t['destination'] ?>
    </p>

    <p>
        Departure: <b><?= $t['departure_time'] ?></b> |
        Arrival: <b><?= $t['arrival_time'] ?></b>
    </p>

    <p>
        Duration: <?= $t['duration'] ?> |
        Via: <?= $t['via'] ?>
    </p>

    <div class="class-box">

        <?php if($t['class_SL'] >= 0): ?>
            <div class="class">SL<br><?= getStatus($t['class_SL']) ?></div>
        <?php endif; ?>

        <?php if($t['class_3A'] >= 0): ?>
            <div class="class">3A<br><?= getStatus($t['class_3A']) ?></div>
        <?php endif; ?>

        <?php if($t['class_2A'] >= 0): ?>
            <div class="class">2A<br><?= getStatus($t['class_2A']) ?></div>
        <?php endif; ?>

        <?php if($t['class_1A'] >= 0): ?>
            <div class="class">1A<br><?= getStatus($t['class_1A']) ?></div>
        <?php endif; ?>

    </div>

    <form action="book.php" method="GET">
        <input type="hidden" name="train" value="<?= $t['train_number'] ?>">
        <input type="hidden" name="class" value="<?= $class ?>">
        <input type="hidden" name="quota" value="<?= $quota ?>">
        <button class="btn">Book Now</button>
    </form>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</body>
</html>