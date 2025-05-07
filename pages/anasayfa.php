<!-- Hero Section -->

<?php
 
include __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . "/../classes/Categories.php";

$campaingCategories = new Categories();
$campaingCategories = $campaingCategories->all(); 
 
 
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

            <div class="filter-btn active">Tümü</div>
            <?php 
            if($campaingCategories){
                foreach($campaingCategories as $c){?>
            <div class="filter-btn"><?=$c['category_name']?></div>

            <?php


                }
            }
            ?>


        </div>
        <div class="campaigns-grid">








        </div>


        <a href="#" class="btn btn-primary load-more">Daha Fazla Göster</a>
    </div>
</section>
<script>
const campaignsGrid = document.querySelector('.campaigns-grid');
const loadMoreBtn = document.querySelector('.load-more');
let offset = 0;
const limit = 12;
let isLoading = false;
let allLoaded = false;
let searchForLastCampaign = false;
let lastId = <?php echo isset($_SESSION['last_campaign_id']) ? json_encode($_SESSION['last_campaign_id']) : 'null'; ?>;

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
            inspan =
                `<span class="campaign-discount campaign-discount-discount">${campaign.campaign_disscount_off || ''} İndirim</span>`;
            cardClass = 'discount-bg';
            break;
        case 'bundle':
            inspan = '<span class="campaign-discount campaign-discount-bundle">Paket İndirimi</span>';
            cardClass = 'bundle-bg';
            break;
    }
    return `<div class="campaign-card ${cardClass}" data-id="${campaign.id}">
        ${inspan}
        <img 
            src="${campaign.campaign_image || 'https://static9.depositphotos.com/1669785/1150/i/450/depositphotos_11506024-stock-photo-package.jpg'}" 
            alt="Kampanya" 
            class="campaign-card-img"
            onerror="this.onerror=null;this.src='https://startiks.com/upload/367620ekle12.jpg';"
        >
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
    // Eğer arama modundaysak, isLoading'i geçici olarak devre dışı bırak
    if ((isLoading && !searchForLastCampaign) || allLoaded) return;
    isLoading = true;
    loadMoreBtn.textContent = 'Yükleniyor...';
    fetch(`<?=Helper::baseUrl()?>/api/getCampaignApi.php?offset=${offset}&limit=${limit}`)
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

            // --- Otomatik arama ve scroll ---
            if (searchForLastCampaign && lastId) {
                const card = document.querySelector(`.campaign-card[data-id="${lastId}"]`);
                if (card) {
                    card.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    card.classList.add('highlight-campaign', 'highlighted-once');
                    setTimeout(() => card.classList.remove('highlight-campaign'), 2000);
                    searchForLastCampaign = false; // Bulunca dur
                } else if (!allLoaded) {
                    // Hala bulamadıysak, bir sonraki partiyi yükle (isLoading'i sıfırla ve tekrar çağır)
                    isLoading = false;
                    setTimeout(loadCampaigns, 100); // Kısa bir gecikme ile tekrar dene
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

// İlk yüklemede arama başlat
if (lastId) {
    searchForLastCampaign = true;
}
loadCampaigns();

// Butona tıklayınca yükle
loadMoreBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loadCampaigns();
});

// Scroll ile yükle (infinite scroll)
window.addEventListener('scroll', function() {
    if (allLoaded || isLoading) return;
    const scrollY = window.scrollY || window.pageYOffset;
    const windowH = window.innerHeight;
    const docH = document.documentElement.scrollHeight;
    if (scrollY + windowH + 200 >= docH) {
        loadCampaigns();
    }

});
</script>

<!-- Featured Campaigns -->
<section class="featured" id="featured">
    <div class="container">
        <h2 class="section-title">Öne Çıkan Kampanyalar</h2>
        <div class="featured-grid">
            <div class="featured-card">
                <img src="https://static.ticimax.cloud/9247/uploads/urunresimleri/buyuk/hamburger-180c.jpg"
                    alt="Kampanya" class="featured-card-img">
                <div class="featured-card-content">
                    <span class="featured-discount">%60 İndirim</span>
                    <h3 class="featured-card-title">Premium Burger Menü</h3>
                    <p class="featured-card-desc">Şehrin en iyi burgerlerini özel indirimle deneyimleyin.</p>
                    <div class="featured-meta">
                        <div class="featured-time">
                            <i class="far fa-clock"></i> Son 2 gün
                        </div>
                        <a href="#" class="view-btn">İncele</a>
                    </div>
                </div>
            </div>
            <div class="featured-card">
                <img src="https://cdn3.enuygun.com/media/lib/1x420/uploads/image/artes-otel-hatay-genel-40667948.jpg"
                    alt="Kampanya" class="featured-card-img">
                <div class="featured-card-content">
                    <span class="featured-discount">%75 İndirim</span>
                    <h3 class="featured-card-title">Lüks Otel Konaklaması</h3>
                    <p class="featured-card-desc">5 yıldızlı otellerde iki kişilik konaklama fırsatı.</p>
                    <div class="featured-meta">
                        <div class="featured-time">
                            <i class="far fa-clock"></i> Son 5 gün
                        </div>
                        <a href="#" class="view-btn">İncele</a>
                    </div>
                </div>
            </div>
            <div class="featured-card">
                <img src="https://enstitu.ibb.istanbul/files/ismekOrg/Image/img_brans/brans_yenisitegaleri/moda-illustrasyonu-moda-figuru-cizimi/3.jpg"
                    alt="Kampanya" class="featured-card-img">
                <div class="featured-card-content">
                    <span class="featured-discount">%50+%20 İndirim</span>
                    <h3 class="featured-card-title">Moda Festivali</h3>
                    <p class="featured-card-desc">Sezon sonu ürünlerde kaçırılmayacak fırsat.</p>
                    <div class="featured-meta">
                        <div class="featured-time">
                            <i class="far fa-clock"></i> Son 8 gün
                        </div>
                        <a href="#" class="view-btn">İncele</a>
                    </div>
                </div>
            </div>
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
</style>