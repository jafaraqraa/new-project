<?php
session_start();

// حذف جميع بيانات الجلسة
session_unset();

// تدمير الجلسة
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول
header("Location: login.php");
exit();
?>
