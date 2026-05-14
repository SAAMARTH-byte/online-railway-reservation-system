<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PrimeRail Contact</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f4f7fb;
    color:#222;
}

/* NAVBAR */

.navbar{
    width:100%;
    background:#111827;
    padding:18px 50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    color:#ff7b00;
    font-size:28px;
    font-weight:700;
}

.nav-links{
    display:flex;
    gap:35px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-weight:500;
    transition:0.3s;
}

.nav-links a:hover{
    color:#ff7b00;
}

/* HERO */

.hero{
    width:100%;
    padding:60px 8%;
    background:linear-gradient(to right,#111827,#1e3a8a);
    color:white;
}

.hero h1{
    font-size:48px;
    margin-bottom:10px;
}

.hero p{
    font-size:18px;
    opacity:0.9;
}

/* CONTACT SECTION */

.contact-container{
    width:90%;
    margin:50px auto;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:30px;
}

/* LEFT SIDE */

.contact-info{
    display:flex;
    flex-direction:column;
    gap:25px;
}

.contact-card{
    background:white;
    padding:28px;
    border-radius:18px;
    box-shadow:0 4px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.contact-card:hover{
    transform:translateY(-5px);
}

.contact-card h3{
    margin-bottom:12px;
    color:#111827;
}

.contact-card p{
    color:#555;
    line-height:1.7;
}

/* FORM */

.contact-form{
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 4px 18px rgba(0,0,0,0.08);
}

.contact-form h2{
    margin-bottom:20px;
    color:#111827;
}

.input-box{
    margin-bottom:20px;
}

.input-box input,
.input-box textarea{
    width:100%;
    padding:15px;
    border:1px solid #dcdcdc;
    border-radius:12px;
    outline:none;
    font-size:15px;
}

.input-box textarea{
    resize:none;
    height:140px;
}

.contact-form button{
    width:100%;
    padding:15px;
    border:none;
    background:#ff7b00;
    color:white;
    font-size:16px;
    border-radius:12px;
    cursor:pointer;
    font-weight:600;
    transition:0.3s;
}

.contact-form button:hover{
    background:#e66a00;
}

/* FOOTER */

.footer{
    margin-top:50px;
    background:#111827;
    color:white;
    text-align:center;
    padding:25px;
}

.footer p{
    opacity:0.8;
}

/* RESPONSIVE */

@media(max-width:900px){

.contact-container{
    grid-template-columns:1fr;
}

.hero h1{
    font-size:34px;
}

.navbar{
    flex-direction:column;
    gap:20px;
}

.nav-links{
    flex-wrap:wrap;
    justify-content:center;
}

}

</style>
</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">PrimeRail</div>

    <div class="nav-links">
        <a href="home.php">HOME</a>
        <a href="train_route.php">TRAINS</a>
        <a href="pnr.php">PNR STATUS</a>
        <a href="mybook.php">MY BOOKINGS</a>
        <a href="contact.php">CONTACT</a>
    </div>

</div>

<!-- HERO -->

<div class="hero">

    <h1>Contact PrimeRail</h1>

    <p>
        We are here to help you with bookings, train enquiries and technical support.
    </p>

</div>

<!-- CONTACT SECTION -->

<div class="contact-container">

    <!-- LEFT -->

    <div class="contact-info">

        <div class="contact-card">
            <h3>Customer Support</h3>

            <p>Email: loyaltyprogram@PrimeRail.co.in</p>
            <p>Phone: +91 9876543210</p>
            <p>Availability: 24×7 Support</p>
        </div>

        <div class="contact-card">
            <h3>Booking Assistance</h3>

            <p>
                Need help with ticket booking, cancellations,
                refunds or payment issues?
            </p>

            <p>
                Our support team is available anytime to assist you.
            </p>
        </div>

        <div class="contact-card">
            <h3>Train Enquiry</h3>

            <p>
                Check train schedules, route timelines,
                platform numbers and coach positions instantly.
            </p>
        </div>

        <div class="contact-card">
            <h3>Head Office</h3>

            <p>
                PrimeRail Railway Services<br>
             711, Raipur, Chhattisgarh, India
            </p>
        </div>

    </div>

    <!-- RIGHT -->

    <div class="contact-form">

        <h2>Send Message</h2>

        <form id="contactForm">

            <div class="input-box">
                <input type="text" id="name" placeholder="Your Name" required>
            </div>

            <div class="input-box">
                <input type="email" id="email" placeholder="Your Email" required>
            </div>

            <div class="input-box">
                <input type="text" id="subject" placeholder="Subject" required>
            </div>

            <div class="input-box">
                <textarea id="message" placeholder="Write your message..." required></textarea>
            </div>

            <button type="submit">Send Message</button>

        </form>

    </div>

</div>

<!-- FOOTER -->

<div class="footer">

    <p>
        PrimeRail is a railway reservation and management system project inspired by modern railway platforms.
    </p>

</div>

<!-- JAVASCRIPT -->

<script>

document.getElementById("contactForm").addEventListener("submit", function(e){

    e.preventDefault();

    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let subject = document.getElementById("subject").value;
    let message = document.getElementById("message").value;

    if(name == "" || email == "" || subject == "" || message == ""){
        alert("Please fill all fields");
        return;
    }

    alert("Message Sent Successfully!");

    document.getElementById("contactForm").reset();

});

</script>

</body>
</html>