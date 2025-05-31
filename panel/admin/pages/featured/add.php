<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../../../classes/Campaigns.php';

$campaigns = new Campaigns();
$activeCampaigns = $campaigns->getallactiveCampaing();
?>

<div class="add-featured-page">
    <div class="page-header">
        <h1>Öne Çıkarılan Kampanya Ekle</h1>
        <a href="featured.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>

    <div class="add-form">
        <form action="<?= Helper::controller('featuredController') ?>" method="POST">
            <input type="hidden" name="action" value="add">
            <?= $csrf->getTokenField(); ?>
            <div class="form-group">
                <label>Kampanya Seçin</label>
                <select class="form-control" name="campaign_id" required>
                    <option value="">Kampanya Seçin</option>
                    <?php foreach ($activeCampaigns as $campaign): ?>
                        <option value="<?= $campaign['id'] ?>">
                            <?= $campaign['campaign_title'] ?> - <?= $campaign['store_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Başlangıç Tarihi</label>
                <input type="datetime-local" class="form-control" name="featured_started_date" required>
            </div>

            <div class="form-group">
                <label>Bitiş Tarihi</label>
                <input type="datetime-local" class="form-control" name="featured_ended_date" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="featured.php" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .add-featured-page {
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .add-form {
        max-width: 600px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
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

    .btn:hover {
        opacity: 0.9;
    }
</style>