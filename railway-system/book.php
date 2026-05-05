<form action="search.php" method="GET" class="booking-box">

    <input type="text" name="from" placeholder="From" required>
    <input type="text" name="to" placeholder="To" required>
    <input type="date" name="date" required>

    <select name="class">
        <option value="">All Classes</option>
        <option value="SL">Sleeper (SL)</option>
        <option value="3A">AC 3 Tier (3A)</option>
        <option value="2A">AC 2 Tier (2A)</option>
        <option value="1A">First AC (1A)</option>
        <option value="CC">Chair Car (CC)</option>
        <option value="EC">Executive Class (EC)</option>
        <option value="2S">Second Sitting (2S)</option>
        <option value="GN">General (GN)</option>
    </select>

    <button type="submit">Search</button>

</form>