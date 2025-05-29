<?php
require_once __DIR__ . '/../includes/header.php';

// Sadece yeni kayıt olan mağazalar için göster


?>

<div class="get-started-container">
    <div class="welcome-header">
        <h1>Onaylı Mağaza Avantajları</h1>
        <p class="subtitle">Mağazanızı bir üst seviyeye taşıyın ve özel ayrıcalıklardan yararlanın</p>
    </div>

    <div class="info-card">
        <div class="info-icon">
            <i class="fas fa-crown"></i>
        </div>
        <div class="info-content">
            <h2>Onaylı Mağazalar İçin Stratejik Destek</h2>
            <p>
                Platformumuz, onaylı mağazalarla kurduğu iş ortaklıklarında daha aktif bir destek mekanizması yürütür.
            </p>
            <p>
                Gerekli kriterleri karşılayan mağazalar adına belirli kampanyalar ön finanse edilirek sistemimiz
                aracılığıyla müşterilere özel indirim avantajları sunulur.
            </p>
            <p>
                Onaylı mağaza olarak avantajlardan yararlanın.
            </p>
        </div>
    </div>

    <div class="steps-container">
        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="step-content">
                <h3>Güvenilirlik Rozeti</h3>
                <p>Mağazanızda özel bir onaylı mağaza rozeti görüntülenir ve müşterilerinize güven verir.</p>
                <span class="badge bg-success">Premium</span>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="step-content">
                <h3>Öne Çıkarma</h3>
                <p>Ürünleriniz arama sonuçlarında öncelikli olarak gösterilir ve daha fazla görünürlük sağlar.</p>
                <span class="badge bg-warning">Öne Çıkan</span>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="step-content">
                <h3>Gelişmiş Analitik</h3>
                <p>Detaylı satış raporları ve müşteri analizlerine erişim sağlarsınız.</p>
                <span class="badge bg-info">Analitik</span>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="step-content">
                <h3>Özel Kampanya Hakkı</h3>
                <p>Platform genelinde özel kampanyalar düzenleme ve indirimler sunma imkanı.</p>
                <span class="badge bg-primary">Kampanya</span>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-headset"></i>
            </div>
            <div class="step-content">
                <h3>Öncelikli Destek</h3>
                <p>7/24 öncelikli müşteri desteği ve hızlı çözüm süreçleri.</p>
                <span class="badge bg-danger">VIP Destek</span>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="step-content">
                <h3>Reklam İmkanları</h3>
                <p>Platform içi reklam ve tanıtım fırsatlarından öncelikli yararlanma.</p>
                <span class="badge bg-secondary">Reklam</span>
            </div>
        </div>
    </div>

    <div class="requirements-section">
        <h2 class="text-center mb-4">Onaylı Mağaza Olma Kriterleri</h2>
        <div class="criteria-list">
            <div class="criteria-item">
                <div class="criteria-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="criteria-content">
                    <h3>Deneyim</h3>
                    <ul>
                        <li>En az 3 ay aktif mağaza olarak hizmet vermiş olmak</li>
                        <li>Düzenli ürün güncellemesi yapıyor olmak</li>
                        <li>Platform kurallarına uyum sağlamış olmak</li>
                    </ul>
                </div>
            </div>

            <div class="criteria-item">
                <div class="criteria-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="criteria-content">
                    <h3>Müşteri Memnuniyeti</h3>
                    <ul>
                        <li>Müşteri memnuniyet puanının 4.5 ve üzeri olması</li>
                        <li>Olumlu değerlendirme oranının %90'ın üzerinde olması</li>
                        <li>Müşteri şikayetlerinin hızlı çözümlenmesi</li>
                    </ul>
                </div>
            </div>

            <div class="criteria-item">
                <div class="criteria-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="criteria-content">
                    <h3>Satış Performansı</h3>
                    <ul>
                        <li>En az 50 başarılı satış gerçekleştirmiş olmak</li>
                        <li>Aylık minimum 10 aktif ürün listesi</li>
                        <li>Düzenli satış aktivitesi göstermek</li>
                    </ul>
                </div>
            </div>

            <div class="criteria-item">
                <div class="criteria-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="criteria-content">
                    <h3>İade ve İptal Oranı</h3>
                    <ul>
                        <li>İade ve iptal oranının %5'in altında olması</li>
                        <li>Kargo sorunlarının minimum seviyede olması</li>
                        <li>Ürün uyumsuzluğu şikayetlerinin az olması</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="completion-section">
        <a href="#" class="btn btn-success btn-lg">
            <i class="fas fa-rocket me-2"></i>Henüz Başvuru Gereksinimlerini Karşılamıyorsunuz
        </a>
    </div>
</div>

<style>
    .get-started-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }

    .welcome-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .welcome-header h1 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .subtitle {
        color: var(--gray);
        font-size: 1.2rem;
    }

    .steps-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .step-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .step-icon {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 20px;
        text-align: center;
        background: linear-gradient(45deg, var(--primary), #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .step-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .step-content h3 {
        color: var(--dark);
        margin-bottom: 15px;
        font-size: 1.35rem;
    }

    .step-content p {
        color: var(--gray);
        margin-bottom: 20px;
        line-height: 1.6;
        flex-grow: 1;
    }

    .badge {
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        border-radius: 8px;
        font-size: 0.9rem;
        display: inline-block;
    }

    .requirements-section {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 3rem;
        margin-top: 2rem;
        width: 100%;
    }

    .requirements-section h2 {
        color: var(--primary);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .completion-section {
        text-align: center;
        margin-top: 40px;
    }

    .btn-success {
        background: linear-gradient(45deg, #28a745, #218838);
        color: white;
        padding: 15px 30px;
        font-size: 1.1rem;
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .steps-container {
            grid-template-columns: 1fr;
        }

        .welcome-header h1 {
            font-size: 2rem;
        }

        .requirements-section {
            padding: 2rem;
        }

        .step-card {
            padding: 20px;
        }

        .info-card {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .info-icon {
            margin-bottom: 15px;
        }

        .info-content h2 {
            font-size: 1.3rem;
        }

        .info-content p {
            font-size: 1rem;
        }
    }

    .info-card {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 25px;
        color: white;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2);
    }

    .info-icon {
        font-size: 2.5rem;
        background: rgba(255, 255, 255, 0.2);
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-content {
        flex-grow: 1;
    }

    .info-content h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .info-content p {
        margin: 0 0 10px 0;
        font-size: 1.1rem;
        line-height: 1.5;
        opacity: 0.9;
    }

    .criteria-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 2rem;
    }

    .criteria-item {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .criteria-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .criteria-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 20px;
        text-align: center;
        background: linear-gradient(45deg, var(--primary), #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .criteria-content h3 {
        color: var(--dark);
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .criteria-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .criteria-content ul li {
        color: var(--gray);
        padding: 8px 0;
        padding-left: 25px;
        position: relative;
        line-height: 1.5;
    }

    .criteria-content ul li:before {
        content: "•";
        color: var(--primary);
        font-size: 1.2rem;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    @media (max-width: 768px) {
        .criteria-list {
            grid-template-columns: 1fr;
        }

        .criteria-item {
            padding: 20px;
        }
    }
</style>


<?php require_once __DIR__ . '/../includes/footer.php'; ?>