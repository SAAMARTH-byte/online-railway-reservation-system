<?php

include("config/db.php");

$pnr = "";

$result = null;

if(isset($_POST['check_pnr'])){

    $pnr = $_POST['pnr'];

    $sql = "SELECT * FROM bookings 
            WHERE pnr='$pnr'";

    $result = mysqli_query($conn,$sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PNR Status - PrimeRail</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{

font-family:'Poppins',sans-serif;

background:
linear-gradient(
135deg,
#f8fafc,
#eef2ff,
#ffffff
);

padding:40px 20px;

color:#111827;
}

.container{
max-width:1100px;
margin:auto;
}

.title{

font-size:42px;
font-weight:800;

margin-bottom:35px;

text-align:center;
}

.search-box{

background:white;

padding:35px;

border-radius:25px;

box-shadow:
0 10px 30px rgba(0,0,0,0.06);

margin-bottom:35px;
}

.form-group{

display:flex;

gap:20px;

flex-wrap:wrap;
}

input{

flex:1;

padding:18px;

border:1px solid #d1d5db;

border-radius:14px;

font-size:18px;

outline:none;
}

button{

background:
linear-gradient(
135deg,
#ff7b00,
#ff4d00
);

color:white;

border:none;

padding:18px 35px;

border-radius:14px;

font-size:17px;

font-weight:700;

cursor:pointer;
}

.ticket{

background:white;

border-radius:28px;

padding:35px;

box-shadow:
0 10px 30px rgba(0,0,0,0.06);

margin-top:30px;
}

.top-row{

display:flex;

justify-content:space-between;

align-items:center;

flex-wrap:wrap;

gap:20px;

margin-bottom:30px;
}

.train-name{

font-size:34px;

font-weight:800;
}

.route{

font-size:18px;

color:#6b7280;

margin-top:8px;
}

.status{

background:#dcfce7;

color:#16a34a;

padding:12px 22px;

border-radius:30px;

font-weight:700;
}

.info-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:20px;

margin-bottom:35px;
}

.info-card{

background:#f9fafb;

padding:22px;

border-radius:18px;

border:1px solid #e5e7eb;
}

.info-card span{

display:block;

font-size:13px;

color:#6b7280;

margin-bottom:10px;

font-weight:700;

text-transform:uppercase;
}

.info-card h3{

font-size:24px;

font-weight:700;
}

.passenger-title{

font-size:30px;

font-weight:800;

margin-bottom:20px;
}

table{

width:100%;

border-collapse:collapse;
}

thead{

background:#f3f4f6;
}

th{

padding:16px;

text-align:left;

font-size:14px;
}

td{

padding:16px;

border-bottom:1px solid #e5e7eb;
}

.no-result{

background:white;

padding:40px;

border-radius:20px;

text-align:center;

font-size:22px;

font-weight:700;

color:#ef4444;

box-shadow:
0 10px 30px rgba(0,0,0,0.06);
}

@media(max-width:768px){

.title{
font-size:32px;
}

.train-name{
font-size:26px;
}

}

</style>

</head>

<body>

<div class="container">

<div class="title">
PNR Status Enquiry
</div>

<div class="search-box">

<form method="POST">

<div class="form-group">

<input 
type="text" 
name="pnr"
placeholder="Enter 10 Digit PNR Number"
required
>

<button type="submit" name="check_pnr">
Check Status
</button>

</div>

</form>

</div>

<?php

if(isset($_POST['check_pnr'])){

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);

?>

<div class="ticket">

<div class="top-row">

<div>

<div class="train-name">
<?php echo $row['train_name']; ?>
(<?php echo $row['train_no']; ?>)
</div>

<div class="route">
<?php echo $row['source']; ?>
→
<?php echo $row['destination']; ?>
</div>

</div>

<div class="status">
<?php echo $row['status']; ?>
</div>

</div>

<div class="info-grid">

<div class="info-card">
<span>Journey Date</span>
<h3><?php echo $row['journey_date']; ?></h3>
</div>

<div class="info-card">
<span>Class</span>
<h3><?php echo $row['class']; ?></h3>
</div>

<div class="info-card">
<span>PNR</span>
<h3><?php echo $row['pnr']; ?></h3>
</div>

<div class="info-card">
<span>Payment</span>
<h3><?php echo $row['payment_method']; ?></h3>
</div>

</div>

<div class="passenger-title">
Passenger Details
</div>

<table>

<thead>

<tr>

<th>Name</th>
<th>Age</th>
<th>Gender</th>
<th>Coach</th>
<th>Berth</th>
<th>Seat</th>

</tr>

</thead>

<tbody>

<?php

$passenger_sql = "SELECT * FROM bookings 
                  WHERE pnr='$pnr'";

$passenger_result =
mysqli_query($conn,$passenger_sql);

while($passenger =
mysqli_fetch_assoc($passenger_result)){

?>

<tr>

<td>
<?php echo $passenger['passenger_name']; ?>
</td>

<td>
<?php echo $passenger['age']; ?>
</td>

<td>
<?php echo $passenger['gender']; ?>
</td>

<td>
<?php echo $passenger['coach']; ?>
</td>

<td>
<?php echo $passenger['berth']; ?>
</td>

<td>
<?php echo $passenger['seat_no']; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php

}else{

?>

<div class="no-result">
Invalid PNR Number
</div>

<?php

}

}

?>

</div>

</body>
</html>