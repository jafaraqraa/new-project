<?php
// Restaurant Recommendation - Simple (PHP + MySQL)

$DB_HOST = "localhost";
$DB_NAME = "restaurant_app";
$DB_USER = "appuser";
$DB_PASS = "AppPass123!";

$meal = "";
$result = null;
$error = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset("utf8mb4");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $meal = strtolower(trim($_POST["meal"] ?? ""));
        if ($meal === "") {
            $error = "Please enter a meal type (e.g., shawarma, pizza, burger).";
        } else {
            $stmt = $conn->prepare(
                "SELECT name, meal_type, rating
                 FROM restaurants
                 WHERE meal_type = ?
                 ORDER BY rating DESC
                 LIMIT 1"
            );
            $stmt->bind_param("s", $meal);
            $stmt->execute();
            $res = $stmt->get_result();
            $result = $res->fetch_assoc();

            if (!$result) {
                $error = "No restaurant found for: " . htmlspecialchars($meal);
            }
        }
    }
} catch (Throwable $e) {
    $error = "DB Error: " . $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Restaurant Recommender</title>
  <style>
    body{font-family:Arial,sans-serif;margin:40px;max-width:720px}
    .card{border:1px solid #ddd;border-radius:12px;padding:18px}
    input{padding:10px;width:100%;max-width:380px}
    button{padding:10px 14px;margin-top:10px;cursor:pointer}
    .err{color:#b00020;margin-top:12px}
    .ok{margin-top:14px;padding:12px;background:#f7f7f7;border-radius:10px}
    small{color:#666}
  </style>
</head>
<body>
  <div class="card">
    <h2>Restaurant Recommendation System</h2>
    <p><small>Type your favorite meal and we will recommend the best restaurant.</small></p>

    <form method="POST">
      <label for="meal">Favorite meal (example: shawarma, pizza, burger, sushi)</label><br/>
      <input id="meal" name="meal" value="<?= htmlspecialchars($meal) ?>" placeholder="Type a meal..." />
      <br/>
      <button type="submit">Recommend</button>
    </form>

    <?php if ($error): ?>
      <div class="err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($result): ?>
      <div class="ok">
        <strong>Best match:</strong><br/>
        Restaurant: <?= htmlspecialchars($result["name"]) ?><br/>
        Meal type: <?= htmlspecialchars($result["meal_type"]) ?><br/>
        Rating: <?= htmlspecialchars($result["rating"]) ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
