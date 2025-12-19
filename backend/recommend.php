<?php
// backend/recommend.php

$DB_HOST = "localhost";
$DB_NAME = "restaurant_app";
$DB_USER = "appuser";
$DB_PASS = "AppPass123!";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$meal = strtolower(trim($_POST["meal"] ?? ""));

if ($meal === "") {
    http_response_code(400);
    echo "Meal is required.";
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset("utf8mb4");

    $stmt = $conn->prepare("
        SELECT name, meal_type, rating
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
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Recommendation Result</title>
  <style>
    body{font-family:Arial,sans-serif;margin:40px;max-width:720px}
    .card{border:1px solid #ddd;border-radius:12px;padding:18px;border-radius:12px}
    .err{color:#b00020;margin-top:12px}
    .ok{margin-top:14px;padding:12px;background:#f7f7f7;border-radius:10px}
    a{display:inline-block;margin-top:12px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Result</h2>
    <p>Meal type: <strong><?= h($meal) ?></strong></p>

    <?php if ($error): ?>
      <div class="err">DB Error: <?= h($error) ?></div>
    <?php elseif (!$row): ?>
      <div class="err">No restaurant found for: <?= h($meal) ?></div>
    <?php else: ?>
      <div class="ok">
        <strong>Best match:</strong><br/>
        Restaurant: <?= h($row["name"]) ?><br/>
        Rating: <?= h($row["rating"]) ?>
      </div>
    <?php endif; ?>

    <a href="../frontend/index.html">← Back</a>
  </div>
</body>
</html>
