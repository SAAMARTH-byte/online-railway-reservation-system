<?php

$conn = mysqli_connect("localhost","root","","railway_db");

if(!$conn){
    die("Database Connection Failed");
}

$train = null;
$route = [];
$coaches = [];

if(isset($_GET['train_number'])){

    $train_number = mysqli_real_escape_string(
        $conn,
        $_GET['train_number']
    );

    // TRAIN DETAILS

    $trainQuery = mysqli_query(
        $conn,
        "SELECT * FROM trains
        WHERE train_number='$train_number'"
    );

    $train = mysqli_fetch_assoc($trainQuery);

    // ROUTE DETAILS

    $routeQuery = mysqli_query(
        $conn,
        "SELECT * FROM train_route
        WHERE train_number='$train_number'
        ORDER BY distance_km ASC"
    );

    while($row = mysqli_fetch_assoc($routeQuery)){
        $route[] = $row;
    }

    // COACH POSITION

    $coachQuery = mysqli_query(
        $conn,
        "SELECT * FROM coach_position
        WHERE train_number='$train_number'
        ORDER BY coach_order ASC"
    );

    while($coach = mysqli_fetch_assoc($coachQuery)){
        $coaches[] = $coach;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>PrimeRail Train Route</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f4f7fb;
    font-family:Arial;
    color:#111827;
}

.container{
    width:92%;
    margin:auto;
    padding:30px 0;
}

/* SEARCH */

.search-card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.search-title{
    font-size:30px;
    font-weight:bold;
    margin-bottom:20px;
}

.search-form{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.search-form input{
    flex:1;
    min-width:250px;
    padding:16px;
    border-radius:12px;
    border:1px solid #d1d5db;
    font-size:16px;
}

.search-form button{
    padding:16px 28px;
    border:none;
    border-radius:12px;
    background:#ff6b00;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

/* TRAIN CARD */

.train-card{
    background:white;
    border-radius:22px;
    padding:30px;
    margin-bottom:25px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

.train-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
}

.train-name{
    font-size:34px;
    font-weight:bold;
}

.train-route{
    margin-top:8px;
    color:#6b7280;
    font-size:18px;
}

.status{
    background:#16a34a;
    color:white;
    padding:12px 20px;
    border-radius:30px;
    font-weight:bold;
}

/* INFO GRID */

.info-grid{
    margin-top:25px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
}

.info-box{
    background:#f8fafc;
    border-radius:16px;
    padding:20px;
}

.info-label{
    color:#6b7280;
    font-size:13px;
    margin-bottom:10px;
    text-transform:uppercase;
    letter-spacing:1px;
}

.info-value{
    font-size:24px;
    font-weight:bold;
}

/* DAYS */

.days{
    margin-top:25px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.day{
    background:#eff6ff;
    color:#2563eb;
    padding:10px 15px;
    border-radius:10px;
    font-weight:bold;
}

/* COACH SECTION */

.coach-section{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

.section-title{
    font-size:26px;
    font-weight:bold;
    margin-bottom:20px;
}

.coach-row{
    display:flex;
    gap:12px;
    overflow-x:auto;
    padding-bottom:10px;
}

.coach{
    min-width:80px;
    background:#0f172a;
    color:white;
    padding:18px;
    border-radius:12px;
    text-align:center;
    font-weight:bold;
    transition:0.3s;
}

.coach:hover{
    background:#ff6b00;
    transform:translateY(-5px);
}

/* ROUTE TABLE */

.route-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#0f172a;
    color:white;
    padding:18px;
    text-align:left;
}

td{
    padding:18px;
    border-bottom:1px solid #e5e7eb;
}

tr:hover{
    background:#f9fafb;
}

.station{
    font-weight:bold;
    font-size:16px;
}

.code{
    color:#6b7280;
    margin-top:5px;
    font-size:13px;
}

/* NO TRAIN */

.no-train{
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    font-size:22px;
    font-weight:bold;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

/* MOBILE */

@media(max-width:768px){

.train-name{
    font-size:26px;
}

.info-value{
    font-size:20px;
}

th,td{
    font-size:14px;
    padding:12px;
}

}

</style>

</head>

<body>

<div class="container">

<!-- SEARCH -->

<div class="search-card">

<div class="search-title">
Train Route Timeline
</div>

<form method="GET" class="search-form">

<input
type="text"
name="train_number"
placeholder="Enter Train Number"
required>

<button type="submit">
Search Train
</button>

</form>

</div>

<?php if($train){ ?>

<!-- TRAIN HEADER -->

<div class="train-card">

<div class="train-top">

<div>

<div class="train-name">
<?= $train['train_name']; ?>
(<?= $train['train_number']; ?>)
</div>

<div class="train-route">
<?= $train['source']; ?>
 →
<?= $train['destination']; ?>
</div>

</div>

<div class="status">
RUNNING
</div>

</div>

<!-- INFO -->

<div class="info-grid">

<div class="info-box">
<div class="info-label">Departure</div>
<div class="info-value">
<?= date("h:i A",
strtotime($train['departure_time'])); ?>
</div>
</div>

<div class="info-box">
<div class="info-label">Arrival</div>
<div class="info-value">
<?= date("h:i A",
strtotime($train['arrival_time'])); ?>
</div>
</div>

<div class="info-box">
<div class="info-label">Duration</div>
<div class="info-value">
<?= $train['duration']; ?>
</div>
</div>

<div class="info-box">
<div class="info-label">Train Type</div>
<div class="info-value">
Express
</div>
</div>

</div>

<!-- RUNNING DAYS -->

<div class="days">

<?php

if(isset($train['running_days'])){

$days = explode(",", $train['running_days']);

foreach($days as $day){

echo "<div class='day'>$day</div>";

}

}

?>

</div>

</div>

<!-- COACH POSITION -->

<div class="coach-section">

<div class="section-title">
Coach Position
</div>

<div class="coach-row">

<?php

foreach($coaches as $coach){

echo "
<div class='coach'>
{$coach['coach_name']}
</div>
";

}

?>

</div>

</div>

<!-- ROUTE TABLE -->

<div class="route-card">

<table>

<tr>
<th>#</th>
<th>Station</th>
<th>Arrival</th>
<th>Departure</th>
<th>Halt</th>
<th>Distance</th>
<th>Platform</th>
<th>Day</th>
</tr>

<?php

$count = 1;

foreach($route as $row){

?>

<tr>

<td><?= $count++; ?></td>

<td>

<div class="station">
<?= $row['station_name']; ?>
</div>

<div class="code">
<?= $row['station_code']; ?>
</div>

</td>

<td>
<?= $row['arrival_time']; ?>
</td>

<td>
<?= $row['departure_time']; ?>
</td>

<td>
<?= $row['halt_time']; ?>
</td>

<td>
<?= $row['distance_km']; ?> km
</td>

<td>
<?= rand(1,8); ?>
</td>

<td>
<?= $row['day_no']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

<?php } ?>

<?php

if(isset($_GET['train_number']) && !$train){

echo "
<div class='no-train'>
Train Not Found
</div>
";

}

?>

</div>

<script>

// AUTO FOCUS

document.addEventListener("DOMContentLoaded", ()=>{

const input = document.querySelector(
'input[name=\"train_number\"]'
);

if(input){
    input.focus();
}

});

// CARD ANIMATION

const cards = document.querySelectorAll(
'.train-card,.coach-section,.route-card'
);

cards.forEach((card,index)=>{

card.style.opacity = "0";
card.style.transform = "translateY(30px)";

setTimeout(()=>{

card.style.transition = "0.6s";

card.style.opacity = "1";

card.style.transform = "translateY(0px)";

}, index * 200);

});

// COACH ACTIVE EFFECT

const coach = document.querySelectorAll(".coach");

coach.forEach(item=>{

item.addEventListener("click", ()=>{

coach.forEach(c=>{
    c.style.background="#0f172a";
});

item.style.background="#ff6b00";

});

});

</script>

</body>
</html>