<?php

include("config/db.php");

session_start();

if(!isset($_SESSION['username'])){

    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM bookings 
        WHERE username='$username'
        GROUP BY pnr
        ORDER BY id DESC";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Bookings</title>

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
#0f172a,
#111827,
#1e293b
);

min-height:100vh;
padding:40px 20px;
color:white;
}

.container{
max-width:1100px;
margin:auto;
}

.page-title{

font-size:42px;
font-weight:800;
margin-bottom:35px;
color:white;
}

.ticket-card{

background:rgba(255,255,255,0.07);
backdrop-filter:blur(18px);
border:1px solid rgba(255,255,255,0.08);
border-radius:28px;
padding:28px;
margin-bottom:28px;
box-shadow:
0 10px 35px rgba(0,0,0,0.35);
transition:0.3s;
}

.ticket-card:hover{

transform:translateY(-5px);
box-shadow:
0 14px 45px rgba(249,115,22,0.18);
}

.top-row{

display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:18px;
margin-bottom:25px;
}

.train-name{

font-size:30px;
font-weight:800;
color:#f8fafc;
}

.route{

font-size:17px;
color:#cbd5e1;
margin-top:6px;
}

.status{

background:#16a34a;
padding:12px 22px;
border-radius:50px;
font-size:14px;
font-weight:700;
letter-spacing:1px;
}

.info-grid{

display:grid;
grid-template-columns:
repeat(auto-fit,minmax(180px,1fr));
gap:18px;
}

.info-box{

background:rgba(255,255,255,0.04);
padding:18px;
border-radius:18px;
border:1px solid rgba(255,255,255,0.05);
}

.label{

font-size:11px;
color:#94a3b8;
margin-bottom:8px;
text-transform:uppercase;
letter-spacing:1px;
}

.value{

font-size:18px;
font-weight:700;
color:white;
}

.bottom-row{

margin-top:25px;
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:20px;
}

.fare{

font-size:30px;
font-weight:800;
color:#f59e0b;
}

.btn{

padding:14px 28px;
border:none;
border-radius:14px;
background:linear-gradient(135deg,#f59e0b,#ea580c);
color:white;
font-size:15px;
font-weight:700;
cursor:pointer;
transition:0.3s;
}

.btn:hover{

transform:scale(1.05);
}

.empty{

text-align:center;
padding:100px 20px;
font-size:28px;
color:#94a3b8;
}

@media(max-width:768px){

.page-title{
font-size:34px;
}

.train-name{
font-size:24px;
}

.info-grid{
grid-template-columns:1fr;
}

.bottom-row{
flex-direction:column;
align-items:flex-start;
}

.btn{
width:100%;
}

}

</style>

</head>

<body>

<div class="container">

<h1 class="page-title">
My Bookings
</h1>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<div class="ticket-card">

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

<?php

$pnr = $row['pnr'];

$passenger_sql = "SELECT * FROM bookings WHERE pnr='$pnr'";
$passenger_result = mysqli_query($conn,$passenger_sql);

?>

<div class="info-grid">

<div class="info-box">
<div class="label">Journey Date</div>
<div class="value">
<?php echo $row['journey_date']; ?>
</div>
</div>


<div class="info-box">
<div class="label">Class</div>
<div class="value">
<?php echo $row['class']; ?>
</div>
</div>

<div class="info-box">
<div class="label">Coach</div>
<div class="value">
<?php echo $row['coach']; ?>
</div>
</div>

<div class="info-box">
<div class="label">PNR Number</div>
<div class="value">
<?php echo $row['pnr']; ?>
</div>
</div>

</div>

<div style="margin-top:30px;">

<div style="font-size:22px;font-weight:700;margin-bottom:18px;color:#f8fafc;">
Passengers
</div>

<div style="overflow-x:auto;">

<table style="width:100%;border-collapse:collapse;">

<thead>
<tr>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;border-radius:12px 0 0 12px;">#</th>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;">Name</th>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;">Age</th>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;">Gender</th>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;">Coach</th>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;">Berth</th>
<th style="padding:14px;background:rgba(255,255,255,0.08);text-align:left;border-radius:0 12px 12px 0;">Seat</th>
</tr>
</thead>

<tbody>

<?php

$count = 1;

while($passenger = mysqli_fetch_assoc($passenger_result)){

?>

<tr>
<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $count++; ?>
</td>

<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $passenger['passenger_name']; ?>
</td>

<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $passenger['age']; ?>
</td>

<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $passenger['gender']; ?>
</td>

<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $passenger['coach']; ?>
</td>

<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $passenger['berth']; ?>
</td>

<td style="padding:14px;border-bottom:1px solid rgba(255,255,255,0.05);">
<?php echo $passenger['seat_no']; ?>
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<div class="bottom-row">

<div class="fare">
₹<?php echo $row['fare']; ?>
</div>

<button class="btn"
onclick="viewTicket('<?php echo $row['pnr']; ?>')">

View Ticket

</button>

</div>

</div>

<?php

}

}else{

?>

<div class="empty">
No Bookings Found
</div>

<?php } ?>

</div>

<script>

function viewTicket(pnr){

window.location.href =
"ticket.php?pnr=" + pnr;

}

</script>

</body>
</html>