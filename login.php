<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// بدء الجلسة
session_start();

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
    $password = $_POST['password'];

    // استعلام للتحقق من وجود المستخدم في قاعدة البيانات
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // إذا تم العثور على المستخدم
        $row = $result->fetch_assoc();
        
        // التحقق من كلمة المرور
        if (password_verify($password, $row['password'])) {
            // تسجيل الجلسة للمستخدم
            $_SESSION['username'] = $username;
            echo "تم تسجيل الدخول بنجاح!";
            header("Location: dashboard.php"); // إعادة التوجيه إلى صفحة خاصة
            exit(); // إنهاء السكربت
        } else {
            echo "كلمة المرور غير صحيحة!";
        }
    } else {
        echo "المستخدم غير موجود!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
</head>
<body>
    <h2>تسجيل الدخول</h2>
    <form action="login.php" method="post">
        <label for="username">اسم المستخدم:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">تسجيل الدخول</button>
    </form>
</body>
</html>

