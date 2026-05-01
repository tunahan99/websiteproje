<?php
// İletişim formu işleme sayfası
// Form verileri POST yöntemiyle bu sayfaya gönderilir

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: iletisim.html');
    exit;
}

// Gelen verileri temizle
function temizle($veri) {
    return htmlspecialchars(trim($veri));
}

$adSoyad      = temizle($_POST['ad_soyad'] ?? '');
$email        = temizle($_POST['email'] ?? '');
$telefon      = temizle($_POST['telefon'] ?? '');
$konu         = temizle($_POST['konu'] ?? '');
$dogumTarihi  = temizle($_POST['dogum_tarihi'] ?? '');
$cinsiyet     = temizle($_POST['cinsiyet'] ?? '');
$mesaj        = temizle($_POST['mesaj'] ?? '');
$oncelik      = temizle($_POST['oncelik'] ?? '5');
$kvkk         = isset($_POST['kvkk']) ? 'Kabul Edildi' : 'Kabul Edilmedi';
$ilgiAlanlari = isset($_POST['ilgi']) ? array_map('htmlspecialchars', $_POST['ilgi']) : [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Sonucu - Tunahan Salih Kostak</title>
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
                    <li class="nav-item"><a class="nav-link" href="sehrim.html">Şehrim</a></li>
                    <li class="nav-item"><a class="nav-link" href="miras.html">Mirasımız</a></li>
                    <li class="nav-item"><a class="nav-link" href="ilgialanlarim.html">İlgi Alanlarım</a></li>
                    <li class="nav-item"><a class="nav-link active" href="iletisim.html">İletişim</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link btn btn-outline-light px-3" href="login.html">Giriş</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size:3.5rem;"></i>
                        <h2 class="mt-3 fw-bold">Form Başarıyla Alındı!</h2>
                        <p class="text-muted">Gönderilen form verileri aşağıda listelenmiştir.</p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white fw-semibold">
                            <i class="bi bi-list-ul me-2"></i>Gönderilen Veriler
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width:35%">Ad Soyad</th>
                                        <td><?= $adSoyad ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th>E-posta</th>
                                        <td><?= $email ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Telefon</th>
                                        <td><?= $telefon ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Konu</th>
                                        <td><?= $konu ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Doğum Tarihi</th>
                                        <td><?= $dogumTarihi ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cinsiyet</th>
                                        <td><?= $cinsiyet ?: '<em class="text-muted">Belirtilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th>İlgi Alanları</th>
                                        <td>
                                            <?php if (!empty($ilgiAlanlari)): ?>
                                                <?= implode(', ', $ilgiAlanlari) ?>
                                            <?php else: ?>
                                                <em class="text-muted">Seçilmedi</em>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mesaj Önceliği</th>
                                        <td><?= $oncelik ?> / 10</td>
                                    </tr>
                                    <tr>
                                        <th>KVKK Onayı</th>
                                        <td><?= $kvkk ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mesaj</th>
                                        <td style="white-space:pre-wrap"><?= $mesaj ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="iletisim.html" class="btn btn-outline-primary me-2">
                            <i class="bi bi-arrow-left me-1"></i>Forma Geri Dön
                        </a>
                        <a href="index.html" class="btn btn-primary">
                            <i class="bi bi-house me-1"></i>Ana Sayfa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black text-white text-center py-3">
        <small>&copy; 2025 Tunahan Salih Kostak &mdash; b251210385 &mdash; Sakarya Üniversitesi</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
