// İletişim formu doğrulama
// 1. Native JavaScript ile kontrol
// 2. Vue.js ile kontrol

// ---- 1. Native JavaScript Doğrulama ----

document.getElementById('js-kontrol-btn').addEventListener('click', function () {
    const hataMesaji = document.getElementById('hata-mesaji');
    const basariMesaji = document.getElementById('basari-mesaji');

    hataMesaji.style.display = 'none';
    basariMesaji.style.display = 'none';

    const adSoyad = document.getElementById('ad_soyad').value.trim();
    const email   = document.getElementById('email').value.trim();
    const telefon = document.getElementById('telefon').value.trim();
    const konu    = document.getElementById('konu').value;
    const mesaj   = document.getElementById('mesaj').value.trim();
    const kvkk    = document.getElementById('kvkk').checked;

    const hatalar = [];

    if (!adSoyad) {
        hatalar.push('Ad Soyad alanı boş bırakılamaz.');
    } else if (adSoyad.length < 3) {
        hatalar.push('Ad Soyad en az 3 karakter olmalıdır.');
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        hatalar.push('E-posta alanı boş bırakılamaz.');
    } else if (!emailRegex.test(email)) {
        hatalar.push('Geçerli bir e-posta adresi giriniz.');
    }

    if (telefon) {
        if (!/^[0-9\s+\-()]{10,15}$/.test(telefon)) {
            hatalar.push('Telefon numarası sadece rakamlardan oluşmalıdır (10-15 karakter).');
        }
    }

    if (!konu) {
        hatalar.push('Lütfen bir konu seçiniz.');
    }

    if (!mesaj) {
        hatalar.push('Mesaj alanı boş bırakılamaz.');
    } else if (mesaj.length < 10) {
        hatalar.push('Mesajınız en az 10 karakter olmalıdır.');
    }

    if (!kvkk) {
        hatalar.push('KVKK onay kutucuğunu işaretlemelisiniz.');
    }

    if (hatalar.length > 0) {
        hataMesaji.innerHTML =
            '<strong>Lütfen aşağıdaki hataları düzeltin:</strong>'
            + '<ul class="mb-0 mt-2 ps-3">'
            + hatalar.map(function (h) { return '<li>' + h + '</li>'; }).join('')
            + '</ul>';
        hataMesaji.style.display = 'block';
        hataMesaji.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        basariMesaji.innerHTML = '<i class="bi bi-check-circle me-2"></i>Native JavaScript doğrulama başarılı! Form gönderilebilir.';
        basariMesaji.style.display = 'block';
    }
});


// ---- 2. Vue.js Doğrulama ----

const { createApp, ref } = Vue;

const vueInstance = createApp({
    setup() {
        const vueHatalar = ref([]);
        const vueBasarili = ref(false);

        function vueKontrolEt() {
            vueHatalar.value = [];
            vueBasarili.value = false;

            const adSoyad = document.getElementById('ad_soyad').value.trim();
            const email   = document.getElementById('email').value.trim();
            const telefon = document.getElementById('telefon').value.trim();
            const konu    = document.getElementById('konu').value;
            const mesaj   = document.getElementById('mesaj').value.trim();
            const kvkk    = document.getElementById('kvkk').checked;

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!adSoyad || adSoyad.length < 3) {
                vueHatalar.value.push('Ad Soyad en az 3 karakter olmalıdır.');
            }

            if (!email) {
                vueHatalar.value.push('E-posta alanı zorunludur.');
            } else if (!emailRegex.test(email)) {
                vueHatalar.value.push('Geçerli bir e-posta adresi girin.');
            }

            if (telefon && !/^[0-9\s+\-()]{10,15}$/.test(telefon)) {
                vueHatalar.value.push('Telefon numarası yalnızca rakamlardan oluşmalıdır.');
            }

            if (!konu) {
                vueHatalar.value.push('Konu seçimi zorunludur.');
            }

            if (!mesaj || mesaj.length < 10) {
                vueHatalar.value.push('Mesaj en az 10 karakter olmalıdır.');
            }

            if (!kvkk) {
                vueHatalar.value.push('KVKK aydınlatma metnini kabul etmelisiniz.');
            }

            if (vueHatalar.value.length === 0) {
                vueBasarili.value = true;
            }

            document.getElementById('iletisim-app').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        return { vueHatalar, vueBasarili, vueKontrolEt };
    }
}).mount('#iletisim-app');

// Vue.js butonunu dışarıdan bağla (mount sonrası)
document.getElementById('vue-kontrol-btn').addEventListener('click', function () {
    vueInstance.vueKontrolEt();
});
