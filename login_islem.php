<?php
// Login işleme sayfası
// Kullanıcı adı ve şifre PHP tarafında doğrulanır

session_start();

// Tanımlı kimlik bilgileri
$gecerli_email  = 'b251210385@sakarya.edu.tr';
$gecerli_sifre  = 'b251210385';
$ogrenci_no     = 'b251210385';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$kullaniciAdi = trim($_POST['kullanici_adi'] ?? '');
$sifre        = trim($_POST['sifre'] ?? '');

// Boşluk kontrolü
if ($kullaniciAdi === '' || $sifre === '') {
    header('Location: login.html?hata=bos');
    exit;
}

// Kimlik doğrulama
if ($kullaniciAdi === $gecerli_email && $sifre === $gecerli_sifre) {
    $_SESSION['giris_yapildi'] = true;
    $_SESSION['ogrenci_no']    = $ogrenci_no;
    ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoşgeldiniz - Tunahan Salih Kostak</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">T.S. Kostak</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Hakkımda</a></li>
                    <li class="nav-item"><a class="nav-link" href="cv.html">CV</a></li>
                    <li class="nav-item"><a class="nav-link" href="iletisim.html">İletişim</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link btn btn-outline-danger px-3" href="cikis.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex align-items-center justify-content-center" style="min-height:80vh;">
        <div class="text-center p-5">
            <i class="bi bi-person-check-fill text-success" style="font-size:5rem;"></i>
            <h1 class="mt-4 fw-bold">
                Hoşgeldiniz <span class="text-primary"><?= htmlspecialchars($ogrenci_no) ?></span>
            </h1>
            <p class="text-muted mt-2">Başarıyla giriş yaptınız.</p>
            <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                <a href="index.html" class="btn btn-primary px-4">
                    <i class="bi bi-house me-2"></i>Ana Sayfaya Git
                </a>
                <a href="login.html" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-box-arrow-left me-2"></i>Çıkış Yap
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-black text-white text-center py-3">
        <small>&copy; 2025 Tunahan Salih Kostak &mdash; b251210385 &mdash; Sakarya Üniversitesi</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
    <?php
} else {
    // Yanlış bilgi → login sayfasına hata mesajıyla yönlendir
    header('Location: login.html?hata=yanlis');
    exit;
}
?>
