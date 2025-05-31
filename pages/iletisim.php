<?php
$current_page = 'contact';
?>
<?php 

include __DIR__.'/../includes/navbar.php';

// Kullanıcı tipine göre menü öğeleri
$menuItems = [
    'guest' => [
        ['url' => '/', 'text' => 'Ana Sayfa'],
        ['url' => '/kampanyalar', 'text' => 'Kampanyalar'],
        ['url' => '/magazalar', 'text' => 'Mağazalar'],
        ['url' => '/giris', 'text' => 'Giriş Yap'],
        ['url' => '/kayit', 'text' => 'Kayıt Ol']
    ],
    'customer' => [
        ['url' => '/', 'text' => 'Ana Sayfa'],
        ['url' => '/kampanyalar', 'text' => 'Kampanyalar'],
        ['url' => '/magazalar', 'text' => 'Mağazalar'],
        ['url' => '/profilim', 'text' => 'Profilim'],
        ['url' => '/favorilerim', 'text' => 'Favorilerim'],
        ['url' => '/cikis', 'text' => 'Çıkış Yap']
    ],
    'store' => [
        ['url' => '/', 'text' => 'Ana Sayfa'],
        ['url' => '/magaza-paneli', 'text' => 'Mağaza Paneli'],
        ['url' => '/kampanya-olustur', 'text' => 'Kampanya Oluştur'],
        ['url' => '/kampanyalarim', 'text' => 'Kampanyalarım'],
        ['url' => '/istatistikler', 'text' => 'İstatistikler'],
        ['url' => '/cikis', 'text' => 'Çıkış Yap']
    ],
    'admin' => [
        ['url' => '/', 'text' => 'Ana Sayfa'],
        ['url' => '/admin-paneli', 'text' => 'Admin Paneli'],
        ['url' => '/kullanicilar', 'text' => 'Kullanıcılar'],
        ['url' => '/magazalar', 'text' => 'Mağazalar'],
        ['url' => '/kampanyalar', 'text' => 'Kampanyalar'],
        ['url' => '/ayarlar', 'text' => 'Ayarlar'],
        ['url' => '/cikis', 'text' => 'Çıkış Yap']
    ]
];

// Kullanıcı tipine göre menü gösterimi
$userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'guest';
$currentMenu = $menuItems[$userType] ?? $menuItems['guest'];

// Aktif menü kontrolü için fonksiyon
function isActiveMenu($url) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentPath === $url ? 'active' : '';
}
?>
<div class="contact-page">
    <div class="container">
        <div class="contact-header">
            <h1>İletişim</h1>
            <p>Reklam vermek veya önerilerinizi paylaşmak için bizimle iletişime geçin.</p>
        </div>

        <div class="contact-grid">
            <!-- Reklam Bilgileri -->
            <div class="contact-card" id="reklam-card">
                <div class="icon-div">


                    <div class="card-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
                <h2>Reklam Ver</h2>
                <p>İşletmenizin kampanyalarını ve indirimlerini binlerce potansiyel müşteriye ulaştırın.</p>
                <ul class="features-list">
                    <li><i class="fas fa-check"></i> Geniş Hedef Kitle</li>
                    <li><i class="fas fa-check"></i> Uygun Fiyatlandırma</li>
                    <li><i class="fas fa-check"></i> Detaylı Raporlama</li>
                    <li><i class="fas fa-check"></i> Profesyonel Destek</li>
                </ul>
                <a href="mailto:reklam@amandiyim.com" class="btn btn-primary">Reklam Bilgisi Al</a>
            </div>

            <!-- Öneri Formu -->
            <div class="contact-card">
                <div class="card-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h2>Önerileriniz</h2>
                <p>Platformumuzu daha iyi hale getirmek için önerilerinizi bizimle paylaşın.</p>
                <form class="suggestion-form">
                    <div class="form-group">
                        <label for="name">Adınız Soyadınız</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-posta Adresiniz</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Öneri Kategorisi</label>
                        <select id="category" name="category" required>
                            <option value="">Seçiniz</option>
                            <option value="design">Tasarım</option>
                            <option value="functionality">İşlevsellik</option>
                            <option value="content">İçerik</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="suggestion">Öneriniz</label>
                        <textarea id="suggestion" name="suggestion" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </form>
            </div>
        </div>

        <!-- İletişim Bilgileri -->
        <div class="contact-info">
            <div class="info-card">
                <i class="fas fa-envelope"></i>
                <h3>E-posta</h3>
                <p>info@amandiyim.com</p>
            </div>
            <div class="info-card">
                <i class="fas fa-clock"></i>
                <h3>Çalışma Saatleri</h3>
                <p>7/24 Hizmetinizdeyiz</p>
            </div>
            <div class="info-card">
                <i class="fas fa-headset"></i>
                <h3>Destek</h3>
                <p>Teknik destek için bize ulaşın</p>
            </div>
        </div>
    </div>
</div>

<style>
    #reklam-card {
        text-align: center;
    }

    .contact-page {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .contact-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .contact-header h1 {
        font-size: 2.5rem;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .contact-header p {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 50px;
    }

    .contact-card {
        background: var(--white);
        padding: 30px;
        border-radius: 15px;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-5px);
    }

    .card-icon {
 
        width: 60px;
        height: 60px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .card-icon i {
        font-size: 24px;
        color: var(--white);
    }

    .contact-card h2 {
        font-size: 1.5rem;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .contact-card p {
        color: var(--gray);
        margin-bottom: 20px;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin-bottom: 25px;
    }

    .features-list li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: var(--gray);
    }

    .features-list li i {
        color: var(--primary);
        margin-right: 10px;
    }

    .suggestion-form .form-group {
        margin-bottom: 20px;
    }
 
    .suggestion-form label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark);
        font-weight: 500;
    }

    .suggestion-form input,
    .suggestion-form select,
    .suggestion-form textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .suggestion-form input:focus,
    .suggestion-form select:focus,
    .suggestion-form textarea:focus {
        border-color: var(--primary);
        outline: none;
    }

    .contact-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
    }

    .info-card {
        background: var(--white);
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow-sm);
    }

    .info-card i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .info-card h3 {
        font-size: 1.2rem;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .info-card p {
        color: var(--gray);
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .contact-info {
            grid-template-columns: 1fr;
        }

        .contact-header h1 {
            font-size: 2rem;
        }

        .contact-header p {
            font-size: 1rem;
        }
    }
</style>
<?php 
include __DIR__."/../includes/footer.php";
?>