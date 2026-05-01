// TMDB API ile popüler film listesini çekme
// API Key: ücretsiz TMDB hesabından alınmalı

const API_KEY = 'TMDB_API_KEY_BURAYA';
const BASE_URL = 'https://api.themoviedb.org/3';
const IMG_BASE = 'https://image.tmdb.org/t/p/w500';

async function filmleriYukle() {
    const yukleniyor = document.getElementById('yukleniyor');
    const hataKutusu = document.getElementById('hata-kutusu');
    const filmListesi = document.getElementById('film-listesi');

    try {
        const url = `${BASE_URL}/movie/popular?api_key=${API_KEY}&language=tr-TR&page=1`;
        const cevap = await fetch(url);

        if (!cevap.ok) throw new Error('API isteği başarısız');

        const veri = await cevap.json();
        const filmler = veri.results.slice(0, 12);

        yukleniyor.classList.add('d-none');
        filmListesi.classList.remove('d-none');

        filmler.forEach(function (film) {
            const puan = film.vote_average ? film.vote_average.toFixed(1) : 'N/A';
            const yil = film.release_date ? film.release_date.substring(0, 4) : '';
            const posterUrl = film.poster_path
                ? IMG_BASE + film.poster_path
                : null;

            const kart = document.createElement('div');
            kart.className = 'col-sm-6 col-md-4 col-lg-3';
            kart.innerHTML = `
                <div class="api-kart">
                    ${posterUrl
                        ? `<img src="${posterUrl}" alt="${film.title}" class="api-poster">`
                        : `<div class="api-poster-placeholder"><i class="bi bi-film"></i></div>`
                    }
                    <div class="api-kart-body">
                        <h6 class="mb-1 fw-semibold">${film.title}</h6>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="puan-badge"><i class="bi bi-star-fill me-1"></i>${puan}</span>
                            <span class="text-muted small">${yil}</span>
                        </div>
                        <p class="text-muted small mb-0" style="
                            display: -webkit-box;
                            -webkit-line-clamp: 3;
                            -webkit-box-orient: vertical;
                            overflow: hidden;">
                            ${film.overview || 'Açıklama mevcut değil.'}
                        </p>
                    </div>
                </div>
            `;
            filmListesi.appendChild(kart);
        });

    } catch (hata) {
        console.error('Film yükleme hatası:', hata);
        yukleniyor.classList.add('d-none');
        hataKutusu.classList.remove('d-none');
    }
}

filmleriYukle();
