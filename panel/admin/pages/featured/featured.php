<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../../../classes/FeaturedCampaigns.php';
require_once __DIR__ . '/../../../../classes/Campaigns.php';

$featuredCampaigns = new FeaturedCampaigns();
$campaigns = new Campaigns();

// Öne çıkarılan kampanyaları getir
$featuredList = $featuredCampaigns->getFeaturedCampaingForList();
?>

<div class="featured-campaigns-page">
    <div class="page-header">
        <h1>Öne Çıkarılan Kampanyalar</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Yeni Kampanya Ekle
        </a>
    </div>

    <div class="featured-campaigns-list">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sıra</th>
                        <th>Kampanya</th>
                        <th>Mağaza</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="featuredCampaignsList">
                    <?php foreach ($featuredList as $featured): ?>
                        <tr data-id="<?= $featured['id'] ?>">
                            <td>
                                <div class="order-controls">
                                    <form action="<?= Helper::controller('featuredController') ?>" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="move">
                                        <input type="hidden" name="id" value="<?= $featured['id'] ?>">
                                        <input type="hidden" name="direction" value="up">
                                        <input type="hidden" name="order" value="<?=$featured['orderNumber']?>">
                                        <?= $csrf->getTokenField(); ?>
                                        <button type="submit" class="btn btn-sm btn-light">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </form>
                                    <span class="order-number"><?= $featured['orderNumber'] ?></span>
                                    <form action="<?= Helper::controller('featuredController') ?>" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="move">
                                        <input type="hidden" name="id" value="<?= $featured['id'] ?>">
                                        <input type="hidden" name="order" value="<?=$featured['orderNumber']?>">
                                       <input type="hidden" name="direction" value="down">
                                        <?= $csrf->getTokenField(); ?>
                                        <button type="submit" class="btn btn-sm btn-light">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td><?= $featured['campaign_title'] ?></td>
                            <td><?= $featured['store_name'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($featured['featured_started_date'])) ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($featured['featured_ended_date'])) ?></td>
                            <td>
                                <span
                                    class="badge <?= strtotime($featured['featured_ended_date']) > time() ? 'badge-success' : 'badge-danger' ?>">
                                    <?= strtotime($featured['featured_ended_date']) > time() ? 'Aktif' : 'Süresi Doldu' ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?= Helper::controller('featuredController') ?>" method="POST">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $featured['id'] ?>">
                                    <?= $csrf->getTokenField(); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Bu kampanyayı öne çıkarılanlardan kaldırmak istediğinize emin misiniz?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .featured-campaigns-page {
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .order-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-number {
        min-width: 30px;
        text-align: center;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table th {
        background-color: #f8f9fa;
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 12px;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }
</style>
<?php
require_once __DIR__ . '/../../includes/footer.php';
?>