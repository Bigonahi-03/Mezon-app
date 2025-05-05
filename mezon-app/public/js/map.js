// بررسی وجود نقشه قبلی
if (typeof map === 'undefined') {
    var map = L.map('map').setView([27.090073, 57.105671], 15);
    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);
    var marker = L.marker([27.090073, 57.105671]).addTo(map)
        .bindPopup('<b>دانشکده فنی میناب</b>').openPopup();
} 