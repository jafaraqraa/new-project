<?php
session_start();

// التحقق من الجلسة: إذا لم يكن المستخدم قد سجل الدخول، إعادة التوجيه إلى صفحة تسجيل الدخول
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>مرحبًا، " . $_SESSION['username'] . "!</h2>";
echo "<p>تم تسجيل الدخول بنجاح. مرحبًا بك في لوحة التحكم الخاصة بك.</p>";
echo "<a href='logout.php'>تسجيل الخروج</a>";
?>
