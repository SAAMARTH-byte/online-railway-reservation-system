<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PrimeRail</title>


<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f4f6f9;
}

/* ===== NAVBAR ===== */
.navbar {
    background: #0b1f3a;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 50px;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
}

.logo span {
    color: orange;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-size: 14px;
}

.nav-links a:hover {
    color: orange;
}

/* NAV LOGIN BUTTON */
.nav-login-btn {
    background: linear-gradient(45deg, orange, darkorange);
    border: none;
    padding: 8px 18px;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.nav-login-btn:hover {
    transform: scale(1.05);
}

/* ===== HERO ===== */
.hero {
    height: 650px;
    display: flex;
    align-items: center;
    padding-left: 700px;
    color: white;

    background: linear-gradient(to right, rgba(0, 0, 0, 0), rgb(0, 0, 0)),
    url('htdocs/railway-system/images/vande bharat.webp');

    background-size: cover;
    background-position: center;
}

.hero h1 {
    font-size: 48px;
}

.hero span {
    color: orange;
}

/* ===== BOOKING ===== */
.booking-box {
    .booking-box 
    width: 85%;
    margin: -50px auto 20px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;

    background: #0b1f3a;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);

    flex-wrap: nowrap; /*force one line */
}

/* FROM & TO */
.input-box {
    flex: 1; /* bigger */
    position: center;
}

/* DATE + SELECT */
.booking-box input[type="date"],
.booking-box select {
    flex: 1; /* smaller */
}

/* ALL INPUTS */
.booking-box input,
.booking-box select {
    width: 85%;
    padding: 12px;
    border-radius: 6px;
    border: none;
}

/* SWAP BUTTON */
.swap-btn {
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: 0.2s;
}

.swap-btn:hover {
    transform: rotate(180deg);
    background: orange;
    color: white;

}


.booking-box input,
.booking-box select {
    flex: 1;
    padding: 12px;
    border-radius: 6px;
    border: none;
}

.booking-box button {
    background: orange;
    border: none;
    padding: 12px 10px;
    color: white;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
}

.booking-box button:hover {
    background: darkorange;
}

/* ===== FEATURES ===== */
.features {
    width: 90%;
    margin: 40px auto;
    display: flex;
    gap: 20px;
}

.feature {
    flex: 1;
    background: white;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
}

/* ===== MODAL ===== */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-box {
    background: white;
    width: 350px;
    padding: 25px;
    border-radius: 10px;
    position: relative;
}

.modal-box h3 {
    text-align: center;
    margin-bottom: 15px;
}

.input-box {
    margin-bottom: 12px;
}

.input-box input {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* SIGN IN BUTTON */
.signin-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg,#ff6b00,#ff3c00);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

/* BUTTON GROUP */
.btn-group {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

/* REGISTER BUTTON */
.register-btn {
    flex: 1;
    padding: 12px;
    background: linear-gradient(135deg,#2563eb,#1e40af);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

/* AGENT BUTTON */
.agent-btn {
    flex: 1;
    padding: 12px;
    background: #0f172a;
    color: white;
    border: none;
    border-radius: 8px;
}

/* CLOSE */
.close {
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
}

.input-box {
    position: relative;
}

.dropdown {
    position: absolute;
    background: #fff;
    width: 100%;
    max-height: 150px;
    overflow-y: auto;
    z-index: 1000;

    border: none; /* 🔥 removed line */
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.item {
    padding: 10px;
    cursor: pointer;
}

.item:hover {
    background: #f1f1f1;
}


</style>
</head>


<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">
        <img src="htdocs/railway-system/images/indian railway logo.webp">
        <h2>Prime<span>Rail</span></h2>
    </div>

    <div class="nav-links">
        <a href="#">HOME</a>
        <a href="#">TRAINS</a>
        <a href="#">PNR STATUS</a>
        <a href="#">MY BOOKINGS</a>
        <a href="#">CONTACT</a>

        <span style="margin-left:20px; color:white;">
            Welcome <?php echo $_SESSION['username']; ?>
        </span>


        <button class="nav-login-btn" onclick="openLogin()">LOGIN</button>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <div>
        <h1>Welcome to Prime<span>Rail</span></h1>
        <h2>Your Journey, Our Priority</h2>
        <p>Book train tickets easily, manage your bookings and enjoy a smooth travel experience with Prime Rail.</p>
    </div>
</div>

<!-- BOOKING -->
<form action="search.php" method="GET" class="booking-box">

    <form action="search.php" method="GET">

    <!-- FROM -->
    <div class="input-group">
        <input type="text" id="fromInput" placeholder="From" autocomplete="off">
        <input type="hidden" id="fromCode" name="source">
        <div id="fromList" class="dropdown"></div>
    </div>

    <!-- TO -->
    <div class="input-group">
        <input type="text" id="toInput" placeholder="To" autocomplete="off">
        <input type="hidden" id="toCode" name="destination">
        <div id="toList" class="dropdown"></div>
    </div>


    <input type="date" name="date" required>

    <!-- CLASS -->
    <select name="class">
        <option value="ALL">All Classes</option>
        <option value="EA">Anubhuti Class (EA)</option>
        <option value="1A">AC First Class (1A)</option>
        <option value="2A">AC 2 Tier (2A)</option>
        <option value="3A">AC 3 Tier (3A)</option>
        <option value="CC">AC Chair Car (CC)</option>
        <option value="3E">AC 3 Economy (3E)</option>
        <option value="EC">Exec. Chair Car (EC)</option>
        <option value="SL">Sleeper (SL)</option>
        <option value="FC">First Class (FC)</option>
        <option value="2S">Second Sitting (2S)</option>
        <option value="VS">Vistadome Non AC (VS)</option>
        <option value="VC">Vistadome Chair Car (VC)</option>
        <option value="EV">Vistadome AC (EV)</option>
    </select>

    <!-- QUOTA -->
    <select name="quota">
        <option value="GN">General</option>
        <option value="LD">Ladies</option>
        <option value="TQ">Tatkal</option>
        <option value="SS">Lower Berth / Sr. Citizen</option>
        <option value="PT">Premium Tatkal</option>
        <option value="DP">Duty Pass</option>
    </select>

    <button type="submit">Search Train</button>

</form>

<!-- FEATURES -->
<div class="features">
    <div class="feature"><h3>🔒 Secure Booking</h3></div>
    <div class="feature"><h3>⚡ Easy Booking</h3></div>
    <div class="feature" onclick="openSupport()" style="cursor:pointer;">
    <h3>📞 24/7 Support</h3>
</div>
    <div class="feature"><h3>📱 Mobile Friendly</h3></div>
</div>

<!-- SUPPORT MODAL -->
<div class="modal" id="supportModal">
    <div class="modal-box" style="width:500px; max-height:80vh; overflow-y:auto;">

        <span class="close" onclick="closeSupport()">✖</span>

        <h3>📞 Customer Support</h3>

        <p><b>Dial (Within India):</b><br>
        📞 14646</p>

        <p><b>Languages:</b><br>
        Hindi, English, Punjabi, Bengali, Assamese, Odia, Marathi, Gujarati, Tamil, Telugu, Kannada, Malayalam</p>

        <p><b>Outside India:</b><br>
        📞 +91-8044647999<br>
        📞 +91-8035734999</p>

        <p><b>PrimeRail-SBI:</b><br>
        📞 0124-39021212 / 18001801295<br>
        ✉ customercare@sbicard.com</p>

        <p><b>PrimeRail-BOB:</b><br>
        📞 1800225100 / 18001031006<br>
        ✉ crm@bobfinancial.com</p>

        <p><b>PrimeRail-HDFC:</b><br>
        📞 18002026161 / 18602676161<br>
        🔗 https://www.hdfcbank.com/personal/need-help/contact-us</p>

        <p><b>PrimeRail-RBL:</b><br>
        📞 02262327777 / 02271190900<br>
        ✉ cardservices@rblbank.com</p>

        <p><b>Other Queries:</b><br>
        ✉ loyaltyprogram@PrimeRail.co.in</p>

        <p><b>Registered Office:</b><br>
        711, New Raipur, Raipur<br>
        Chhattisgarh - 49222</p>

    </div>
</div>

<!-- LOGIN MODAL -->
<div class="modal" id="loginModal">
    <div class="modal-box">

        <span class="close" onclick="closeLogin()">✖</span>

        <h3>LOGIN</h3>

        <form action="login.php" method="POST">
            <div class="input-box">
                <input type="text" name="username" placeholder="User Name" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="signin-btn">SIGN IN</button>
        </form>

        <div class="btn-group">
            <a href="register.php">
    <button class="register-btn">Register</button>
</a>
            <button class="agent-btn">Agent Login</button>
        </div>

    </div>
</div>

<script>
// ================= LOGIN =================
function openLogin(){
    document.getElementById("loginModal").style.display = "flex";
}

function closeLogin(){
    document.getElementById("loginModal").style.display = "none";
}

// ================= SUPPORT =================
function openSupport(){
    document.getElementById("supportModal").style.display = "flex";
}

function closeSupport(){
    document.getElementById("supportModal").style.display = "none";
}

// ================= AUTOCOMPLETE =================
function setupAuto(inputId, listId, hiddenId) {

    const input = document.getElementById(inputId);
    const list = document.getElementById(listId);
    const hidden = document.getElementById(hiddenId);

    input.addEventListener("input", function () {

        const value = this.value.trim();

        if (value.length < 1) {
            list.style.display = "none";
            hidden.value = "";
            return;
        }

        fetch("station_search.php?q=" + value)
            .then(res => res.json())
            .then(data => {

                list.innerHTML = "";

                if (data.length === 0) {
                    list.innerHTML = "<div class='item'>No station found</div>";
                    list.style.display = "block";
                    hidden.value = "";
                    return;
                }

                // ✅ auto-select first result
                hidden.value = data[0].station_code;

                data.forEach(st => {

                    const div = document.createElement("div");
                    div.className = "item";
                    div.textContent = st.station_name + " (" + st.station_code + ")";

                    div.onclick = () => {
                        input.value = st.station_name;
                        hidden.value = st.station_code;
                        list.style.display = "none";
                    };

                    list.appendChild(div);
                });

                list.style.display = "block";
            })
            .catch(() => {
                list.innerHTML = "<div class='item'>Error loading data</div>";
                list.style.display = "block";
            });
    });

    // hide dropdown
    document.addEventListener("click", function (e) {
        if (!input.contains(e.target) && !list.contains(e.target)) {
            list.style.display = "none";
        }
    });
}


// INIT
setupAuto("fromInput", "fromList", "fromCode");
setupAuto("toInput", "toList", "toCode");


// FORM VALIDATION
document.querySelector("form").addEventListener("submit", function (e) {

    const from = document.getElementById("fromCode").value;
    const to = document.getElementById("toCode").value;

    if (!from || !to) {
        alert("Please select station properly");
        e.preventDefault();
    }
});
</script>
</body>
</html>