<?php

include("config/db.php");

$train = $_GET['train'] ?? '';

$query = "SELECT * FROM trains WHERE train_number='$train'";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$name = $row['train_name'];
$source = $row['source'];
$destination = $row['destination'];

$departure = $row['departure_time'];
$arrival = $row['arrival_time'];
$duration = $row['duration'];

$class = $_GET['class'] ?? '3A';

$fareColumn = "fare_" . $class;

if(isset($row[$fareColumn]) && !empty($row[$fareColumn])){
    $fare = $row[$fareColumn];
}else{
    $fare = 0;
}

$date = $_GET['date'] ?? date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Passenger Details</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,sans-serif;
    background:#f5f7fb;
    padding:40px;
    color:#111827;
}

.main-container{
    width:95%;
    margin:auto;
}

/* TOP PROGRESS BAR */

.top-progress{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:18px;

    margin-bottom:40px;

    padding:25px 10px;
}

/* STEP */

.progress-step{

    display:flex;

    align-items:center;

    gap:12px;

    font-size:18px;

    font-weight:600;

    color:#b8c1cc;
}

.progress-step.active{
    color:#f97316;
}

/* NUMBER */

.progress-number{

    width:44px;
    height:44px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#e5e7eb;
    font-weight:700;
    font-size:18px;
}

.progress-step.active .progress-number{

    background:#f97316;

    color:white;

    box-shadow:0 6px 15px rgba(249,115,22,0.25);
}

/* LINE */

.progress-line{

    width:40px;
    height:2px;
    background:transparent;
}

.active-line{
    background:#f97316;
}

.active-step .step-number{
    background:#f97316;
}

.booking-layout{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
}

.left-section{
    display:flex;
    flex-direction:column;
    gap:25px;
}

.card{
    background:white;
    border-radius:18px;
    padding:20px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.train-name{
    font-size:28px;
    font-weight:bold;
}

.route{
    margin-top:8px;
    color:#6b7280;
}

.time-row{
    margin-top:30px;
    display:grid;
    grid-template-columns:1fr auto 1fr;
    align-items:center;
    gap:40px;
}

.station{
    display:flex;
    flex-direction:column;
}

.station:first-child{
    align-items:flex-start;
    text-align:left;
}

.station:last-child{
    align-items:flex-end;
    text-align:right;
}

.station h1{
    font-size:30px;
    font-weight:700;
    line-height:1;
}

.station p{
    margin-top:10px;
    font-size:24px;
    font-weight:600;
    color:#111827;

}

.center-duration{
    display:flex;
    align-items:center;
    gap:15px;
    width:220px;
}

.line{
    flex:1;
    height:2px;
    background:#d1d5db;
}

.duration{
    font-weight:bold;
    color:#6b7280;
}

.journey-info{
    margin-top:30px;
    display:grid;
    grid-template-columns: 1fr  1fr  1fr;
    justify-content:space-between;
    border-top:1px solid #e5e7eb;
    padding-top:25px;
    gap:20px;
    text-align:center;
}

.section-title{
    font-size:34px;
    font-weight:bold;
    margin-bottom:30px;
}

.passenger-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.add-btn{
    background:#f97316;
    color:white;
    border:none;
    padding:14px 20px;
    border-radius:12px;
    cursor:pointer;
    font-weight:bold;
}

.passenger-box{
    margin-bottom:20px;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:20px;
    position:relative;
}

.remove-btn{
    position:absolute;
    right:12px;
    top:12px;
    width:30px;
    height:30px;
    border:none;
    border-radius:50%;
    background:red;
    color:white;
    cursor:pointer;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.input-group input,
.input-group select{
    width:100%;
    padding:14px;
    border:1px solid #d1d5db;
    border-radius:12px;
}

.payment-option{
    border:1px solid #e5e7eb;
    padding:18px;
    border-radius:12px;
    margin-bottom:15px;
    cursor:pointer;
}

.summary-title{
    font-size:32px;
    font-weight:bold;
    margin-bottom:25px;
}

.summary-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
    font-size:18px;
}

.total-row{
    border-top:1px solid #e5e7eb;
    padding-top:20px;
    margin-top:20px;
    font-size:30px;
    font-weight:bold;
}

.book-btn{
    width:100%;
    margin-top:25px;
    background:#f97316;
    color:white;
    border:none;
    padding:18px;
    border-radius:14px;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
}

@media(max-width:1000px){

.booking-layout{
    grid-template-columns:1fr;
}

.form-grid{
    grid-template-columns:1fr;
}

}


/* BUTTON */

.continue-btn{
    width:100%;
    padding:16px;
    border:none;
    border-radius:14px;

    background:#f97316;
    color:white;

    font-size:17px;
    font-weight:600;

    cursor:pointer;
    transition:0.3s;
}

.continue-btn:hover{
    background:#ea580c;
}

/* OVERLAY */

.booking-overlay{
    position:fixed;
    inset:0;

    background:rgba(15,23,42,0.72);

    display:none;
    justify-content:center;
    align-items:center;

    z-index:9999;

    backdrop-filter:blur(6px);
}

/* MODAL */

.booking-modal{
    width:460px;

    background:white;

    border-radius:28px;

    padding:40px;

    box-shadow:0 20px 60px rgba(0,0,0,0.25);

    animation:fadeUp 0.35s ease;
}

/* LOADER */

.loader-circle{
    width:72px;
    height:72px;

    margin:auto;

    border-radius:50%;

    border:4px solid #e5e7eb;
    border-top:4px solid #f97316;

    animation:spin 1s linear infinite;

    display:flex;
    justify-content:center;
    align-items:center;
}

.loader-inner{
    width:14px;
    height:14px;

    background:#f97316;
    border-radius:50%;
}

/* TEXT */

.booking-modal h2{
    margin-top:25px;
    text-align:center;

    font-size:28px;
    color:#111827;
}

.booking-modal p{
    margin-top:12px;
    text-align:center;

    color:#6b7280;
    line-height:1.7;
}

/* STATUS */

.booking-status{
    margin-top:35px;
}

.status-row{
    display:flex;
    align-items:center;

    gap:14px;

    margin-bottom:18px;

    color:#9ca3af;

    font-weight:500;

    transition:0.3s;
}

.status-row.active{
    color:#111827;
}

.dot{
    width:12px;
    height:12px;

    border-radius:50%;

    background:#d1d5db;
}

.status-row.active .dot{
    background:#f97316;
}

/* PROGRESS */

.progress-container{
    width:100%;
    height:10px;

    background:#f3f4f6;

    border-radius:30px;

    overflow:hidden;

    margin-top:30px;
}

.progress-bar{
    width:0%;
    height:100%;

    background:linear-gradient(to right,#f97316,#fb923c);

    transition:width 1s linear;
}

/* ANIMATION */

@keyframes spin{

    100%{
        transform:rotate(360deg);
    }

}

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

</style>

</head>

<body>

<div class="main-container">

<div class="top-progress">

    <div class="progress-step active">
        <div class="progress-number">1</div>
        <span>Passenger Details</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step ">
        <div class="progress-number">2</div>
        <span>Review Journey</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step">
        <div class="progress-number">3</div>
        <span>Payment</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step">
        <div class="progress-number">4</div>
        <span>Ticket</span>
    </div>

</div>

<form id ="bookingForm" action="review.php" method="POST">

<input type="hidden" name="train" value="<?php echo $train; ?>">
<input type="hidden" name="train_name" value="<?php echo $name; ?>">
<input type="hidden" name="source" value="<?php echo $source; ?>">
<input type="hidden" name="destination" value="<?php echo $destination; ?>">
<input type="hidden" name="class" value="<?php echo $class; ?>">
<input type="hidden" name="fare" value="<?php echo $fare; ?>">
<input type="hidden" name="date" value="<?php echo $date; ?>">
<input type="hidden" name="departure" value="<?php echo $departure; ?>">
<input type="hidden" name="arrival" value="<?php echo $arrival; ?>">
<input type="hidden" name="duration" value="<?php echo $duration; ?>">

<div class="booking-layout">

<div class="left-section">

<div class="card">

<div class="train-name">
<?php echo $name; ?> (<?php echo $train; ?>)
</div>

<div class="time-row">

<div class="station">
<h1><?php echo date("H:i", strtotime($departure)); ?></h1>
<p><?php echo $source; ?></p>
</div>

<div class="center-duration">
<div class="line"></div>
<div class="duration"><?php echo $duration; ?></div>
<div class="line"></div>
</div>

<div class="station">
<h1><?php echo date("H:i", strtotime($arrival)); ?></h1>
<p><?php echo $destination; ?></p>
</div>

</div>

<div class="journey-info">

<div>
<span>Journey Date</span>
<h3><?php echo date("D, d M Y", strtotime($date)); ?></h3>
</div>

<div>
<span>Quota</span>
<h3>GENERAL</h3>
</div>

<div>
<span>Class</span>
<h3><?php echo $class; ?></h3>
</div>

</div>

</div>

<div class="card">

<div class="section-title">
Passenger Details
</div>

<div class="passenger-top">

<h2>Add Passenger</h2>

<button type="button" class="add-btn" onclick="addPassenger()">
+ Add Passenger
</button>

</div>

<div id="passengerContainer">

<div class="passenger-box">

<button type="button"
class="remove-btn"
onclick="removePassenger(this)">
✖
</button>

<div class="form-grid">

<div class="input-group">
<label>Passenger Name</label>
<input type="text" name="name[]" required>
</div>

<div class="input-group">
<label>Age</label>
<input type="number" name="age[]" required>
</div>

<div class="input-group">
<label>Gender</label>
<select name="gender[]" required>
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
<option>Transgender</option>
</select>
</div>

<div class="input-group">
<label>Nationality</label>
<select name="nationality[]">
<option>India</option>
<option>United States</option>
<option>United Kingdom</option>
</select>
</div>

<div class="input-group">
<label>Berth Preference</label>
<select name="berth[]">
<option>No Preference</option>
<option>Lower</option>
<option>Middle</option>
<option>Upper</option>
<option>Side Lower</option>
<option>Side Upper</option>
<option>Window Seat </option>
<option>Middle Seat</option>
<option>Aisle Seat</option>
</select>
</div>

<div class="input-group">
<label>Mobile Number</label>
<input type="text" name="mobile[]" required>
</div>

<div class="input-group">
<label>Email Address</label>
<input type="email" name="email[]" required>
</div>

</div>

</div>

</div>

</div>


</div>

<div class="right-section">

<div class="card">

<div class="summary-title">
Fare Summary
</div>

<div class="summary-row">
<span>Train Class</span>
<span><?php echo $class; ?></span>
</div>

<div class="summary-row">
<span>Base Fare</span>
<span>₹<?php echo $fare; ?></span>
</div>

<div class="summary-row total-row">
<span>Total</span>
<span>₹<span id="totalFare"><?php echo $fare; ?></span></span>
</div>

<!-- CONTINUE BUTTON -->

<button type="button" id="continueBtn" class="continue-btn">
    Continue Booking
</button>

<!-- BOOKING OVERLAY -->

<div id="bookingOverlay" class="booking-overlay">

    <div class="booking-modal">

        <!-- TOP ICON -->

        <div class="loader-circle">
            <div class="loader-inner"></div>
        </div>

        <!-- TEXT -->

        <h2>Confirming Your Journey</h2>

        <p>
            PrimeRail is securely processing your booking and reserving seats.
        </p>

        <!-- STATUS -->

        <div class="booking-status">

            <div class="status-row active">
                <span class="dot"></span>
                Validating Passenger Details
            </div>

            <div class="status-row" id="status2">
                <span class="dot"></span>
                Checking Seat Availability
            </div>

            <div class="status-row" id="status3">
                <span class="dot"></span>
                Redirecting to Payment Gateway
            </div>

        </div>

        <!-- PROGRESS -->

        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>

    </div>

</div>

</div>

</div>

</div>

</form>

</div>

<script>

function addPassenger(){

    let passengerHTML = `

    <div class="passenger-box">

    <button type="button"
    class="remove-btn"
    onclick="removePassenger(this)">
    ✖
    </button>

    <div class="form-grid">

    <div class="input-group">
    <label>Passenger Name</label>
    <input type="text" name="name[]" required>
    </div>

    <div class="input-group">
    <label>Age</label>
    <input type="number" name="age[]" required>
    </div>

    <div class="input-group">
    <label>Gender</label>
    <select name="gender[]" required>
    <option value="">Select Gender</option>
    <option>Male</option>
    <option>Female</option>
    <option>Transgender</option>
    </select>
    </div>

  
    <div class="input-group">
    <label>Nationality</label>
    <select name="nationality[]">
    <option>India</option>
    </select>
    </div>

    <div class="input-group">
    <label>Berth Preference</label>
    <select name="berth[]">
    <option>No Preference</option>
    <option>Lower</option>
    <option>Middle</option>
    <option>Upper</option>
    <option>Side Lower</option>
    <option>Side Upper</option>
    <option>Window Seat </option>
    <option>Middle Seat</option>
    <option>Aisle Seat</option>
    </select>
    </div>

    <div class="input-group">
    <label>Mobile Number</label>
    <input type="text" name="mobile[]" required>
    </div>

    <div class="input-group">
    <label>Email Address</label>
    <input type="email" name="email[]" required>
    </div>

    </div>

    </div>

    `;

    document.getElementById("passengerContainer")
    .insertAdjacentHTML("beforeend", passengerHTML);
}

function removePassenger(button){
    button.parentElement.remove();
}

function updateFare(fee){

    let baseFare = <?php echo $fare; ?>;

    document.getElementById("convFee").style.display ="none";

    let total = parseInt(baseFare);

    document.getElementById("totalFare").innerText = total;
}


const bookingForm = document.getElementById("bookingForm");
const continueBtn = document.getElementById("continueBtn");

const overlay = document.getElementById("bookingOverlay");
const progressBar = document.getElementById("progressBar");

continueBtn.addEventListener("click", function (e) {

    e.preventDefault();

    // Check form validity first
    if (!bookingForm.checkValidity()) {
        bookingForm.reportValidity();
        return;
    }

    // Show animation
    overlay.style.display = "flex";

    progressBar.style.width = "30%";

    setTimeout(() => {

        document.getElementById("status2").classList.add("active");
        progressBar.style.width = "65%";

    }, 1500);

    setTimeout(() => {

        document.getElementById("status3").classList.add("active");
        progressBar.style.width = "100%";

    }, 3000);

    // Submit form after animation
    setTimeout(() => {

        bookingForm.submit();

    }, 4800);

});

</script>

</body>
</html>