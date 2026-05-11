<?php
// İletişim formu işleme sayfası
// Form verileri POST yöntemiyle bu sayfaya gönderilir

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: iletisim.html');
    exit;
}

// Gelen metin verilerini temizleme fonksiyonu
function temizle($veri) {
    return htmlspecialchars(trim($veri));
}

// POST verilerini al
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

// Sunucu tarafı zorunlu alan kontrolü
$sunucuHatalari = [];

if ($adSoyad === '') {
    $sunucuHatalari[] = 'Ad Soyad alanı zorunludur.';
}

if ($email === '') {
    $sunucuHatalari[] = 'E-posta alanı zorunludur.';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $sunucuHatalari[] = 'Geçerli bir e-posta adresi giriniz.';
}

if ($mesaj === '') {
    $sunucuHatalari[] = 'Mesaj alanı zorunludur.';
}

if ($kvkk === 'Kabul Edilmedi') {
    $sunucuHatalari[] = 'KVKK onayı zorunludur.';
}

// Dosya yükleme işlemi
$dosyaBilgisi = null;
if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] !== UPLOAD_ERR_NO_FILE) {
    $dosya = $_FILES['dosya'];

    if ($dosya['error'] === UPLOAD_ERR_OK) {
        $izinliTipler = ['application/pdf', 'application/msword',
                         'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                         'image/jpeg', 'image/png', 'image/gif'];
        $maxBoyut = 5 * 1024 * 1024; // 5 MB

        if (!in_array($dosya['type'], $izinliTipler)) {
            $sunucuHatalari[] = 'Geçersiz dosya türü. PDF, Word veya görsel dosyası yükleyiniz.';
        } elseif ($dosya['size'] > $maxBoyut) {
            $sunucuHatalari[] = 'Dosya boyutu 5 MB\'ı aşamaz.';
        } else {
            $dosyaBilgisi = [
                'ad'   => htmlspecialchars($dosya['name']),
                'boyut' => round($dosya['size'] / 1024, 1) . ' KB',
                'tur'  => htmlspecialchars($dosya['type'])
            ];
        }
    } else {
        $sunucuHatalari[] = 'Dosya yüklenirken bir hata oluştu (Hata kodu: ' . $dosya['error'] . ').';
    }
}
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
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
                <div class="col-lg-8">

                    <?php if (!empty($sunucuHatalari)): ?>
                    <!-- Sunucu tarafı hata mesajları -->
                    <div class="text-center mb-4">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size:3.5rem;"></i>
                        <h2 class="mt-3 fw-bold">Form Gönderilemedi</h2>
                        <p class="text-muted">Lütfen aşağıdaki hataları düzeltip tekrar deneyin.</p>
                    </div>
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-triangle me-2"></i>Hata listesi:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            <?php foreach ($sunucuHatalari as $hata): ?>
                                <li><?= $hata ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="text-center mt-3">
                        <a href="iletisim.html" class="btn btn-primary px-4">
                            <i class="bi bi-arrow-left me-2"></i>Forma Geri Dön
                        </a>
                    </div>

                    <?php else: ?>
                    <!-- Başarılı gönderim -->
                    <div class="text-center mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size:3.5rem;"></i>
                        <h2 class="mt-3 fw-bold">Form Başarıyla Alındı!</h2>
                        <p class="text-muted">Gönderilen tüm veriler aşağıda düzenli olarak listelenmiştir.</p>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white fw-semibold py-3">
                            <i class="bi bi-list-ul me-2"></i>Gönderilen Veriler
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width:35%">Ad Soyad</th>
                                        <td><?= $adSoyad ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">E-posta</th>
                                        <td><?= $email ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Telefon</th>
                                        <td><?= $telefon ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Konu</th>
                                        <td>
                                            <?php
                                            $konuEtiketleri = [
                                                'genel'  => 'Genel Bilgi',
                                                'is'     => 'İş Birliği',
                                                'proje'  => 'Proje Teklifi',
                                                'diger'  => 'Diğer'
                                            ];
                                            echo $konu ? ($konuEtiketleri[$konu] ?? $konu) : '<em class="text-muted">Seçilmedi</em>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Doğum Tarihi</th>
                                        <td>
                                            <?php
                                            if ($dogumTarihi) {
                                                $tarih = DateTime::createFromFormat('Y-m-d', $dogumTarihi);
                                                echo $tarih ? $tarih->format('d.m.Y') : $dogumTarihi;
                                            } else {
                                                echo '<em class="text-muted">Girilmedi</em>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Cinsiyet</th>
                                        <td>
                                            <?php
                                            $cinsiyetEtiket = [
                                                'erkek'                 => 'Erkek',
                                                'kadin'                 => 'Kadın',
                                                'belirtmek_istemiyorum' => 'Belirtmek istemiyorum'
                                            ];
                                            echo $cinsiyet ? ($cinsiyetEtiket[$cinsiyet] ?? $cinsiyet) : '<em class="text-muted">Belirtilmedi</em>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">İlgi Alanları</th>
                                        <td>
                                            <?php if (!empty($ilgiAlanlari)): ?>
                                                <?php foreach ($ilgiAlanlari as $ilgi): ?>
                                                    <span class="badge bg-primary me-1"><?= $ilgi ?></span>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <em class="text-muted">Seçilmedi</em>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Mesaj Önceliği</th>
                                        <td>
                                            <?= $oncelik ?> / 10
                                            <div class="progress mt-1" style="height:6px; max-width:150px;">
                                                <div class="progress-bar" style="width:<?= ($oncelik / 10) * 100 ?>%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">KVKK Onayı</th>
                                        <td>
                                            <?php if ($kvkk === 'Kabul Edildi'): ?>
                                                <span class="text-success fw-medium">
                                                    <i class="bi bi-check-circle me-1"></i><?= $kvkk ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-danger fw-medium">
                                                    <i class="bi bi-x-circle me-1"></i><?= $kvkk ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Yüklenen Dosya</th>
                                        <td>
                                            <?php if ($dosyaBilgisi): ?>
                                                <i class="bi bi-paperclip me-1 text-primary"></i>
                                                <strong><?= $dosyaBilgisi['ad'] ?></strong>
                                                <span class="text-muted ms-2 small">
                                                    (<?= $dosyaBilgisi['boyut'] ?> — <?= $dosyaBilgisi['tur'] ?>)
                                                </span>
                                            <?php else: ?>
                                                <em class="text-muted">Dosya yüklenmedi</em>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Mesaj</th>
                                        <td style="white-space:pre-wrap"><?= $mesaj ?: '<em class="text-muted">Girilmedi</em>' ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="iletisim.html" class="btn btn-outline-primary me-2">
                            <i class="bi bi-arrow-left me-1"></i>Forma Geri Dön
                        </a>
                        <a href="index.html" class="btn btn-primary">
                            <i class="bi bi-house me-1"></i>Ana Sayfa
                        </a>
                    </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black text-white text-center py-3">
        <small>&copy; 2025 Tunahan Salih Kostak &mdash; b251210385 &mdash; Sakarya Üniversitesi</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
