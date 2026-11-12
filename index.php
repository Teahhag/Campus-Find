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
<link rel="stylesheet" href="/campus_lost_found/style.css?v=2">
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

<footer>© 2026 CampusFind. Built for a better campus community.</footer>

</body>
</html>
