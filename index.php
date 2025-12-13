<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// معلومات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "new_user";  // اسم المستخدم الذي أنشأناه
$password = "password";  // كلمة المرور الخاصة بالمستخدم
$dbname = "new_project_db";  // قاعدة البيانات التي أنشأناها

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database!";
}

// إغلاق الاتصال
$conn->close();
?>
