<?php
// Çıkış işlemi — session temizle ve login sayfasına yönlendir

session_start();
session_unset();
session_destroy();

header('Location: login.html');
exit;
?>
