// Ana JavaScript dosyası — tüm sayfalarda çalışır

document.addEventListener('DOMContentLoaded', function () {

    // ---- 1. Scroll-to-top butonu (sayfaya otomatik eklenir) ----
    const scrollBtn = document.createElement('button');
    scrollBtn.id = 'scroll-top';
    scrollBtn.title = 'Yukarı çık';
    scrollBtn.innerHTML = '<i class="bi bi-arrow-up-short"></i>';
    document.body.appendChild(scrollBtn);

    window.addEventListener('scroll', function () {
        scrollBtn.style.display = window.scrollY > 300 ? 'flex' : 'none';
    });

    scrollBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });


    // ---- 2. Navbar scroll efekti ----
    var navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 60) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }


    // ---- 3. Kart giriş animasyonları ----
    var hedefler = document.querySelectorAll(
        '.hobi-kart, .istatistik-kart, .api-kart, .card, .medya-cerceve, .form-kart, .login-kart'
    );

    hedefler.forEach(function (el, i) {
        el.classList.add('animasyon-hazir');
        // Her 4 kartta bir sıfırlanan stagger efekti
        el.style.transitionDelay = ((i % 4) * 0.1) + 's';
    });

    if ('IntersectionObserver' in window) {
        var gozlemci = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animasyon-aktif');
                    gozlemci.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        hedefler.forEach(function (el) {
            gozlemci.observe(el);
        });
    } else {
        // IntersectionObserver desteklenmiyorsa direkt göster
        hedefler.forEach(function (el) {
            el.classList.add('animasyon-aktif');
        });
    }


    // ---- 4. Aktif navbar linkini mevcut sayfaya göre işaretle ----
    var mevcutSayfa = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.navbar-nav .nav-link').forEach(function (link) {
        if (link.getAttribute('href') === mevcutSayfa) {
            link.classList.add('active');
        }
    });

});
