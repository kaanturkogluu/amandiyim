<?php
require_once __DIR__ . '/../includes/header.php';

// Sadece yeni kayıt olan mağazalar için göster
 
if ($storeData['updated_by_store_info'] != 0 ) {
    header('Location: anasayfa.php');
    exit;
}
?>

<div class="get-started-container">
    <div class="welcome-header">
        <h1>Hoş Geldiniz, <?php echo htmlspecialchars($storeData['store_name']); ?>!</h1>
        <p class="subtitle">Mağazanızı yönetmeye başlamak için size yardımcı olacağız.</p>
    </div>

    <div class="steps-container">
        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="step-content">
                <h3>1. Mağaza Bilgilerinizi Güncelleyin</h3>
                <p>Mağaza adı, adres, iletişim bilgileri ve açıklama gibi temel bilgilerinizi güncelleyin.</p>
                <a href="settings.php" class="btn btn-primary">Mağaza Ayarları</a>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="step-content">
                <h3>2. İlk Kampanyanızı Oluşturun</h3>
                <p>Müşterilerinize özel indirimler ve kampanyalar oluşturmaya başlayın.</p>
                <a href="campaigns/addcampaign.php" class="btn btn-primary">Kampanya Oluştur</a>
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="step-content">
                <h3>3. Kredinizi Kullanın</h3>
                <p>Kampanyalarınızı yayınlamak için size özel tanımlanan  kredileri kullanın.</p>
                <!-- <a href="credits.php" class="btn btn-primary">Kredi Yükle</a> -->
            </div>
        </div>

        <div class="step-card">
            <div class="step-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="step-content">
                <h3>4. İstatistiklerinizi İnceleyin</h3>
                <p>Kampanyalarınızın performansını ve müşteri etkileşimlerini takip edin.</p>
                <a href="analiz.php" class="btn btn-primary">İstatistikleri Gör</a>
            </div>
        </div>
    </div>

    <div class="completion-section">
        <button onclick="completeOnboarding()" class="btn btn-success btn-lg">
            <i class="fas fa-check"></i> Başlangıç Rehberini Tamamla
        </button>
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
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.step-card:hover {
    transform: translateY(-5px);
}

.step-icon {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 20px;
    text-align: center;
}

.step-content h3 {
    color: var(--dark);
    margin-bottom: 15px;
}

.step-content p {
    color: var(--gray);
    margin-bottom: 20px;
    line-height: 1.6;
}

.completion-section {
    text-align: center;
    margin-top: 40px;
}

.btn-success {
    background: #28a745;
    color: white;
    padding: 15px 30px;
    font-size: 1.1rem;
}

.btn-success:hover {
    background: #218838;
}

@media (max-width: 768px) {
    .steps-container {
        grid-template-columns: 1fr;
    }
    
    .welcome-header h1 {
        font-size: 2rem;
    }
}
</style>

<script>
function completeOnboarding() {
    // AJAX ile is_new_store durumunu güncelle
    fetch('<?=Helper::baseUrl()."/api/update_store_status.php"?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'complete_onboarding',
            '_token' : '<?=$csrf->getToken()?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            window.location.href = 'anasayfa.php';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>