<?php

date_default_timezone_set("Asia/Kolkata");

$train_name = $_POST['train_name'] ?? '';
$train_no = $_POST['train_no'] ?? '';

$source = $_POST['source'] ?? '';
$destination = $_POST['destination'] ?? '';

$class = $_POST['class'] ?? '';
$date = $_POST['date'] ?? '';

$departure = $_POST['departure'] ?? '';
$arrival = $_POST['arrival'] ?? '';
$duration = $_POST['duration'] ?? '';

$total_fare = $_POST['total_fare'] ?? 0;
$payment_method = $_POST['payment_method'] ?? '';

$names = $_POST['name'] ?? [];
$ages = $_POST['age'] ?? [];
$genders = $_POST['gender'] ?? [];
$berths = $_POST['berth'] ?? [];
$mobiles = $_POST['mobile'] ?? [];
$emails = $_POST['email'] ?? [];

$passenger_count = count($names);

$pnr = rand(1000000000,9999999999);
$transaction_id = "TXN" . rand(100000,999999);
$ticket_id = "TKT" . date("YmdHis");

$status = "CONFIRMED";

$coach_numbers = [];
$berth_labels = [];
$seat_numbers = [];
$compartments = [];

$class_upper = strtoupper(trim($class));

/* SAME COACH FOR ALL PASSENGERS */

if($class_upper == "EA" || $class_upper == "EC" || $class_upper == "CC"){

    $coach_list = ['C1','C2','E1'];

}
else if($class_upper == "1A"){

    $coach_list = ['HA1','HA2'];

}
else if($class_upper == "2A"){

    $coach_list = ['A1','A2','A3'];

}
else if($class_upper == "3A"){

    $coach_list = ['B1','B2','B3'];

}
else if($class_upper == "SL"){

    $coach_list = ['S1','S2','S3','S4'];

}
else{

    $coach_list = ['D1','D2'];
}

$main_coach =
$coach_list[array_rand($coach_list)];

for($i = 0; $i < $passenger_count; $i++){

    /* =========================
       1A
    ========================== */

    if($class_upper == "1A"){

        $coach_list = ['HA1','HA2'];

        $coach_numbers[$i] = $main_coach;

        $berth_types = [
            'Lower',
            'Upper',
            'Lower',
            'Upper'
        ];

        $berth_labels[$i] =
        $berth_types[array_rand($berth_types)];

        $seat_numbers[$i] =
        rand(1,24);

        $compartment_list = [
            'A','B','C','D'
        ];

        $compartments[$i] =
        $compartment_list[array_rand($compartment_list)];
    }

    /* =========================
       2A
    ========================== */

    else if($class_upper == "2A"){

        $coach_list = [
            'A1','A2','A3','A4'
        ];

        $coach_numbers[$i] = $main_coach;

        $berth_types = [
            'Lower',
            'Upper',
            'Side Lower',
            'Side Upper'
        ];

        $berth_labels[$i] =
        $berth_types[array_rand($berth_types)];

        $seat_numbers[$i] =
        rand(1,54);

        $compartments[$i] = '-';
    }

    /* =========================
       3A
    ========================== */

    else if($class_upper == "3A"){

        $coach_list = [
            'B1','B2','B3','B4','B5'
        ];

        $coach_numbers[$i] = $main_coach;

        $berth_types = [
            'Lower',
            'Middle',
            'Upper',
            'Side Lower',
            'Side Upper'
        ];

        $berth_labels[$i] =
        $berth_types[array_rand($berth_types)];

        $seat_numbers[$i] =
        rand(1,72);

        $compartments[$i] = '-';
    }

    /* =========================
       3E
    ========================== */

    else if($class_upper == "3E"){

        $coach_list = [
            'M1','M2','M3','M4','M5'
        ];

        $coach_numbers[$i] = $main_coach;

        $berth_types = [
            'Lower',
            'Middle',
            'Upper',
            'Side Lower',
            'Side Middle',
            'Side Upper'
        ];

        $berth_labels[$i] =
        $berth_types[array_rand($berth_types)];

        $seat_numbers[$i] =
        rand(1,83);

        $compartments[$i] = '-';
    }

    /* =========================
       Sleeper
    ========================== */

    else if($class_upper == "SL"){

        $coach_list = [
            'S1','S2','S3','S4',
            'S5','S6','S7','S8'
        ];

        $coach_numbers[$i] = $main_coach;

        $berth_types = [
            'Lower',
            'Middle',
            'Upper',
            'Side Lower',
            'Side Upper'
        ];

        $berth_labels[$i] =
        $berth_types[array_rand($berth_types)];

        $seat_numbers[$i] =
        rand(1,72);

        $compartments[$i] = '-';
    }

    /* =========================
       Chair Car
    ========================== */

    else if(
        $class_upper == "CC" ||
        $class_upper == "EC" ||
        $class_upper == "EA"
    ){

        $coach_list = [
            'C1','C2','E1'
        ];

        $coach_numbers[$i] = $main_coach;

        $seat_types = [
            'Window',
            'Aisle'
        ];

        $berth_labels[$i] =
        $seat_types[array_rand($seat_types)];

        $seat_numbers[$i] =
        rand(1,120);

        $compartments[$i] = '-';
    }

    /* =========================
       2S
    ========================== */

    else{

        $coach_list = [
            'D1','D2','D3'
        ];

        $coach_numbers[$i] = $main_coach;

        $berth_labels[$i] = 'Seat';

        $seat_numbers[$i] =
        rand(1,108);

        $compartments[$i] = '-';
    }
}
include("config/db.php");

session_start();

$username = $_SESSION['username'] ?? 'Guest';

for($i=0; $i<$passenger_count; $i++){

$sql = "INSERT INTO bookings(

username,
pnr,
ticket_id,
transaction_id,
train_name,
train_no,
source,
destination,
journey_date,
departure_time,
arrival_time,
duration,
class,
passenger_name,
age,
gender,
coach,
berth,
seat_no,
compartment,
mobile,
email,
fare,
payment_method,
status

) VALUES (

'$username',
'$pnr',
'$ticket_id',
'$transaction_id',
'$train_name',
'$train_no',
'$source',
'$destination',
'$date',
'$departure',
'$arrival',
'$duration',
'$class',
'{$names[$i]}',
'{$ages[$i]}',
'{$genders[$i]}',
'$coach_numbers[$i]',
'{$berth_labels[$i]}',
'{$seat_numbers[$i]}',
'{$compartments[$i]}',
'{$mobiles[$i]}',
'{$emails[$i]}',
'$total_fare',
'$payment_method',
'$status'

)";

mysqli_query($conn,$sql);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Railway Ticket</title>

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
#fff7ed,
#ffffff,
#f8fafc
);

padding:40px 20px;

color:#111827;
}

.container{
max-width:1300px;
margin:auto;
}

.ticket{

background:white;

border-radius:35px;

overflow:hidden;

box-shadow:0 15px 50px rgba(0,0,0,0.12);

position:relative;
}

.ticket::before{

content:"INDIAN RAILWAYS";

position:absolute;

top:40%;
left:5%;

font-size:90px;
font-weight:800;

opacity:0.03;

transform:rotate(-30deg);

pointer-events:none;
}

.ticket-header{

background:
linear-gradient(
135deg,
#ff7b00,
#ff4d00
);

padding:35px;

color:white;
}

.header-top{

display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:20px;
}

.logo-section h1{
font-size:42px;
font-weight:800;
}

.logo-section p{
margin-top:8px;
font-size:18px;
opacity:0.95;
}

.status-box{

background:white;
color:#16a34a;

padding:14px 22px;

border-radius:15px;

font-size:18px;
font-weight:700;
}

.ticket-body{
padding:40px;
}

.train-section{

display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:30px;

padding-bottom:35px;

border-bottom:2px dashed #d1d5db;
}

.train-left h2{
font-size:34px;
font-weight:700;
margin-bottom:12px;
}

.train-left p{
font-size:20px;
color:#6b7280;
}

.train-right{
text-align:right;
}

.train-right h1{
font-size:46px;
font-weight:800;
}

.train-right p{
font-size:18px;
color:#6b7280;
}

.route-box{

margin-top:45px;

background:#fff7ed;

padding:28px;

border-radius:25px;

border:1px solid #fed7aa;
}

.route-line{

display:flex;
align-items:center;
justify-content:center;
gap:18px;

margin-bottom:18px;
}

.station{
font-size:30px;
font-weight:800;
}

.line{
flex:1;
height:3px;
background:#fdba74;
position:relative;
}

.line::after{
position:absolute;
right:45%;
top:-18px;
font-size:28px;
}

.time-row{

display:flex;
justify-content:space-between;

font-size:20px;
font-weight:700;
}

.info-grid{

display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;

margin-top:40px;
}

.info-card{

background:#f8fafc;

padding:22px;

border-radius:20px;

border:1px solid #e5e7eb;
}

.info-card span{

display:block;

font-size:13px;

color:#6b7280;

margin-bottom:10px;

text-transform:uppercase;
letter-spacing:1px;
}

.info-card h3{
font-size:22px;
font-weight:700;
}

.section-title{
font-size:36px;
font-weight:800;
margin:50px 0 30px;
}

.passenger-table{
width:100%;
border-collapse:collapse;
overflow:hidden;
border-radius:20px;
}

.passenger-table thead{
background:#ffedd5;
}

.passenger-table th{
padding:18px;
font-size:16px;
text-align:left;
color:#9a3412;
}

.passenger-table td{
padding:18px;
border-bottom:1px solid #e5e7eb;
font-size:16px;
font-weight:500;
}

.passenger-table tr:hover{
background:#f9fafb;
}

.badge{

background:#fff7ed;

color:#ea580c;

padding:8px 14px;

border-radius:30px;

font-size:14px;
font-weight:700;
}

.bottom-layout{

display:grid;
grid-template-columns:2fr 1fr;
gap:25px;

margin-top:45px;
}

.note-card,
.fare-card{

background:#f8fafc;

padding:30px;

border-radius:25px;

border:1px solid #e5e7eb;
}

.note-card h2,
.fare-card h2{
font-size:30px;
margin-bottom:20px;
}

.note-list{
line-height:2;
font-size:18px;
color:#374151;
}

.summary-row{

display:flex;
justify-content:space-between;

margin-bottom:18px;

font-size:20px;
}

.total-row{

border-top:2px dashed #d1d5db;

padding-top:20px;

margin-top:20px;

font-size:32px;
font-weight:800;
}

.qr-box{
text-align:center;
margin-top:25px;
}

.qr-box img{
width:150px;
height:150px;
}

.qr-box p{
margin-top:12px;
font-size:15px;
color:#6b7280;
}

.button-row{

display:flex;
gap:20px;

margin-top:35px;
}

.btn{

flex:1;

padding:18px;

border:none;

border-radius:18px;

font-size:18px;
font-weight:700;

cursor:pointer;

transition:0.3s;
}

.print-btn{

background:
linear-gradient(
135deg,
#ff7b00,
#ff4d00
);

color:white;
}

.home-btn{
background:#e5e7eb;
}

.btn:hover{
transform:translateY(-2px);
}

.success-animation{

position:fixed;
top:0;
left:0;

width:100%;
height:100%;

background:rgba(15,23,42,0.92);

z-index:9999;

display:flex;
justify-content:center;
align-items:center;
flex-direction:column;

color:white;
}

.checkmark{
font-size:90px;
margin-bottom:25px;
animation:pop 0.7s ease;
}

@keyframes pop{
0%{
transform:scale(0);
}
100%{
transform:scale(1);
}
}

.success-animation h1{
font-size:42px;
margin-bottom:15px;
}

.success-animation p{
font-size:22px;
opacity:0.9;
}

@media(max-width:1100px){

.info-grid{
grid-template-columns:repeat(2,1fr);
}

.bottom-layout{
grid-template-columns:1fr;
}

}

@media(max-width:700px){

.info-grid{
grid-template-columns:1fr;
}

.train-section{
flex-direction:column;
align-items:flex-start;
}

.train-right{
text-align:left;
}

.route-line{
flex-direction:column;
}

.passenger-table{
display:block;
overflow-x:auto;
}

.button-row{
flex-direction:column;
}

}

</style>

</head>

<body>

<div class="success-animation" id="successScreen">

<div class="checkmark">✔</div>

<h1>Booking Confirmed</h1>

<p>Generating Your Ticket...</p>

</div>

<div class="container" id="mainTicket" style="display:none;">

<div class="ticket">

<div class="ticket-header">

<div class="header-top">

<div class="logo-section">

<h1> Prime Rail </h1>

<p>Online Railway Reservation And Management System</p>

</div>

<div class="status-box">
✔ <?php echo $status; ?>
</div>

</div>

</div>

<div class="ticket-body">

<div class="train-section">

<div class="train-left">

<h2>
<?php echo $train_name; ?>
(<?php echo $train_no; ?>)
</h2>


</div>

<div class="train-right">

<h1>
<?php echo date("H:i",strtotime($departure)); ?>
</h1>

<p>Departure</p>

</div>

</div>

<div class="route-box">

<div class="route-line">

<div class="station">
<?php echo $source; ?>
</div>

<div class="line"></div>

<div class="station">
<?php echo $destination; ?>
</div>

</div>

<div class="time-row">

<div>
<?php echo date("H:i",strtotime($departure)); ?>
</div>

<div>
<?php echo $duration; ?>
</div>

<div>
<?php echo date("H:i",strtotime($arrival)); ?>
</div>

</div>

</div>

<div class="info-grid">

<div class="info-card">
<span>Journey Date</span>
<h3><?php echo date("D, d M Y",strtotime($date)); ?></h3>
</div>

<div class="info-card">
<span>Class</span>
<h3><?php echo $class; ?></h3>
</div>

<div class="info-card">
<span>Passengers</span>
<h3><?php echo $passenger_count; ?></h3>
</div>

<div class="info-card">
<span>Payment</span>
<h3><?php echo $payment_method; ?></h3>
</div>

<div class="info-card">
<span>PNR Number</span>
<h3><?php echo $pnr; ?></h3>
</div>

<div class="info-card">
<span>Transaction ID</span>
<h3><?php echo $transaction_id; ?></h3>
</div>

<div class="info-card">
<span>Ticket ID</span>
<h3><?php echo $ticket_id; ?></h3>
</div>

<div class="info-card">
<span>Status</span>
<h3><?php echo $status; ?></h3>
</div>

</div>

<h1 class="section-title">
Passenger Details
</h1>

<table class="passenger-table">

<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Age</th>
<th>Gender</th>
<th>Coach</th>
<th>Berth</th>
<th>Seat No</th>
<th>Compartment</th>
<th>Mobile</th>
<th>Email</th>
</tr>
</thead>

<tbody>

<?php

for($i=0; $i<$passenger_count; $i++){

?>

<tr>

<td><?php echo $i+1; ?></td>

<td>
<?php echo $names[$i]; ?>
</td>

<td>
<?php echo $ages[$i]; ?>
</td>

<td>
<?php echo $genders[$i]; ?>
</td>

<td>
<span class="badge">
<?php echo $coach_numbers[$i]; ?>
</span>
</td>

<td>
<span class="badge">
<?php echo $berth_labels[$i]; ?>
</span>
</td>

<td>
<span class="badge">
<?php echo $seat_numbers[$i]; ?>
</span>
</td>

<td>
<span class="badge">
<?php echo $compartments[$i]; ?>
</span>
</td>

<td>
<?php echo $mobiles[$i]; ?>
</td>

<td>
<?php echo $emails[$i]; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

<div class="bottom-layout">

<div class="note-card">

<h2>Journey Instructions</h2>

<div class="note-list">

<p>• Please carry valid ID proof during travel.</p>

<p>• Arrive at station 30 minutes before departure.</p>

<p>• Platform details will be announced before departure.</p>

<p>• Keep luggage and valuables secure.</p>

<p>• This is a computer generated ticket.</p>

</div>

</div>

<div class="fare-card">

<h2>Fare Summary</h2>

<div class="summary-row">
<span>Total Fare</span>
<span>₹<?php echo $total_fare; ?></span>
</div>

<div class="summary-row total-row">
<span>Paid</span>
<span>₹<?php echo $total_fare; ?></span>
</div>

<div class="qr-box">

<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $pnr; ?>">

<p>Scan for Verification</p>

</div>

</div>

</div>

<div class="button-row">

<button class="btn home-btn" onclick="window.location.href='Home.php'">
Home
</button>

<button class="btn print-btn" onclick="downloadTicket()">
Download Ticket
</button>

</div>

</div>

</div>

</div>

<script>

setTimeout(()=>{

 document.getElementById("successScreen").style.display = "none";

 document.getElementById("mainTicket").style.display = "block";

},2500);

function downloadTicket(){

 window.print();

}

</script>

</body>
</html>