<?php
require_once __DIR__ . '/db.php';
$result = $conn->query("SELECT * FROM items ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind | Lost & Found</title>
<link rel="stylesheet" href="style.css?v=5">

<style>
footer.footer {
    background: #263c55;
    padding: 40px 8% 20px;
    text-align: left;
}

.footer-content {
    display: grid !important;
    grid-template-columns: 2fr 1fr 1.5fr !important;
    gap: 40px;
    max-width: 1100px;
    margin: auto;
    text-align: left;
}

.footer-section h3 {
    color: white;
    margin-bottom: 14px;
}

.footer-section p {
    color: #e6e0d5;
    font-size: 14px;
    line-height: 1.7;
}

.footer-section a {
    display: block;
    color: #e6e0d5;
    text-decoration: none;
    margin-bottom: 10px;
    font-size: 14px;
}

.footer-bottom {
    border-top: 1px solid #52677e;
    margin-top: 30px;
    padding-top: 18px;
    text-align: center;
    color: #e6e0d5;
}

@media(max-width:600px) {
    .footer-content {
        grid-template-columns: 1fr !important;
    }
}
</style>

</head>
<body>

<nav class="navbar">
    <h2>Campus<span>Find.</span></h2>
    <div>
        <a href="#home">Home</a>
        <a href="#items">Browse Items</a>
        <a href="#report">Report Item</a>
    </div>
</nav>

<section class="hero" id="home">
    <p class="tag">YOUR CAMPUS, CONNECTED</p>
    <h1>Lost something?<br><span>Let's find it.</span></h1>
    <p class="sub">A smarter way to reconnect students with their lost belongings.</p>
    <a href="#report" class="btn">Report an Item →</a>
    <a href="#items" class="btn secondary">Explore Items</a>
</section>

<section class="stats">
    <div><h2>Campus</h2><p>Community</p></div>
    <div><h2>24/7</h2><p>Accessible Portal</p></div>
    <div><h2>Easy</h2><p>Item Reporting</p></div>
</section>

<?php
include 'db.php';
$result = $conn->query("SELECT * FROM items ORDER BY created_at DESC");
?>
<section class="items" id="items">
    <h2>Recently Reported Items</h2>
    <p>Find what's missing around your campus.</p>
<input
    type="text"
    id="searchItem"
    placeholder="🔍 Search for an item..."
    onkeyup="searchItems()"
    style="max-width:550px; margin:20px auto;"
>
<select id="filterStatus" onchange="filterItems()"
style="max-width:550px; margin:10px auto;">
    <option value="All">All Items</option>
    <option value="Lost">Lost Items</option>
    <option value="Found">Found Items</option>
</select>
<?php if ($result && $result->num_rows > 0): ?>
    <div class="item-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="item-card">
                <div class="emoji">📦</div>
                <h3><?php echo htmlspecialchars($row['item']); ?></h3>
                <p>
    <span style="display:inline-block; padding:5px 12px; border-radius:20px; font-weight:bold;
    background:<?php echo ($row['status'] == 'Lost') ? '#fde8e8' : '#e5f4e9'; ?>;
    color:<?php echo ($row['status'] == 'Lost') ? '#c0392b' : '#218838'; ?>;">
        <?php echo htmlspecialchars($row['status']); ?>
    </span>
</p>

<p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>Contact: <?php echo htmlspecialchars($row['contact']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No items reported yet.</p>
<?php endif; ?>
</section>

<section class="report" id="report">
    <h2>Report an Item</h2>
    <p>Help someone find what they've lost.</p>
    <form method="POST" action="save.php">
        <input name="item" placeholder="Item name" required>
        <select name="status" required>
            <option value="">Select status</option>
            <option value="Lost">Lost</option>
            <option value="Found">Found</option>
        </select>
        <input name="description" placeholder="Description" required>
        <input name="contact" placeholder="Contact details" required>
        <button type="submit">Submit Report →</button>
    </form>
</section>


<footer class="footer">
    <div class="footer-content">

        <div class="footer-section">
            <h3>CampusFind.</h3>
            <p>A platform that helps students reconnect
            with their lost belongings.</p>
        </div>

        <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="#home">Home</a>
            <a href="#items">Browse Items</a>
            <a href="#report">Report Item</a>
        </div>

        <div class="footer-section">
            <h3>About</h3>
            <p>Making campus lost and found easier,
            faster and more accessible.</p>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 CampusFind. Built for a better campus community.
    </div>
</footer>
<script>
function searchItems() {
    let input = document.getElementById("searchItem")
        .value.toLowerCase();

    let cards = document.querySelectorAll(".item-card");

    cards.forEach(function(card) {
        let itemName = card.querySelector("h3")
            .textContent.toLowerCase();

        card.style.display =
            itemName.includes(input) ? "" : "none";
    });
}
</script>

</body>
</html>
