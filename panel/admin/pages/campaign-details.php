<?php
$id = $_GET['id'];

require_once __DIR__ . "/../../../classes/Campaigns.php";
require_once __DIR__ . "/../includes/header.php";
$campaign = new Campaigns();

$d = $campaign->find($id);
$campaingTypes = ['bundle'=>'Özel Paket', 'discount'=>'indirim',  'bogo'=>'Bir Alana Bir Bedava']

?>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Kampanya Detayları</h1>
        <div>
            <a href="<?= Helper::adminPanelView('campaigns') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="row">
        <!-- Sol Kolon - Kampanya Bilgileri -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="campaign-header mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <h2> Store id : <?=$d['store_id']?></h2>
                            <h2 class="mb-0"><?= htmlspecialchars($d['campaign_title']) ?></h2>
                            <span class="status-badge <?= $d['campaign_status'] ?> ms-3">
                                <?= ucfirst($d['campaign_status']) ?>
                            </span>
                        </div>
                        <p class="text-muted mb-0"><?= htmlspecialchars($d['campaign_sub_description']) ?></p>
                    </div>

                    <div class="campaign-details">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted">Başlangıç Tarihi</label>
                                    <p class="mb-0"><?= date('d.m.Y H:i', strtotime($d['campaign_start_time'])) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted">Bitiş Tarihi</label>
                                    <p class="mb-0"><?= date('d.m.Y H:i', strtotime($d['campaign_end_time'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted">Kampanya Tipi</label>
                                    <p class="mb-0"><?= $campaingTypes[$d['campaign_type']] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted">Minimum Alışveriş Tutarı</label>
                                    <p class="mb-0"><?= number_format($d['campaign_min_purchase'], 2) ?> TL</p>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item mb-4">
                            <label class="text-muted">Kampanya Detayları</label>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($d['campaign_details'])) ?></p>
                        </div>

                        <div class="detail-item">
                            <label class="text-muted">Kampanya Koşulları</label>
                            <ul class="list-unstyled mb-0">
                                <?php
                                $conditions = json_decode($d['campaign_conditions'], true);
                                foreach ($conditions as $condition):
                                    ?>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <?= htmlspecialchars($condition) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Kolon - Kampanya Görseli ve Durum -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="campaign-image mb-4">
                        <img src="<?= Helper::upolads('images/campaign_images/') .
                         ltrim($d['campaign_image'],'upload-') ?>"
                            alt="<?= htmlspecialchars($d['campaign_title']) ?>" class="img-fluid rounded">
                    </div>

                    <div class="campaign-status">
                        <h5 class="mb-3">Kampanya Durumu</h5>
                        <div class="d-grid gap-2">
                            <?php if ($d['campaign_status'] === 'waiting'): ?>
                                <button class="btn btn-success" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'active')">
                                    <i class="fas fa-check-circle me-2"></i> Onayla
                                </button>
                                <button class="btn btn-danger" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'suspend')">
                                    <i class="fas fa-ban me-2"></i> Reddet
                                </button>
                            <?php elseif ($d['campaign_status'] === 'active'): ?>
                                <button class="btn btn-warning" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'suspend')">
                                    <i class="fas fa-pause-circle me-2"></i> Askıya Al
                                </button>
                                <button class="btn btn-danger" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'expired')">
                                    <i class="fas fa-times-circle me-2"></i> Sonlandır
                                </button>
                            <?php elseif ($d['campaign_status'] === 'suspend'): ?>
                                <button class="btn btn-success" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'active')">
                                    <i class="fas fa-play-circle me-2"></i> Aktifleştir
                                </button>
                                <button class="btn btn-danger" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'expired')">
                                    <i class="fas fa-times-circle me-2"></i> Sonlandır
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-body {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    .campaign-header h2 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .detail-item {
        margin-bottom: 1.5rem;
    }

    .detail-item label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .detail-item p {
        font-size: 1rem;
        color: #2c3e50;
        font-weight: 500;
        margin-bottom: 0;
    }

    .campaign-image {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .campaign-image img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .campaign-image:hover img {
        transform: scale(1.02);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.active {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .status-badge.waiting {
        background-color: #fff3e0;
        color: #ef6c00;
        border: 1px solid #ffcc80;
    }

    .status-badge.expired {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .status-badge.suspend {
        background-color: #eceff1;
        color: #455a64;
        border: 1px solid #b0bec5;
    }

    .list-unstyled {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
    }

    .list-unstyled li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
    }

    .list-unstyled li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .list-unstyled li i {
        margin-right: 0.75rem;
        font-size: 1rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #2e7d32;
        border-color: #2e7d32;
    }

    .btn-success:hover {
        background-color: #1b5e20;
        border-color: #1b5e20;
    }

    .btn-danger {
        background-color: #c62828;
        border-color: #c62828;
    }

    .btn-danger:hover {
        background-color: #b71c1c;
        border-color: #b71c1c;
    }

    .btn i {
        margin-right: 0.5rem;
    }

    @media (max-width: 768px) {
        .content-body {
            padding: 15px;
        }

        .card-body {
            padding: 1rem;
        }

        .campaign-header h2 {
            font-size: 1.5rem;
        }

        .campaign-image img {
            height: 200px;
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.7rem;
        }
    }
</style>

<script>
    function updateCampaignStatus(campaignId, status) {
        if (confirm('Kampanya durumunu güncellemek istediğinizden emin misiniz?')) {
            fetch('<?=Helper::baseUrl()?>/api/update_campaign_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    campaign_id: campaignId,
                    status: status,
                    _token: '<?= $csrf->getToken() ?>'
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
        }
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>