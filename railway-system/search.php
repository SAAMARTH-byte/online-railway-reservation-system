<?php

include 'config/db.php';

$source = $_GET['source'] ?? '';
$destination = $_GET['destination'] ?? '';
$date = $_GET['date'] ?? date('Y-m-d');

$query = "SELECT * FROM trains
WHERE source='$source'
AND destination='$destination'";

$result = mysqli_query($conn, $query);

$classes = ['2S','SL','CC','3E','3A','2A','1A','EC','EA','VS','VC','EV'];

?>

<!DOCTYPE html>
<html>

<head>

<title>PrimeRail Search</title>

<style>

body{
    margin:0;
    padding:30px;
    background:#f3f4f6;
    font-family:Arial;
}

/* PAGE */

.page-title{
    width:85%;
    margin:auto;
    margin-bottom:20px;
    color:#111827;
    font-size:42px;
}

/* TRAIN CARD */

.train-card{
    width:85%;
    margin:20px auto;
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
}

/* HEADER */

.train-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.train-name{
    margin:0;
    font-size:25px;
    color:#111827;
}

/* JOURNEY */

.journey-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:40px;
    gap:20px;
}

.station-box h1{
    margin:0;
    font-size:35px;
    color:#111827;
}

.station-box p{
    margin-top:8px;
    margin-bottom:10px;
    color:#6b7280;
    font-size:20px;
    font-weight:bold;
}

.station-box span{
    color:#9ca3af;
    font-size:15px;
}

.duration-box{
    width:320px;
    display:flex;
    align-items:center;
    gap:15px;
}

.duration-line{
    flex:1;
    height:2px;
    background:#d1d5db;
}

.duration-time{
    font-weight:bold;
    color:#6b7280;
    font-size:18px;
}

.arrival-section{

display:flex;
flex-direction:column;
align-items:center;
gap:14px;
}

.run-days{

display:flex;
justify-content:center;
gap:12px;

color:#6b7280;
letter-spacing:3px;
font-weight:bold;
}

/* CLASS */

.class-row{
    display:flex;
    gap:14px;
    margin-top:40px;
    flex-wrap:wrap;
}

.class-card{
    background:#f9fafb;
    border:1px solid #e5e7eb;
    padding:16px;
    border-radius:14px;
    min-width:100px;
    cursor:pointer;
    transition:0.3s;
}

.class-card:hover{
    border-color:#f97316;
    background:#fff7ed;
    transform:translateY(-3px);
}

.class-card.selected{
    border:2px solid #f97316;
    background:#fff7ed;
}

.class-card h3{
    margin:0;
    font-size:20px;
}

.class-details{
    margin-top:12px;
}

.class-details p{
    color:green;
    margin:0;
    font-weight:bold;
}

.class-details span{
    display:block;
    margin-top:6px;
    font-size:18px;
    font-weight:bold;
}

/* BOOK */

.booking-section{
    display:flex;
    align-items:center;
    gap:24px;
    margin-top:40px;
}

.price-tag{
    font-size:34px;
    font-weight:bold;
    color:#111827;
}

.book-btn{
    background:#f97316;
    color:white;
    border:none;
    padding:16px 34px;
    border-radius:12px;
    cursor:pointer;
    font-size:17px;
    font-weight:bold;
    transition:0.3s;
}

.book-btn:hover{
    background:#ea580c;
    transform:translateY(-2px);
}

/* NO TRAIN */

.no-train{
    width:85%;
    margin:auto;
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    font-size:24px;
    color:red;
}

.result-container{
    max-width:1100px;
    margin:auto;
}

/* LOADER */

.booking-loader{

position:fixed;
top:0;
left:0;

width:100%;
height:100%;

background:
rgba(15,23,42,0.72);

backdrop-filter:blur(14px);

display:flex;
justify-content:center;
align-items:center;

z-index:99999;

opacity:0;
visibility:hidden;

transition:0.4s;
}

.booking-loader.active{

opacity:1;
visibility:visible;
}

.loader-card{

width:430px;

padding:45px;

background:white;

border-radius:32px;

text-align:center;

box-shadow:
0 20px 60px rgba(0,0,0,0.2);
}

.loader-line{

width:100%;
height:6px;

background:#e5e7eb;

border-radius:20px;

overflow:hidden;

margin-bottom:35px;
}

.moving-loader{

width:120px;
height:100%;

background:
linear-gradient(
90deg,
#f97316,
#ea580c
);

border-radius:20px;

animation:moveLoader 1.2s infinite linear;
}

@keyframes moveLoader{

0%{
transform:translateX(-120px);
}

100%{
transform:translateX(430px);
}

}

.loader-card h1{

margin:0;

font-size:34px;
color:#111827;
}

.loader-card p{

margin-top:14px;

font-size:18px;

color:#6b7280;
}

</style>

</head>

<body>

<!-- LOADER -->

<div class="booking-loader" id="bookingLoader">

    <div class="loader-card">

        <div class="loader-line">

            <div class="moving-loader"></div>

        </div>

        <h1>
            Preparing Journey
        </h1>

        <p id="loaderText">
            Checking seat availability...
        </p>

    </div>

</div>

<!-- TITLE -->

<h1 class="page-title">
PrimeRail Search Results
</h1>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<div class="train-card">

<!-- HEADER -->

<div class="train-header">

<div>

<h2 class="train-name">
<?php echo $row['train_name']; ?>
(<?php echo $row['train_number']; ?>)
</h2>

</div>

</div>

<!-- JOURNEY -->

<div class="journey-row">

<!-- LEFT -->

<div class="station-box">

<h1>
<?php echo date("H:i", strtotime($row['departure_time'])); ?>
</h1>

<p>
<?php echo strtoupper($row['source']); ?>
</p>

<span>
<?php echo date("D, d M", strtotime($date)); ?>
</span>

</div>

<!-- CENTER -->

<div class="duration-box">

<div class="duration-line"></div>

<div class="duration-time">
<?php echo $row['duration']; ?>
</div>

<div class="duration-line"></div>

</div>

<!-- RIGHT -->

<div class="arrival-section">

<div class="run-days">
M T W T F S S
</div>

<div class="station-box" style="text-align:right;">

<h1>
<?php echo date("H:i", strtotime($row['arrival_time'])); ?>
</h1>

<p>
<?php echo strtoupper($row['destination']); ?>
</p>

<span>
<?php echo date("D, d M", strtotime($date . " +1 day")); ?>
</span>

</div>

</div>

</div>

<!-- CLASS -->

<div class="class-row">

<?php

$defaultFare = 0;
$defaultClass = '';

foreach($classes as $class){

    $fareColumn = "fare_" . $class;
    $classColumn = "class_" . $class;

    if(!empty($row[$fareColumn])){

        if($defaultFare == 0){
            $defaultFare = $row[$fareColumn];
            $defaultClass = $class;
        }

?>

<div class="class-card"

onclick="selectClass(
this,
'<?php echo $class; ?>',
'<?php echo $row[$fareColumn]; ?>',
'bookLink<?php echo $row['train_number']; ?>',
'fare<?php echo $row['train_number']; ?>'
)">

<h3>
<?php echo $class; ?>
</h3>

<div class="class-details">

<p>

<?php

$available = rand(12,120);

echo $available;

?>

</p>

<span>
₹<?php echo $row[$fareColumn]; ?>
</span>

</div>

</div>

<?php
    }
}
?>

</div>

<!-- BOOK -->

<div class="booking-section">

<a
id="bookLink<?php echo $row['train_number']; ?>"
href="mybooking.php?
train=<?php echo $row['train_number']; ?>
&class=<?php echo $defaultClass; ?>
&date=<?php echo $date; ?>"
>

<button class="book-btn">
Book Now
</button>

</a>

<span
class="price-tag"
id="fare<?php echo $row['train_number']; ?>"
>
₹<?php echo $defaultFare; ?>
</span>

</div>

</div>

<?php

}

}else{

?>

<div class="no-train">
No Trains Found
</div>

<?php
}
?>

<script>

function selectClass(card, trainClass, fare, linkId, fareId){

    let parent = card.parentElement;

    parent.querySelectorAll('.class-card').forEach(c => {
        c.classList.remove('selected');
    });

    card.classList.add('selected');

    document.getElementById(fareId).innerText =
    "₹" + fare;

    let bookLink =
    document.getElementById(linkId);

    let url =
    new URL(bookLink.href);

    url.searchParams.set(
    "class",
    trainClass
    );

    bookLink.href =
    url.toString();
}

/* LOADER */

const loaderTexts = [

"Checking seat availability...",
"Preparing coach details...",
"Generating reservation...",
"Redirecting securely..."

];

document
.querySelectorAll(".book-btn")
.forEach(button=>{

button.addEventListener("click",function(e){

e.preventDefault();

document
.getElementById("bookingLoader")
.classList.add("active");

let i = 0;

const text =
document.getElementById("loaderText");

const interval = setInterval(()=>{

i++;

if(i < loaderTexts.length){

text.innerText =
loaderTexts[i];

}

},500);

const link =
this.parentElement.href;

setTimeout(()=>{

window.location.href = link;

},2200);

});

});

</script>

</body>
</html>