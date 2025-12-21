<?php
$DB_HOST = "db";               // اسم خدمة MySQL في docker-compose
$DB_NAME = "restaurant_db";
$DB_USER = "root";
$DB_PASS = "rootpassword";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$meal = strtolower(trim($_POST["meal"] ?? ""));

if ($meal === "") {
    http_response_code(400);
    echo "Meal is required.";
    exit;
}

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset("utf8mb4");

    $stmt = $conn->prepare("
        SELECT name, rating
        FROM restaurants
        WHERE meal_type = ?
        ORDER BY rating DESC
        LIMIT 1
    ");
    $stmt->bind_param("s", $meal);
    $stmt->execute();

    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $error = "";

} catch (Throwable $e) {
    $row = null;
    $error = $e->getMessage();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Recommendation Result</title>
  <style>
    body{font-family:Arial;margin:40px}
    .card{border:1px solid #ddd;border-radius:12px;padding:20px}
    .err{color:#b00020}
    .ok{background:#f7f7f7;padding:12px;border-radius:8px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Result</h2>
    <p>Meal type: <strong><?= h($meal) ?></strong></p>

    <?php if ($error): ?>
      <div class="err">DB Error: <?= h($error) ?></div>
    <?php elseif (!$row): ?>
      <div class="err">No restaurant found.</div>
    <?php else: ?>
      <div class="ok">
        <strong>Best match:</strong><br>
        <?= h($row["name"]) ?><br>
        Rating: <?= h($row["rating"]) ?>
      </div>
    <?php endif; ?>

    <br>
    <a href="../frontend/index.html">← Back</a>
  </div>
</body>
</html>
