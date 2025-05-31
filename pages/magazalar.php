<?php
$current_page = 'stores';
?>
<?php

include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../includes/preloader.php';

require_once __DIR__ . "/../classes/Stores.php";
require_once __DIR__ . "/../classes/StoreCategories.php";
$stcat = new StoreCategories();
$cat = $stcat->getActiveCamapignFilter();
?>
<div class="stores-page">
    <div class="container">
        <div class="stores-header">
            <h1>Dörtyol Mağazaları</h1>
            <p>Dörtyol'un en iyi kampanya ve indirimlerini sunan mağazaları keşfedin.</p>
        </div>

        <!-- Mağaza Filtreleme -->
        <div class="store-filters">
            <div class="search-box">
                <input type="text" placeholder="Mağaza ara..." id="storeSearch">
                <button onclick="handleSearch()"><i class="fas fa-search"></i></button>
            </div>
            <div class="filter-buttons">
                <button class="btn btn-outline active" data-filterid="all">Tümü</button>
                <button class="btn btn-outline" data-filterid="open">Şuan Açık</button>
                <?php
                foreach ($cat as $c) {
                    ?>
                    <button class="btn btn-outline" data-filterid="<?= $c['id'] ?>"><?= $c['category_name'] ?></button>
                    <?php
                }
                ?>
            </div>
        </div>

        <!-- Mağaza Listesi -->
        <div class="stores-grid" id="storesGrid">
            <!-- Mağazalar buraya JS ile eklenecek -->
        </div>
    </div>
</div>

<style>
    .container{
        min-height: calc(80vh-60px);
    }
    .campaign-detail a {
        text-decoration: underline;
        color: #383E42;
    }

    .stores-page {
        min-height: calc(100vh-60px);
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .stores-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .stores-header h1 {
        font-size: 2.5rem;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .stores-header p {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
    }

    .store-filters {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .store-filters .search-box {
        display: flex;
        gap: 10px;
        max-width: 500px;
        margin: 0 auto;
        width: 100%;
    }

    .store-filters .search-box input {
        flex: 1;
        padding: 12px 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
    }

    .store-filters .search-box button {
        padding: 12px 20px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .store-filters .search-box button:hover {
        background: var(--primary-dark);
    }

    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .stores-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .store-card {
        background: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .store-card:hover {
        transform: translateY(-5px);
    }

    .store-image {
        position: relative;
        height: 200px;
    }

    .store-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .store-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .store-status.active {
        background: #28a745;
        color: white;
    }

    .store-info {
        padding: 25px;
    }

    .store-header {
        margin-bottom: 15px;
    }

    .store-header h2 {
        font-size: 1.5rem;
        color: var(--dark);
    }

    .store-owner,
    .store-location {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray);
        margin-bottom: 10px;
    }

    .store-preview {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .campaign-count {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .stores-header h1 {
            font-size: 2rem;
        }

        .stores-header p {
            font-size: 1rem;
        }

        .filter-buttons {
            flex-direction: column;
        }

        .filter-buttons .btn {
            width: 100%;
        }

        .stores-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Preloader Styles */
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .preloader svg {
        width: 100px;
        height: 100px;
    }

    .preloader-text {
        margin-top: 20px;
        font-size: 1.2rem;
        color: #333;
        font-weight: 500;
    }
</style>
<script>
    let currentPage = 1;
    let isLoading = false;
    let lastPage = false;
    let filterType = 'all';
    let searchQuery = '';

    // Enter tuşu ile arama
    document.getElementById('storeSearch').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchQuery = this.value.trim();
            resetAndReload();
        }
    });

    // Arama butonu ile arama
    function handleSearch() {
        searchQuery = document.getElementById('storeSearch').value.trim();
        resetAndReload();
    }

    // Filtre butonları
    const filterBtns = document.querySelectorAll('.filter-buttons .btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterType = this.dataset.filterid;
            // Arama sorgusunu sıfırla
            searchQuery = '';
            document.getElementById('storeSearch').value = '';
            resetAndReload();
        });
    });

    function resetAndReload() {
        currentPage = 1;
        lastPage = false;
        document.getElementById('storesGrid').innerHTML = '';
        loadStores();
    }

    function createStoreCard(store) {
        return `
    <div class="store-card" onclick="window.location.href='magaza-detay.php?id=${store.id}'">
        <div class="store-image">
            <img src="<?= Helper::baseUrl() . '/uploads/images/store_images/' ?>${store.store_main_image}" alt="${store.store_name}"  onerror="this.onerror=null;this.src='<?= Helper::upolads('images/store_images/store-default-image.jpg') ?>';">
            <div class="store-status ${isStoreOpen(store.store_opening_time, store.store_closing_time) ? 'active' : ''}">${isStoreOpen(store.store_opening_time, store.store_closing_time) ? 'Açık' : 'Kapalı'}</div>
        </div>
        <div class="store-info">
            <div class="store-header">
                <h2>${store.store_name}</h2>
            </div>
            <div class="store-owner">
                <i class="fas fa-user"></i>
                <span>${store.store_owner_name || ''}</span>
            </div>
            <div class="store-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>${store.store_adress || ''}</span>
            </div>
            <div class="store-location">
                <i class="fas fa-clock"></i>
                <span>${store.store_opening_time} -  ${store.store_closing_time}</span>
            </div>
            <div class="store-preview" style="display: flex; justify-content: space-between;">
                <span class="campaign-count">${store.active_campaign_count || 0} Aktif Kampanya</span>
                <span class="campaign-detail"> <a href="magaza-detay.php?id=${store.id}" style="display: flex; justify-content: space-evenly; align-items: center;"> İncele <i class="fas fa-arrow-right"></i> </a> </span>
            </div>
        </div>
    </div>
    `;
    }

    function isStoreOpen(openTime, closeTime) {
        if (!openTime || !closeTime) return false;

        const now = new Date();
        const currentHour = now.getHours();
        const currentMinute = now.getMinutes();

        // Saatleri parçalayalım (örn: "09:00" -> 9, 0)
        const [openHour, openMinute] = openTime.split(':').map(Number);
        const [closeHour, closeMinute] = closeTime.split(':').map(Number);

        const nowMinutes = currentHour * 60 + currentMinute;
        const openMinutes = openHour * 60 + openMinute;
        const closeMinutes = closeHour * 60 + closeMinute;

        // Örn: 09:00 - 18:00 arasında mı?
        return nowMinutes >= openMinutes && nowMinutes <= closeMinutes;
    }

    function loadStores() {
        if (isLoading || lastPage) return;
        isLoading = true;

        // Preloader'ı göster
        document.querySelector('.preloader').style.display = 'flex';

        // API URL'ini oluştur
        let apiUrl = `<?= Helper::baseUrl() ?>/api/getStores.php?page=${currentPage}`;
        if (filterType !== 'all') {
            apiUrl += `&filter=${encodeURIComponent(filterType)}`;
        }
        if (searchQuery) {
            apiUrl += `&search=${encodeURIComponent(searchQuery)}`;
        }

        showPreloader();
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    console.error('Arama hatası:', data.message);
                    return;
                }
                if (data.data && data.data.length > 0) {
                    data.data.forEach(store => {
                        document.getElementById('storesGrid').insertAdjacentHTML('beforeend', createStoreCard(store));
                    });
                    currentPage++;
                    if (data.data.length < 24) lastPage = true;
                } else {
                    lastPage = true;
                }
            })
            .catch(error => {
                console.error('Veri yükleme hatası:', error);
            })
            .finally(() => {
                // Preloader'ı gizle
                hidePreloader();
                isLoading = false;
            });
    }

    // Sayfa yüklendiğinde preloader'ı gizle
    window.addEventListener('load', function () {
        // Preloader'ı başlangıçta görünür yap
        hidePreloader();
        // 2 saniye sonra gizle
        setTimeout(() => {
            document.querySelector('.preloader').style.display = 'none';
        }, 2000);
    });

    // İlk yükleme
    loadStores();

    // Infinite scroll
    window.addEventListener('scroll', function () {
        if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 200)) {
            loadStores();
        }
    });
</script>
<?php
include __DIR__ . '/../includes/footer.php'; ?>