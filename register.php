<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// بيانات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "new_user";  // اسم المستخدم الذي أنشأناه
$password = "password";  // كلمة المرور الخاصة بالمستخدم
$dbname = "new_project_db";  // اسم قاعدة البيانات

// إنشاء الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التعامل مع البيانات بعد إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // تشفير كلمة المرور قبل تخزينها في قاعدة البيانات

    // إدخال البيانات في قاعدة البيانات
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "تم تسجيل المستخدم بنجاح!";
    } else {
        echo "خطأ: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل مستخدم جديد</title>
</head>
<body>
    <h2>التسجيل</h2>
    <form action="register.php" method="post">
        <label for="username">اسم المستخدم:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">تسجيل</button>
    </form>
</body>
</html>
