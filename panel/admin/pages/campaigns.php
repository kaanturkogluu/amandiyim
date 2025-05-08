<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../../classes/Campaigns.php';

$campaignsObj = new Campaigns();

$page = $_GET['page'] ?? 1;


$filter = $_GET['filter'] ?? 'waiting';
switch ($filter) {

    case 'all':
        $data = $campaignsObj->getCampaignWithPageForAdmin($page, 'all');

        break;

    case 'active':
        $data = $campaignsObj->getCampaignWithPageForAdmin($page, 'active');

        break;

    case 'expired':
        $data = $campaignsObj->getCampaignWithPageForAdmin($page, 'expired');

        break;
    case 'waiting':
        $data = $campaignsObj->getCampaignWithPageForAdmin($page, 'waiting');


        break;
}
$kampdata = $data['data'];
$totalPages = $data['total_pages'];

$campaignStatus = [
    'active' => ['active', 'Aktif'],
    'waiting' => ['waiting', 'Onay Bekliyor'],
    'expired' => ['expired', 'Süresi Dolmus'],
    'suspend' => ['suspend', 'Askıya Alınmış']
]

    ?>

<style>
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
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

    /* Hover efektleri */
    .status-badge:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    /* Responsive tasarım için */
    @media (max-width: 768px) {
        .status-badge {
            padding: 4px 8px;
            font-size: 11px;
        }
    }
</style>

<div class="admin-content">
    <div class="content-header">
        <h1>Kampanyalar</h1>
        <button class="btn btn-primary" onclick="openAddCampaignModal()">
            <i class="fas fa-plus"></i> Yeni Kampanya Ekle
        </button>
    </div>

    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Kampanya ara..." id="campaignSearch">
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active"
                onclick="window.location.href='<?= Helper::adminViewWithParams('campaigns', 'filter', 'all') ?>'"
                data-filter="all">Tümü</button>
            <button class="btn btn-outline" data-filter="active"
                onclick="window.location.href='<?= Helper::adminViewWithParams('campaigns', 'filter', 'active') ?>'">Aktif</button>
            <button class="btn btn-outline" data-filter="expired"
                onclick="window.location.href='<?= Helper::adminViewWithParams('campaigns', 'filter', 'expired') ?>'">Süresi
                Dolmuş</button>
            <button class="btn btn-outline" data-filter="pending"
                onclick="window.location.href='<?= Helper::adminViewWithParams('campaigns', 'filter', 'waiting') ?>'">Onay
                Bekleyen</button>
        </div>
    </div>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Mağaza</th>
                    <th>Kampanya Başlığı</th>

                    <th>Başlangıç</th>
                    <th>Bitiş</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <!-- Örnek veri -->
                <?php
                if ($kampdata) {


                    foreach ($kampdata as $k) {
                        ?>

                        <td><?= $k['store_id'] ?></td>
                        <td><?= $k['campaign_title'] ?></td>

                        <td><?= $k['campaign_start_time'] ?></td>
                        <td><?= $k['campaign_end_time'] ?></td>
                        <td><span
                                class="status-badge <?= $campaignStatus[$k['campaign_status']][0] ?>"><?= $campaignStatus[$k['campaign_status']][1] ?></span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-icon"
                                    onclick="window.location.href='<?= Helper::adminViewWithParams('campaign-details', 'id', $k['id']) ?>'">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-icon" onclick="deleteCampaign(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <?php
                    }
                }
                ?>
                <tr>

                </tr>
            </tbody>
        </table>
    </div>

    <?php
    if (is_numeric($totalPages)) {
        ?>
        <div class="pagination">
            <!-- Önceki Sayfa Butonu -->
            <button class="btn btn-outline <?= $page <= 1 ? 'disabled' : '' ?>"
                onclick="window.location.href='?page=<?= $page - 1 ?>&filter=<?= $currentFilter ?>'">
                <i class="fas fa-chevron-left"></i>
            </button>


            <!-- Sayfa Numaraları -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <button class="btn btn-outline <?= $i == $page ? 'active' : '' ?>"
                    onclick="window.location.href='?page=<?= $i ?>&filter=<?= $currentFilter ?>'">
                    <?= $i ?>
                </button>
            <?php endfor; ?>


            <!-- Sonraki Sayfa Butonu -->
            <button class="btn btn-outline <?= $page >= $totalPages ? 'disabled' : '' ?>"
                onclick="window.location.href='?page=<?= $page + 1 ?>&filter=<?= $currentFilter ?>'">
                <i class="fas fa-chevron-right"></i>
            </button>

        </div>

        <?php
    }
    ?>

</div>



<script>
    // Modal işlemleri







    // Arama işlevi
    document.getElementById('campaignSearch').addEventListener('input', function (e) {
        // Arama işlemi
    });

    // Filtreleme işlevi
    document.querySelectorAll('.filter-buttons .btn').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            // Filtreleme işlemi
        });
    });
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>