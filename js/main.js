// Ana JavaScript dosyası
// Genel yardımcı fonksiyonlar ve sayfa başlatma işlemleri

document.addEventListener('DOMContentLoaded', function () {

    // Aktif navbar linkini mevcut sayfaya göre otomatik işaretle
    const mevcutSayfa = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.navbar-nav .nav-link').forEach(function (link) {
        const href = link.getAttribute('href');
        if (href === mevcutSayfa) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
        }
    });

});
