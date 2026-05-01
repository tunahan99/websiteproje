// Login sayfası JavaScript doğrulama ve URL parametre okuma

// URL'den hata parametresini oku ve göster (PHP yönlendirmesinden gelir)
(function () {
    const params = new URLSearchParams(window.location.search);
    const hata = params.get('hata');
    if (!hata) return;

    const kutu = document.getElementById('sunucu-hata');
    const metin = document.getElementById('sunucu-hata-metin');

    const mesajlar = {
        bos:    'Lütfen tüm alanları doldurun.',
        yanlis: 'Kullanıcı adı veya şifre hatalı.'
    };

    metin.textContent = mesajlar[hata] || 'Giriş yapılamadı.';
    kutu.classList.remove('d-none');
})();


// Form submit öncesi JavaScript doğrulama
document.getElementById('login-form').addEventListener('submit', function (e) {
    const jsHata = document.getElementById('js-hata');
    jsHata.style.display = 'none';
    jsHata.textContent = '';

    const kullaniciAdi = document.getElementById('kullanici_adi').value.trim();
    const sifre = document.getElementById('sifre').value.trim();

    if (!kullaniciAdi || !sifre) {
        e.preventDefault();
        jsHata.textContent = 'Lütfen tüm alanları doldurun.';
        jsHata.style.display = 'block';
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(kullaniciAdi)) {
        e.preventDefault();
        jsHata.textContent = 'Lütfen geçerli bir e-posta adresi giriniz (örn: b251210385@sakarya.edu.tr).';
        jsHata.style.display = 'block';
    }
});


// Şifreyi göster/gizle butonu
document.getElementById('sifre-goster').addEventListener('click', function () {
    const sifreInput = document.getElementById('sifre');
    const sifreIcon  = document.getElementById('sifre-icon');

    if (sifreInput.type === 'password') {
        sifreInput.type = 'text';
        sifreIcon.className = 'bi bi-eye-slash';
    } else {
        sifreInput.type = 'password';
        sifreIcon.className = 'bi bi-eye';
    }
});
