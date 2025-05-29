<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../../classes/Campaigns.php';
require_once __DIR__ . '/../../../classes/Categories.php';

$categories = new Categories();
$campaignsObj = new Campaigns();
$id = $_GET['id'] ?? 0;
$d = $campaignsObj->find($id);
$kampanyacategorisi = $categories->getCampaingAllCategories($id);
 
if (!$d) {
    header('Location: ' . Helper::adminPanelView('campaigns'));
    exit;
}

$campaignStatus = [
    'active' => ['active', 'Aktif'],
    'waiting' => ['waiting', 'Onay Bekliyor'],
    'expired' => ['expired', 'Süresi Dolmuş'],
    'suspend' => ['suspend', 'Askıya Alınmış']
];

$campaignType = [
    'discount' => 'İndirim',
    'bogo' => 'Al Bir Bedava',
    'bundle' => 'Paket İndirim',
    'discount_amount' => 'TL İndirim'
];
$campaingprefix = ['discount' => '%', 'discount_amount' => 'TL']
    ?>


<style>
    .admin-content {
        padding: 24px;
        background: #f8f9fa;
        min-height: calc(100vh - 60px);
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .content-header h1 {
        margin: 0;
        font-size: 24px;
        color: #2c3e50;
    }

    .campaign-details {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 24px;
        margin-bottom: 24px;
    }

    .detail-section {
        margin-bottom: 32px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e9ecef;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }

    .detail-item {
        background: #f8f9fa;
        padding: 16px;
        border-radius: 8px;
    }

    .detail-label {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .detail-value {
        font-size: 16px;
        color: #2c3e50;
        font-weight: 500;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
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

    .campaign-image {
        width: 100%;
        max-width: 400px;
        height: auto;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #3498db;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background: #2980b9;
    }

    .btn-warning {
        background: #f1c40f;
        color: #fff;
        border: none;
    }

    .btn-warning:hover {
        background: #f39c12;
    }

    .btn-danger {
        background: #e74c3c;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background: #c0392b;
    }

    .btn-secondary {
        background: #95a5a6;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background: #7f8c8d;
    }

    @media (max-width: 768px) {
        .admin-content {
            padding: 16px;
        }

        .content-header {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    .campaign-conditions {
        background: #fff;
        padding: 16px;
        border-radius: 8px;
        margin-top: 8px;
    }

    .campaign-conditions ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .campaign-conditions li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .campaign-conditions li:last-child {
        border-bottom: none;
    }
</style>

<div class="admin-content">
    <div class="content-header">
        <h1>Kampanya Detayları</h1>
        <div class="action-buttons">
            <button class="btn btn-secondary"
                onclick="window.location.href='<?= Helper::adminPanelView('campaigns') ?>'">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </button>
        </div>
    </div>

    <div class="campaign-details">
        <div class="detail-section">
            <h2 class="section-title">Temel Bilgiler</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Kampanya ID</div>
                    <div class="detail-value">#<?= htmlspecialchars($d['id']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Mağaza ID</div>
                    <div class="detail-value">#<?= htmlspecialchars($d['store_id']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Kampanya Başlığı</div>
                    <div class="detail-value"><?= htmlspecialchars($d['campaign_title']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Kampanya Tipi</div>
                    <div class="detail-value"><?= $campaignType[$d['campaign_type']] ?? $d['campaign_type'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Durum</div>
                    <div class="detail-value">
                        <span class="status-badge <?= $campaignStatus[$d['campaign_status']][0] ?>">
                            <?= $campaignStatus[$d['campaign_status']][1] ?>
                        </span>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Onay Durumu (Onaylı mağaza mı)</div>
                    <div class="detail-value"><?= $d['isConfirmed'] ? 'Onaylı' : 'Onay Bekliyor' ?></div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2 class="section-title">Kampanya Detayları</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Alt Açıklama</div>
                    <div class="detail-value"><?= htmlspecialchars($d['campaign_sub_description']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Detaylı Açıklama</div>
                    <div class="detail-value"><?= nl2br(htmlspecialchars($d['campaign_details'])) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">İndirim Oranı</div>
                    <div class="detail-value">
                        <?= htmlspecialchars($d['campaign_disscount_off']) ?>
                        <?= $campaingprefix[$d['campaign_type']] ?>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Minimum Alışveriş Tutarı</div>
                    <div class="detail-value"><?= htmlspecialchars($d['campaign_min_purchase']) ?> TL</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Kampanya Kategorisi</div>
                    <div class="detail-value">#<?= htmlspecialchars($d['campaign_category']) ?>
               
                    <p> <?=$kampanyacategorisi['sub_category_name']?></p>
                    <p> <?=$kampanyacategorisi['sub_sub_name']?></p>
                </div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2 class="section-title">Kampanya Koşulları</h2>
            <div class="detail-item">
                <div class="campaign-conditions">
                    <?php
                    $conditions = json_decode($d['campaign_conditions'], true);
                    if ($conditions && is_array($conditions)): ?>
                        <ul>
                            <?php foreach ($conditions as $condition): ?>
                                <li><?= htmlspecialchars($condition) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Kampanya koşulu belirtilmemiş.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2 class="section-title">Zaman Bilgileri</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Başlangıç Tarihi</div>
                    <div class="detail-value"><?= date('d.m.Y H:i', strtotime($d['campaign_start_time'])) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Bitiş Tarihi</div>
                    <div class="detail-value"><?= date('d.m.Y H:i', strtotime($d['campaign_end_time'])) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Oluşturulma Tarihi</div>
                    <div class="detail-value"><?= date('d.m.Y H:i', strtotime($d['created_at'])) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Son Güncelleme</div>
                    <div class="detail-value"><?= date('d.m.Y H:i', strtotime($d['updated_at'])) ?></div>
                </div>
            </div>
        </div>

        <?php if ($d['campaign_image']): ?>
            <div class="detail-section">
                <h2 class="section-title">Kampanya Görseli</h2>
                <?php
                $srcFull = $d['campaign_image'];
                $parts = explode('-', $srcFull, 2);
                $srcprepath = $parts[0];
                $filename = $parts[1] ?? '';

                if ($srcprepath == "stock") {
                    $src = Helper::upolads('images/stock_photos/') . $filename;
                } elseif ($srcprepath == "upload") {
                    $src = Helper::upolads('images/campaign_images/') . $filename;
                } else {
                    $src = '';
                }
                ?>
                <img src="<?= htmlspecialchars($src) ?>" alt="Kampanya Görseli" class="campaign-image">
            </div>
        <?php endif; ?>

        <div class="detail-section">
            <h2 class="section-title">İşlemler</h2>
            <div class="action-buttons">
                <?php if ($d['campaign_status'] === 'active'): ?>
                    <button class="btn btn-warning" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'suspend')">
                        <i class="fas fa-pause"></i> Askıya Al
                    </button>
                <?php elseif ($d['campaign_status'] === 'suspend'): ?>
                    <button class="btn btn-primary" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'active')">
                        <i class="fas fa-play"></i> Aktifleştir
                    </button>
                <?php endif; ?>

                <?php if ($d['campaign_status'] === 'waiting'): ?>
                    <button class="btn btn-primary" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'active')">
                        <i class="fas fa-check"></i> Onayla
                    </button>
                    <button class="btn btn-danger" onclick="updateCampaignStatus(<?= $d['id'] ?>, 'expired')">
                        <i class="fas fa-times"></i> Reddet
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    async function updateCampaignStatus(id, status) {
        if (confirm('Kampanya durumunu güncellemek istediğinizden emin misiniz?')) {
            fetch('<?= Helper::url('api/update_campaign_status.php') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    campaign_id: id,
                    status: status,
                    _token: '<?= $csrf->getToken() ?>'
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Kampanya durumu güncellenirken bir hata oluştu.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu.');
                });
        }
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>