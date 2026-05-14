<?php

include 'config/db.php';

session_start();

$train_name = $_POST['train_name'] ?? '';
$train_no = $_POST['train_no'] ?? '';

$source = $_POST['source'] ?? '';
$destination = $_POST['destination'] ?? '';

$class = $_POST['class'] ?? '';
$date = $_POST['date'] ?? '';

$departure = $_POST['departure'] ?? '';
$arrival = $_POST['arrival'] ?? '';
$duration = $_POST['duration'] ?? '';

$fare = isset($_POST['fare'])
? (int)$_POST['fare']
: 0;

$names = $_POST['name'] ?? [];
$ages = $_POST['age'] ?? [];
$genders = $_POST['gender'] ?? [];
$nationalities = $_POST['nationality'] ?? [];
$berths = $_POST['berth'] ?? [];

$mobiles = isset($_POST['mobile'])
? (array)$_POST['mobile']
: [];

$emails = isset($_POST['email'])
? (array)$_POST['email']
: [];

$passenger_count = count($names);

$convenience_fee = 20;
$gst = 30;

$base_fare = $fare * $passenger_count;

$total_fare =
$base_fare +
$convenience_fee +
$gst;

if(isset($_POST['pay_now'])){

$username = $_SESSION['username'] ?? 'guest';

$pnr = rand(1000000000,9999999999);

$booking_date = date("Y-m-d H:i:s");

for($i=0; $i<$passenger_count; $i++){

    $passenger_name = $names[$i] ?? '';

    $age = $ages[$i] ?? '';

    $gender = $genders[$i] ?? '';

    $nationality = $nationalities[$i] ?? '';

    $berth_pref = $berths[$i] ?? '';

    $mobile = $mobiles[$i] ?? '';

    $email = $emails[$i] ?? '';

    $query = "INSERT INTO bookings(

    username,
    pnr,
    train_name,
    train_no,
    source,
    destination,
    class,
    journey_date,
    departure_time,
    arrival_time,
    duration,
    passenger_name,
    age,
    gender,
    nationality,
    berth_preference,
    mobile,
    email,
    fare,
    total_fare,
    booking_date

    )

    VALUES(

    '$username',
    '$pnr',
    '$train_name',
    '$train_no',
    '$source',
    '$destination',
    '$class',
    '$date',
    '$departure',
    '$arrival',
    '$duration',
    '$passenger_name',
    '$age',
    '$gender',
    '$nationality',
    '$berth_pref',
    '$mobile',
    '$email',
    '$fare',
    '$total_fare',
    '$booking_date'

    )";

    mysqli_query($conn,$query);
    if(mysqli_error($conn)){
    die(mysqli_error($conn));
}

}

header("Location: ticket.php?pnr=$pnr");

exit();

}


?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Payment</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
#ffffff,
#eef2ff
);

padding:40px 20px;

color:#111827;
}

.container{
max-width:1400px;
margin:auto;
}

.steps{

display:flex;
justify-content:center;
align-items:center;
gap:70px;

margin-bottom:40px;
}

.step{

display:flex;
align-items:center;
gap:14px;
}

.circle{

width:44px;
height:44px;

border-radius:50%;

display:flex;
align-items:center;
justify-content:center;

font-size:18px;
font-weight:700;

background:#dbeafe;

color:#1e3a8a;
}

.active .circle{

background:
linear-gradient(
135deg,
#ff7b00,
#ff5e00
);

color:white;

box-shadow:
0 6px 15px rgba(255,94,0,0.35);
}

.step span{

font-size:16px;
font-weight:600;

color:#6b7280;
}

.active span{

color:#ea580c;
}

.layout{

display:grid;

grid-template-columns:2fr 1fr;

gap:25px;
}

.card{

background:white;
border-radius:20px;
padding:24px;
border:1px solid #e5e7eb;
box-shadow:0 6px 20px rgba(0,0,0,0.06);
}

.train-name{

font-size:22px;
font-weight:700;
margin-bottom:35px;
color:#111827;
}

.time-grid{

display:grid;
grid-template-columns:1fr auto 1fr;
align-items:center;
gap:40px;
margin-bottom:40px;
}

.time-box{

display:flex;
flex-direction:column;
}

.time-box:first-child{
align-items:flex-start;
text-align:left;
}

.time-box:last-child{
align-items:flex-end;
text-align:right;
}

.time-box h1{

font-size:28px;
font-weight:700;
color:#111827;
}

.time-box p{

margin-top:12px;
font-size:22px;
font-weight:700;
color:#374151;
}

.duration-wrapper{

display:flex;
align-items:center;
justify-content:center;
gap:15px;
min-width:300px;
}

.duration-line{

height:2px;
background:#d1d5db;
flex:1;
}

.duration-text{

font-size:24px;
font-weight:700;
color:#374151;
}

.info-grid{

display:grid;
grid-template-columns:repeat(4,1fr);

padding-top:30px;
border-top:1px solid #e5e7eb;
text-align:center;
}

.info-box span{

display:block;
font-size:15px;
color:#9ca3af;
margin-bottom:10px;
}

.info-box h3{

font-size:20px;
font-weight:700;
color:#111827;
}

.section-title{

font-size:26px;
font-weight:700;
margin:45px 0 25px;
}

.passenger-card{

background:white;
border-radius:18px;
padding:18px;
margin-bottom:18px;
border:1px solid #e5e7eb;
box-shadow:0 8px 30px rgba(0,0,0,0.05);
}

.passenger-title{

font-size:24px;
font-weight:700;
margin-bottom:25px;
color:#ea580c;
}

.passenger-grid{

display:grid;
grid-template-columns:repeat(3,1fr);
gap:12px;
}

.detail{

background:#f8fafc;
padding:14px;
border-radius:12px;
border:1px solid #e5e7eb;
}

.detail span{

display:block;
font-size:12px;
color:#6b7280;
margin-bottom:10px;
text-transform:uppercase;
letter-spacing:1px;
}

.detail h4{

font-size:20px;
font-weight:700;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

.payment-title{

font-size:30px;
font-weight:700;
margin-bottom:30px;
}

.payment-option{

display:flex;
align-items:center;
gap:14px;
width:100%;
padding:18px 20px;
border:1px solid #e5e7eb;
border-radius:16px;
margin-bottom:18px;
cursor:pointer;
transition:0.3s;
font-size:18px;
font-weight:500;
line-height:1.5;
background:white;
}

.payment-option:hover{

border-color:#f97316;
background:#fff7ed;

}

.payment-option input[type="radio"]{

width:20px;
height:20px;
accent-color:#f97316;
flex-shrink:0;

}

.summary-title{

font-size:26px;
font-weight:700;
margin:35px 0 25px;
}

.summary-row{

display:flex;
justify-content:space-between;
margin-bottom:22px;
font-size:20px;
}

.total-row{

border-top:1px solid #d1d5db;
padding-top:25px;
margin-top:25px;
font-size:32px;
font-weight:700;
}

.button-row{

display:flex;
gap:15px;
margin-top:35px;
}

.btn{

flex:1;
padding:12px;
border:none;
border-radius:16px;
font-size:15px;
font-weight:700;
cursor:pointer;
transition:0.3s;
}

.back-btn{

background:#e5e7eb;
color:#111827;
}

.pay-btn{

background:
linear-gradient(
135deg,
#f97316,
#ea580c
);

color:white;
}

.btn:hover{

transform:translateY(-2px);
}

.loader-screen{

position:fixed;
top:0;
left:0;
width:100%;
height:100%;

background:rgba(15,23,42,0.92);

display:none;
justify-content:center;
align-items:center;
flex-direction:column;

z-index:999;
}

.loader{

width:70px;
height:70px;

border:6px solid #334155;
border-top:6px solid #f97316;

border-radius:50%;

animation:spin 1s linear infinite;

margin-bottom:25px;
}

@keyframes spin{

100%{
transform:rotate(360deg);
}

}

.loader-text{

font-size:26px;
font-weight:700;
color:white;
}

@media(max-width:1100px){

.layout{
grid-template-columns:1fr;
}

.info-grid{
grid-template-columns:repeat(2,1fr);
gap:20px;
}

.passenger-grid{
grid-template-columns:1fr;
}

}

@media(max-width:700px){

.time-grid{
grid-template-columns:1fr;
gap:20px;
text-align:center;
margin-bottom:20px;
}

.time-box:first-child,
.time-box:last-child{

align-items:center;
text-align:center;
}

.duration-wrapper{
min-width:100%;
}

.info-grid{
grid-template-columns:1fr;
gap:25px;
}

.steps{
gap:25px;
flex-wrap:wrap;
}

}

</style>

</head>

<body>

<div class="loader-screen" id="loaderScreen">

<div class="loader"></div>

<div class="loader-text" id="loaderText">
Processing Payment...
</div>

</div>

<div class="container">

<div class="steps">

<div class="step active">
<div class="circle">1</div>
<span>Passenger Details</span>
</div>

<div class="step active">
<div class="circle">2</div>
<span>Review Journey</span>
</div>

<div class="step active">
<div class="circle">3</div>
<span>Payment</span>
</div>

<div class="step">
<div class="circle">4</div>
<span>Ticket</span>
</div>

</div>

<div class="layout">

<!-- LEFT -->

<div>

<div class="card">

<h1 class="train-name">
<?php echo $train_name; ?>
(<?php echo $train_no; ?>)
</h1>

<div class="time-grid">

<div class="time-box">

<h1>
<?php echo date("H:i",strtotime($departure)); ?>
</h1>

<p>
<?php echo $source; ?>
</p>

</div>

<div class="duration-wrapper">

<div class="duration-line"></div>

<div class="duration-text">
<?php echo $duration; ?>
</div>

<div class="duration-line"></div>

</div>

<div class="time-box">

<h1>
<?php echo date("H:i",strtotime($arrival)); ?>
</h1>

<p>
<?php echo $destination; ?>
</p>

</div>

</div>

<div class="info-grid">

<div class="info-box">

<span>Journey Date</span>

<h3>
<?php echo date("D, d M Y",strtotime($date)); ?>
</h3>

</div>

<div class="info-box">

<span>Quota</span>

<h3>GENERAL</h3>

</div>

<div class="info-box">

<span>Class</span>

<h3>
<?php echo $class; ?>
</h3>

</div>

<div class="info-box">

<span>Passengers</span>

<h3>
<?php echo $passenger_count; ?>
</h3>

</div>

</div>

</div>

<h1 class="section-title">
Passenger Details
</h1>

<?php

for($i=0; $i<$passenger_count; $i++){

?>

<div class="passenger-card">

<h2 class="passenger-title">
Passenger <?php echo $i+1; ?>
</h2>

<div class="passenger-grid">

<div class="detail">
<span>Name</span>
<h4><?php echo $names[$i] ?? ''; ?></h4>
</div>

<div class="detail">
<span>Age</span>
<h4><?php echo $ages[$i] ?? ''; ?></h4>
</div>

<div class="detail">
<span>Gender</span>
<h4><?php echo $genders[$i] ?? ''; ?></h4>
</div>

<div class="detail">
<span>Nationality</span>
<h4><?php echo $nationalities[$i] ?? 'Indian'; ?></h4>
</div>

<div class="detail">
<span>Berth</span>
<h4><?php echo $berths[$i] ?? ''; ?></h4>
</div>

<div class="detail">
<span>Mobile</span>
<h4>
<?php
echo htmlspecialchars($mobiles[$i] ?? '');
?>
</h4>
</div>

<div class="detail">
<span>Email</span>
<h4>
<?php
echo htmlspecialchars($emails[$i] ?? '');
?>
</h4>
</div>

</div>

</div>

<?php } ?>

</div>

<!-- RIGHT -->

<div>

<div class="card">

<form
id="paymentForm"
action="ticket.php"
method="POST">

<?php foreach($_POST as $key => $value){ ?>

<?php if(is_array($value)){ ?>

<?php foreach($value as $v){ ?>

<input
type="hidden"
name="<?php echo $key; ?>[]"
value="<?php echo htmlspecialchars($v); ?>">

<?php } ?>

<?php } else { ?>

<input
type="hidden"
name="<?php echo $key; ?>"
value="<?php echo htmlspecialchars($value); ?>">

<?php } ?>

<?php } ?>

<input
type="hidden"
name="total_fare"
id="hiddenTotalFare"
value="<?php echo $total_fare; ?>">

<h1 class="payment-title">
Payment Method
</h1>

<label class="payment-option">

<input
type="radio"
name="payment_method"
value="UPI"
checked
onclick="updatePayment(20)">
<span>
UPI / Wallet / Net Banking
</span>

</label>

<label class="payment-option">

<input
type="radio"
name="payment_method"
value="CARD"
onclick="updatePayment(40)">
<span>
Debit / Credit Card
</span>

</label>

<div class="summary-title">
Fare Summary
</div>

<div class="summary-row">

<span>Base Fare</span>

<span>
₹<?php echo $base_fare; ?>
</span>

</div>

<div class="summary-row">

<span>Convenience Fee</span>

<span id="convFee">
₹20
</span>

</div>

<div class="summary-row">

<span>GST</span>

<span>₹30</span>

</div>

<div class="summary-row total-row">

<span>Total Fare</span>

<span id="totalFare">
₹<?php echo $total_fare; ?>
</span>

</div>

<div class="button-row">

<button
type="button"
class="btn back-btn"
onclick="history.back()">

Back

</button>

<button
type="submit"
name="pay_now"
class="btn pay-btn">

Pay & Book

</button>

</div>

</form>

</div>

</div>

</div>

</div>

<script>

function updatePayment(fee){

let baseFare =
<?php echo $base_fare; ?>;

let gst = 30;

let total =
baseFare +
fee +
gst;

document
.getElementById("convFee")
.innerHTML = "₹" + fee;

document
.getElementById("totalFare")
.innerHTML = "₹" + total;

document
.getElementById("hiddenTotalFare")
.value = total;

}

document
.getElementById("paymentForm")
.addEventListener("submit",function(e){

e.preventDefault();

document
.getElementById("loaderScreen")
.style.display = "flex";

let texts = [

"Connecting to Bank...",
"Verifying Payment...",
"Generating Ticket...",
"Booking Confirmed..."

];

let i = 0;

let interval = setInterval(()=>{

document
.getElementById("loaderText")
.innerHTML = texts[i];

i++;

if(i >= texts.length){

clearInterval(interval);

setTimeout(()=>{

this.submit();

},1000);

}

},1500);

});

</script>

</body>
</html>