<?php

$train_name = $_POST['train_name'] ?? '';

$train_no = $_POST['train'] ?? '';

$source = $_POST['source'] ?? '';

$destination = $_POST['destination'] ?? '';

$class = $_POST['class'] ?? '';

$date = $_POST['date'] ?? date('Y-m-d');

$fare = $_POST['fare'] ?? 0;

$departure = $_POST['departure'] ?? '';

$arrival = $_POST['arrival'] ?? '';

$duration = $_POST['duration'] ?? '';

$payment_method = $_POST['payment_method'] ?? 'upi';

$names = $_POST['name'] ?? [];

$ages = $_POST['age'] ?? [];

$genders = $_POST['gender'] ?? [];

$nationalities = $_POST['nationality'] ?? [];

$berths = $_POST['berth'] ?? [];

$mobiles = $_POST['mobile'] ?? [];

$emails = $_POST['email'] ?? [];

$passenger_count = count($names);

$convenience_fee = ($payment_method == "card") ? 40 : 20;

$gst = 30;

$total_fare = $fare * $passenger_count;

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Review Journey</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{

font-family:'Poppins',sans-serif;
background:#f5f7fb;
padding:40px 20px;
color:#111827;
}

.container{
max-width:1300px;
margin:auto;
}

.steps{

display:flex;
justify-content:center;
gap:60px;
margin-bottom:40px;
flex-wrap:wrap;
}

.step{

display:flex;
align-items:center;
gap:10px;
font-weight:600;
color:#9ca3af;
}

.circle{

width:42px;
height:42px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
background:#dbeafe;
color:#1e3a8a;
font-weight:bold;
}

.active{

color:#ea580c;
}

.active .circle{

background:#f97316;
color:white;
}

.main-grid{

display:grid;
grid-template-columns:2fr 1fr;
gap:25px;
}

.card{

background:white;
border-radius:20px;
padding:30px;

box-shadow:0 6px 20px rgba(0,0,0,0.06);
}

.train-name{

font-size:28px;
font-weight:700;
margin-bottom:30px;
}

.time-grid{

display:grid;
grid-template-columns:1fr auto 1fr;
align-items:center;
gap:35px;
margin-bottom:35px;
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

font-size:25px;
font-weight:700;
line-height:1;
}

.time-box p{

margin-top:10px;
font-size:24px;
font-weight:600;
}

.duration{

display:flex;
align-items:center;
gap:15px;
min-width:250px;
}

.duration-line{

flex:1;
height:2px;
background:#d1d5db;
}

.duration h3{

font-size:20px;
color:#6b7280;
}

.info-grid{

display:grid;
grid-template-columns:1fr 1fr 1fr 1fr;
gap:20px;
padding-top:30px;
border-top:1px solid #e5e7eb;
text-align:center;
}

.info-box{

display:flex;
flex-direction:column;
align-items:center;
}

.info-box span{

font-size:15px;
color:#6b7280;
margin-bottom:8px;
}

.info-box h3{

font-size:20px;
font-weight:700;
}

.section-title{

font-size:28px;
font-weight:700;
margin:40px 0 25px;
}

.passenger-card{

background:white;
border-radius:22px;
padding:25px;
margin-bottom:25px;

box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.passenger-title{

font-size:25px;
font-weight:700;
margin-bottom:20px;
color:#f97316;
}

.passenger-grid{

display:grid;
grid-template-columns:repeat(3,1fr);
gap:20px;
}

.detail{

background:#f8fafc;
padding:18px;
border-radius:18px;
}

.detail span{

display:block;
font-size:13px;
color:#6b7280;
margin-bottom:8px;
text-transform:uppercase;
}

.detail h4{

font-size:22px;
font-weight:700;
}

.summary-card{

position:sticky;
top:20px;
padding:22px;
border-radius:20px;
width:85%;
margin:auto;
}

.summary-title{

font-size:28px;
font-weight:700;
margin-bottom:22px;
}

.summary-row{

display:flex;
justify-content:space-between;
margin-bottom:18px;
font-size:17px;
}

.total-row{

border-top:1px solid #e5e7eb;
padding-top:18px;
margin-top:18px;
font-size:24px;
font-weight:700;
}

.button-row{

display:flex;
gap:15px;
margin-top:35px;
}

.btn{

flex:1;
padding:14px;
border:none;
border-radius:14px;
font-size:16px;
font-weight:700;
cursor:pointer;
transition:0.3s;
}

.back-btn{

background:#e5e7eb;
}

.pay-btn{

background:#f97316;
color:white;
}

.pay-btn:hover{

background:#ea580c;
}

@media(max-width:1000px){

.main-grid{

grid-template-columns:1fr;
}

.passenger-grid{

grid-template-columns:1fr;
}

.info-grid{

grid-template-columns:1fr 1fr;
}

.time-grid{

grid-template-columns:1fr;
text-align:center;
}

.duration{

justify-content:center;
}

.time-box{

align-items:center !important;
text-align:center !important;
}
}

</style>

</head>

<body>

<div class="container">

<div class="steps">

<div class="step active">
<div class="circle">1</div>
Passenger Details
</div>

<div class="step active">
<div class="circle">2</div>
Review Journey
</div>

<div class="step">
<div class="circle">3</div>
Payment
</div>

<div class="step">
<div class="circle">4</div>
Ticket
</div>

</div>

<div class="main-grid">

<div>

<div class="card">

<h1 class="train-name">
<?php echo $train_name; ?> (<?php echo $train_no; ?>)
</h1>

<div class="time-grid">

<div class="time-box">

<h1><?php echo date("H:i", strtotime($departure)); ?></h1>

<p><?php echo strtoupper($source); ?></p>

</div>

<div class="duration">

<div class="duration-line"></div>

<h3><?php echo $duration; ?></h3>

<div class="duration-line"></div>

</div>

<div class="time-box">

<h1><?php echo date("H:i", strtotime($arrival)); ?></h1>

<p><?php echo strtoupper($destination); ?></p>

</div>

</div>

<div class="info-grid">

<div class="info-box">

<span>Journey Date</span>

<h3><?php echo date("D, d M Y", strtotime($date)); ?></h3>

</div>

<div class="info-box">

<span>Quota</span>

<h3>GENERAL</h3>

</div>

<div class="info-box">

<span>Class</span>

<h3><?php echo $class; ?></h3>

</div>

<div class="info-box">

<span>Passengers</span>

<h3><?php echo $passenger_count; ?></h3>

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

<h4><?php echo $names[$i]; ?></h4>

</div>

<div class="detail">

<span>Age</span>

<h4><?php echo $ages[$i]; ?></h4>

</div>

<div class="detail">

<span>Gender</span>

<h4><?php echo $genders[$i]; ?></h4>

</div>

<div class="detail">

<span>Nationality</span>

<h4><?php echo $nationalities[$i]; ?></h4>

</div>

<div class="detail">

<span>Berth</span>

<h4><?php echo $berths[$i]; ?></h4>

</div>

<div class="detail">
    <span>Mobile</span>
    <h4><?php echo $mobiles[$i]; ?></h4>
</div>

<div class="detail">
    <span>Email</span>
    <h4><?php echo $emails[$i]; ?></h4>
</div>


</div>

</div>

<?php } ?>

</div>

<div>

<div class="card summary-card">

<h1 class="summary-title">

Fare Summary

</h1>

<div class="summary-row">
<span>Train Class</span>
<span><?php echo $class; ?></span>
</div>

<div class="summary-row">
<span>Base Fare</span>
<span>₹<?php echo $fare * $passenger_count; ?></span>
</div>

<div class="summary-row total-row">
<span>Total</span>
<span>₹<?php echo $total_fare; ?></span>
</div>

<div class="button-row">
<button class="btn back-btn"
onclick="history.back()">

Back

</button>



<form action="payment.php" method="POST">
<input type="hidden" name="fare" value="<?php echo $fare; ?>">
<input type="hidden" name="train_name" value="<?php echo $train_name; ?>">
<input type="hidden" name="train_no" value="<?php echo $train_no; ?>">
<input type="hidden" name="source" value="<?php echo $source; ?>">
<input type="hidden" name="destination" value="<?php echo $destination; ?>">
<input type="hidden" name="class" value="<?php echo $class; ?>">
<input type="hidden" name="date" value="<?php echo $date; ?>">
<input type="hidden" name="departure" value="<?php echo $departure; ?>">
<input type="hidden" name="arrival" value="<?php echo $arrival; ?>">
<input type="hidden" name="duration" value="<?php echo $duration; ?>">
<input type="hidden" name="total_fare" value="<?php echo $total_fare; ?>">

<input
type="hidden"
name="base_fare"
value="<?php echo $fare * $passenger_count; ?>">

<?php

for($i = 0; $i < count($names); $i++){

?>

<input type="hidden" name="name[]" value="<?php echo $names[$i]; ?>">
<input type="hidden" name="age[]" value="<?php echo $ages[$i]; ?>">
<input type="hidden" name="gender[]" value="<?php echo $genders[$i]; ?>">
<input type="hidden" name="berth[]" value="<?php echo $berths[$i]; ?>">
<input type="hidden" name="mobile[]" value="<?php echo $mobiles[$i]; ?>">
<input type="hidden" name="email[]" value="<?php echo $emails[$i]; ?>">

<?php

}

?>

<button type="submit" class="btn pay-btn">
    Proceed Payment
</button>


</form>

</div>

</div>

</div>

</div>

</div>

<script>

console.log("Review page loaded successfully");

</script>

</body>
</html>