const API_KEY = '2266679b';
const BASE_URL = 'https://www.omdbapi.com/';

const FILM_IDLERI = [
    'tt0482571', // The Prestige
    'tt0816692', // Interstellar
    'tt1375666', // Inception
    'tt0209144', // Memento
    'tt0114814', // The Usual Suspects
];

async function filmiGetir(imdbId) {
    const url = BASE_URL + '?i=' + imdbId + '&plot=short&apikey=' + API_KEY;
    const cevap = await fetch(url);
    if (!cevap.ok) throw new Error('Ağ hatası');
    const veri = await cevap.json();
    if (veri.Response !== 'True') throw new Error('Film bulunamadı');
    return veri;
}

function kartOlustur(film) {
    const puan   = film.imdbRating !== 'N/A' ? film.imdbRating : '—';
    const sure   = film.Runtime    !== 'N/A' ? film.Runtime    : '';
    const poster = film.Poster     !== 'N/A' ? film.Poster     : null;

    const div = document.createElement('div');
    div.className = 'col-sm-6 col-lg-4';
    div.innerHTML =
        '<div class="api-kart">' +
            (poster
                ? '<img src="' + poster + '" alt="' + film.Title + '" class="api-poster">'
                : '<div class="api-poster-placeholder"><i class="bi bi-film"></i></div>'
            ) +
            '<div class="api-kart-body">' +
                '<h6 class="fw-semibold mb-1">' + film.Title + '</h6>' +
                '<div class="d-flex align-items-center flex-wrap gap-2 mb-2">' +
                    '<span class="puan-badge"><i class="bi bi-star-fill me-1"></i>' + puan + '</span>' +
                    '<span class="text-muted small">' + film.Year + '</span>' +
                    (sure ? '<span class="text-muted small">' + sure + '</span>' : '') +
                '</div>' +
                '<p class="text-muted small mb-1"><strong>Yönetmen:</strong> ' + film.Director + '</p>' +
                '<p class="text-muted small mb-0" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">' +
                    film.Plot +
                '</p>' +
            '</div>' +
        '</div>';
    return div;
}

async function filmleriYukle() {
    const yukleniyor  = document.getElementById('yukleniyor');
    const hataKutusu  = document.getElementById('hata-kutusu');
    const filmListesi = document.getElementById('film-listesi');

    try {
        const filmler = await Promise.all(FILM_IDLERI.map(filmiGetir));
        yukleniyor.classList.add('d-none');
        filmListesi.classList.remove('d-none');
        filmler.forEach(film => filmListesi.appendChild(kartOlustur(film)));
    } catch (hata) {
        console.error(hata);
        yukleniyor.classList.add('d-none');
        hataKutusu.classList.remove('d-none');
    }
}

filmleriYukle();
