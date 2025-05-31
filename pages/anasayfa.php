<!-- Hero Section -->

<?php

include __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . "/../classes/Categories.php";
require_once __DIR__ . "/../classes/StoreCategories.php";
require_once __DIR__ . "/../classes/FeaturedCampaigns.php";

$featured= new FeaturedCampaigns();
$featuredCampaigns = $featured->getFeaturedCampaing();


$storeCategories = new StoreCategories();

$scat = $storeCategories->all();

$campaingCategories = $storeCategories->getActiveCamapignFilter();


?>
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Şehirdeki En İyi <span>İndirimler</span> ve <span>Kampanyalar</span></h1>
            <p class="hero-subtitle">Restoranlar, mağazalar, etkinlikler ve çok daha fazlası için en güncel indirim
                ve kampanya bilgilerini sizlerle buluşturuyoruz!</p>
            <div class="hero-buttons">
                <a href="#campaigns" class="btn btn-primary">Kampanyaları Keşfet</a>
                <!-- <a href="#app-download" class="btn btn-secondary">Uygulamayı İndir</a> -->
            </div>
        </div>
    </div>
    <div class="hero-shape"></div>
    <div class="hero-images">
        <div class="floating-card">
            <img src="https://static.ticimax.cloud/9247/uploads/urunresimleri/buyuk/hamburger-180c.jpg" alt="Kampanya">
            <div class="floating-card-content">
                <h4>Burger Keyfi</h4>
                <p>%50 İndirim</p>
            </div>
        </div>
        <div class="floating-card">
            <img src="https://www.datocms-assets.com/64859/1648643624-bir-sinema-filmi-nasil-ortaya-cikar.jpg?q=70&auto=format&w=1280"
                alt="Kampanya">
            <div class="floating-card-content">
                <h4>Sinema Bileti</h4>
                <p>1 Alana 1 Bedava</p>
            </div>
        </div>
        <div class="floating-card">
            <img src="https://www.egemende.com/uploads/urun/b/144577-1-2_large.webp" alt="Kampanya">
            <div class="floating-card-content">
                <h4>Akıllı Telefon</h4>
                <h4>Akıllı Telefon</h4>
                <p>3000 TL İndirim</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<!-- <section class="categories" id="categories">
        <div class="container">
            <h2 class="section-title">Kategoriler</h2>
            <div class="categories-container">
                <div class="category-item">
                    <i class="fas fa-utensils"></i>
                    <span>Restoran</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-tshirt"></i>
                    <span>Moda</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Etkinlik</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-hotel"></i>
                    <span>Konaklama</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Elektronik</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Market</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-car"></i>
                    <span>Otomotiv</span>
                </div>
                <div class="category-item">
                    <i class="fas fa-gamepad"></i>
                    <span>Oyun</span>
                </div>
            </div>
        </div>
    </section> -->

<!-- Campaigns Section -->
<section class="campaigns" id="campaigns">
    <div class="container">
        <h2 class="section-title">Güncel Kampanyalar</h2>
        <div class="campaign-filters">
            <div class="filter-btn active" data-category="all">Tümü</div>
            <?php
            if ($campaingCategories) {
                foreach ($campaingCategories as $c) { ?>
                    <div class="filter-btn" data-category="<?= $c['id'] ?>"><?= $c['category_name'] ?></div>
                <?php }
            }
            ?>
        </div>
        <div class="campaigns-grid"></div>
        <a href="#" class="btn btn-primary load-more">Daha Fazla Göster</a>
    </div>
</section>
<script>
    const campaignsGrid = document.querySelector('.campaigns-grid');
    const loadMoreBtn = document.querySelector('.load-more');
    const filterBtns = document.querySelectorAll('.filter-btn');
    let offset = 0;
    const limit = 12;
    let isLoading = false;
    let allLoaded = false;
    let searchForLastCampaign = false;
    let lastId = <?php echo isset($_SESSION['last_campaign_id']) ? json_encode($_SESSION['last_campaign_id']) : 'null'; ?>;
    let currentCategory = 'all';

    // Filtreleme işlevi
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Aktif buton stilini güncelle
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Kategoriyi güncelle
            currentCategory = btn.dataset.category;
            
            // Grid'i temizle ve yeni filtreleme ile başla
            campaignsGrid.innerHTML = '';
            offset = 0;
            allLoaded = false;
            loadCampaigns();
        });
    });

    function createCampaignCard(campaign) {
        let inspan = '';
        var dctype = campaign.campaign_type;
        let cardClass = '';

        switch (dctype) {
            case 'bogo':
                inspan = '<span class="campaign-discount campaign-discount-bogo">1 Alana 1 Bedava</span>';
                cardClass = 'bogo-bg';
                break;
            case 'discount':
                inspan = `<span class="campaign-discount campaign-discount-discount">%${campaign.campaign_disscount_off || ''} İndirim</span>`;
                cardClass = 'discount-bg';
                break;
            case 'bundle':
                inspan = '<span class="campaign-discount campaign-discount-bundle">Paket İndirimi</span>';
                cardClass = 'bundle-bg';
                break;
        }
        return `<div class="campaign-card ${cardClass}" data-id="${campaign.id}" data-category="${campaign.category_id}">
            ${inspan}
            <img src="${campaign.campaign_image}" alt="Kampanya" class="campaign-card-img">
            <div class="campaign-card-content">
                <h3 class="campaign-card-title">${campaign.campaign_title || ''}</h3>
                <p class="campaign-card-desc">${campaign.campaign_sub_description || ''}</p>
                <div class="campaign-card-meta">
                    <div class="campaign-time">
                        <i class="far fa-clock"></i> 
                        ${campaign.campaign_end_time ? 'Bitiş: ' + formatDateTR(campaign.campaign_end_time) : ''}
                    </div>
                    <a href="campaign-detail.php?id=${campaign.id}&store=${campaign.store_id}" class="view-btn">İncele</a>
                </div>
            </div>
        </div>`;
    }

    function formatDateTR(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleString('tr-TR', {
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function loadCampaigns() {
        if ((isLoading && !searchForLastCampaign) || allLoaded) return;
        isLoading = true;
        loadMoreBtn.textContent = 'Yükleniyor...';

        // API URL'ine kategori parametresini ekle
        const apiUrl = `<?= Helper::baseUrl() ?>/api/getCampaignApi.php?offset=${offset}&limit=${limit}${currentCategory !== 'all' ? '&category=' + currentCategory : ''}`;

        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(campaign => {
                        campaignsGrid.insertAdjacentHTML('beforeend', createCampaignCard(campaign));
                    });
                    offset += data.length;
                    if (data.length < limit) {
                        allLoaded = true;
                        loadMoreBtn.style.display = 'none';
                    } else {
                        loadMoreBtn.style.display = 'block';
                    }
                } else {
                    allLoaded = true;
                    loadMoreBtn.style.display = 'none';
                }

                if (searchForLastCampaign && lastId) {
                    const card = document.querySelector(`.campaign-card[data-id="${lastId}"]`);
                    if (card) {
                        card.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        card.classList.add('highlight-campaign', 'highlighted-once');
                        setTimeout(() => card.classList.remove('highlight-campaign'), 2000);
                        searchForLastCampaign = false;
                    } else if (!allLoaded) {
                        isLoading = false;
                        setTimeout(loadCampaigns, 100);
                    }
                }
            })
            .catch(() => {
                loadMoreBtn.textContent = 'Daha Fazla Göster';
            })
            .finally(() => {
                if (!searchForLastCampaign) {
                    isLoading = false;
                    loadMoreBtn.textContent = 'Daha Fazla Göster';
                }
            });
    }

    // Sayfa yüklendiğinde kampanyaları yükle
    loadCampaigns();

    // Daha fazla göster butonuna tıklandığında
    loadMoreBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loadCampaigns();
    });
</script>

<!-- Featured Campaigns -->
<section class="featured" id="featured">
    <div class="container">
        <h2 class="section-title">Öne Çıkan Kampanyalar</h2>
        <div class="featured-grid">

        <?php 
      
        foreach($featuredCampaigns as $fc){
            // Kampanya tipine göre badge ve arka plan rengini belirle
            $badgeClass = '';
            $cardClass = '';
            $discountText = '';

            switch($fc['campaign_type']) {
                case 'bogo':
                    $badgeClass = 'featured-discount-bogo';
                    $cardClass = 'bogo-bg';
                    $discountText = '1 Alana 1 Bedava';
                    break;
                case 'discount':
                    $badgeClass = 'featured-discount-discount';
                    $cardClass = 'discount-bg';
                    $discountText = '%' . $fc['campaign_disscount_off'] . ' İndirim';
                    break;
                case 'bundle':
                    $badgeClass = 'featured-discount-bundle';
                    $cardClass = 'bundle-bg';
                    $discountText = 'Paket İndirimi';
                    break;
            }

            // Kalan süreyi hesapla
            $endDate = new DateTime($fc['featured_ended_date']);
            $now = new DateTime();
            $interval = $now->diff($endDate);
            $remainingTime = '';
            
            if($interval->d > 0) {
                $remainingTime = 'Son ' . $interval->d . ' gün';
            } elseif($interval->h > 0) {
                $remainingTime = 'Son ' . $interval->h . ' saat';
            } else {
                $remainingTime = 'Son ' . $interval->i . ' dakika';
            }
            
            // Görsel yolunu düzenle
            $resim = $fc['campaign_image'];
            $r = explode('-', $resim, 2);
            if(isset($r[0]) && $r[0] == 'stock') {
                $url = Helper::upolads('images/stock_photos/' . $r[1]);
            } else {
                $url = Helper::upolads('images/campaign_images/' . $resim);
            }
            ?>
            <div class="featured-card <?= $cardClass ?>">
                <img src="<?= $url ?>" 
                    alt="<?= $fc['campaign_title'] ?>" class="featured-card-img">
                <div class="featured-card-content">
                    <span class="featured-discount <?= $badgeClass ?>"><?= $discountText ?></span>
                    <h3 class="featured-card-title"><?= $fc['campaign_title'] ?></h3>
                    <p class="featured-card-desc"><?= $fc['campaign_sub_description'] ?></p>
                    <div class="featured-meta">
                        <div class="featured-time">
                            <i class="far fa-clock"></i> <?= $remainingTime ?>
                        </div>
                        <a href="campaign-detail.php?id=<?= $fc['id']?>&store=<?=$fc['storeid']?>" class="view-btn">İncele</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>


<!-- Brands Section -->
<!-- <section class="brands">
        <div class="container brands-container">
            <div class="brand-item">
                <img src="/api/placeholder/120/80" alt="Marka">
            </div>
            <div class="brand-item">
                <img src="/api/placeholder/120/80" alt="Marka">
            </div>
            <div class="brand-item">
                <img src="/api/placeholder/120/80" alt="Marka">
            </div>
            <div class="brand-item">
                <img src="/api/placeholder/120/80" alt="Marka">
            </div>
            <div class="brand-item">
                <img src="/api/placeholder/120/80" alt="Marka">
            </div>
            <div class="brand-item">
                <img src="/api/placeholder/120/80" alt="Marka">
            </div>
        </div>
    </section> -->

<!-- App Download Section -->
<section class="app-download" id="app-download">
    <div class="container app-container">
        <div class="app-content">
            <h2 class="app-title">AMANdiyim Mobil Uygulaması Pek Yakında Sizlerle</h2>
            <p class="app-subtitle">Fırsatları cebinizde taşıyın! Anında bildirimlerle güncel kampanyalardan
                haberdar olun, konum bazlı önerilerle size en yakın fırsatları kaçırmayın.</p>
            <div class="app-buttons">
                <a href="#" class="app-btn">
                    <i class="fab fa-apple"></i>
                    <div class="app-btn-content">
                        <span class="app-btn-text">İndir</span>
                        <span class="app-btn-name">App Store</span>
                    </div>
                </a>
                <a href="#" class="app-btn">
                    <i class="fab fa-google-play"></i>
                    <div class="app-btn-content">
                        <span class="app-btn-text">İndir</span>
                        <span class="app-btn-name">Google Play</span>
                    </div>
                </a>
            </div>
        </div>
        <!-- <div class="app-image">
            <img src="../assets/img/mobil.webp" style="max-height:250px" alt="Mobil Uygulama">
        </div> -->
    </div>
    <div class="app-shape"></div>
</section>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

<style>
    .highlight-campaign {
        box-shadow: 0 0 0 4px #ffb300, 0 2px 12px 0 rgba(255, 179, 0, 0.08);
        transition: box-shadow 0.5s;
    }

    img {
        object-fit: contain !important;
        aspect-ratio: 3/4;

    }
</style>