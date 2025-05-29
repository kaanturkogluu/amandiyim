<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../../../classes/Campaigns.php';
$errors = $session->getFlash('error');
$success = $session->getFlash('success');
$currentFilter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

if ($errors) {
    echo '<div class="alert alert-danger">' . $errors . '</div>';
}
if ($success) {
    echo '<div class="alert alert-success">' . $success . '</div>';
}
$campaingState =
    [
        'active' => ['Aktif', 'active'],
        'waiting' => ['Onay Bekleniyor', 'pending'],
        'expired' => ['Süresi Doldu', 'expired'],
        'suspend' => ['Askıya Alınmış', 'suspend']
    ];


$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$campaigns = new Campaigns();

if (isset($_GET['search']) && !empty($_GET['search'])) {


    $search = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');


    $stores = $storesObject->searchStores(['store_name' => $search, 'store_owner_phone' => $search]);
    $stores['total_pages'] = 'none';

} else {
    switch ($currentFilter) {
        case 'all':
            $campaigns = $campaigns->getAllCampaignsWithPage($page);
            break;

        case 'active':
            $campaigns = $campaigns->getActiveCampaignsWithPage($page);

            break;
        case 'waiting':
            $campaigns = $campaigns->getWaitingCampaignsWithPage($page);
            break;
        case 'expired':
            $campaigns = $campaigns->getExpiredCampaignsWithPage($page);
            break;
        default:
            // Geçersiz filtre geldiğinde varsayılanı çalıştır
            $campaigns = $campaigns->getActiveCampaignsWithPage($page);
            break;
    }

}
// $campaigns = $campaigns->getAllCampaignsWithPage($page);
$campaigndetails = $campaigns['data'];
$totalPages = $campaigns['total_pages'];


?>



<div class="store-content">
    <div class="content-header">
        <h1>Kampanyalarım</h1>
        <div class="header-actions">
            <a class="btn btn-primary" onclick="addCampaign()">
                <i class="fas fa-plus"></i> Yeni Kampanya
            </a>
        </div>
    </div>

    <!-- Kredi Bilgisi -->
    <div class="credit-info">
        <div class="credit-balance">
            <i class="fas fa-coins"></i>
            <div class="credit-details">
                <h3>Kalan Kredi</h3>
                <p class="credit-amount"><?= number_format($storeData['store_credits']) ?></p>
            </div>
        </div>
        <button class="btn btn-outline" onclick="showCreditModal()">
            <i class="fas fa-plus"></i> Kredi Yükle
        </button>
    </div>

    <!-- Filtreler -->
    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Kampanya ara..." onkeyup="searchCampaigns(this.value)">
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active"
                onclick="window.location.href='<?= Helper::storeViewWithParams('campaigns/campaigns', 'filter', 'all') ?>'">Tümü</button>
            <button class="btn btn-outline"
                onclick="window.location.href='<?= Helper::storeViewWithParams('campaigns/campaigns', 'filter', 'active') ?>'">Aktif</button>
            <button class="btn btn-outline"
                onclick="window.location.href='<?= Helper::storeViewWithParams('campaigns/campaigns', 'filter', 'waiting') ?>'">Bekleyen</button>
            <button class="btn btn-outline"
                onclick="window.location.href='<?= Helper::storeViewWithParams('campaigns/campaigns', 'filter', 'expired') ?>'">Süresi
                Dolmuş</button>
        </div>
    </div>

    <!-- Kampanyalar Tablosu -->
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Kampanya Adı</th>
                    <th>İndirim Oranı</th>
                    <th>Başlangıç</th>
                    <th>Bitiş</th>

                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($campaigndetails as $campaign) {
                    ?>
                    <tr>
                        <td><?= $campaign['campaign_title'] ?></td>
                        <td><?= $campaign['campaign_disscount_off'] ?></td>
                        <td><?= $campaign['campaign_start_time'] ?></td>
                        <td><?= $campaign['campaign_end_time'] ?></td>

                        <td><span
                                class="status-badge <?= $campaingState[$campaign['campaign_status']][1] ?>"><?= $campaingState[$campaign['campaign_status']][0] ?></span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- <button class="btn-icon" title="Düzenle" onclick="editCampaign(1)">
                                    <i class="fas fa-edit"></i>
                                </button> -->
                                <?php 
                                if($campaign['campaign_status'] =='active'){
?>   <button class="btn-icon" title="Durdur" onclick="pauseCampaign(<?= $campaign['id'] ?>)">
<i class="fas fa-pause"></i>
</button> <?php
                                }
                                ?>
                             
                            </div>
                        </td>
                    </tr>

                    <?php
                }
                ?>

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



<!-- Kredi Yükleme Modal -->
<div class="modal" id="creditModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Kredi Yükleme</h2>
            <button class="close-modal" onclick="closeCreditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="coming-soon">
                <i class="fas fa-clock"></i>
                <h3>Yakında</h3>
                <p>Kredi yükleme sistemi yakında aktif olacaktır.</p>
                <p>Şu an için kredi yüklemeleri admin tarafından yapılmaktadır.</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Kampanya İşlemleri
    function addCampaign() {

        window.location.href = "<?= Helper::storePanelView('campaigns/addcampaign') ?>";
    }



    function editCampaign(id) {
        // Kampanya düzenleme modalını aç
        document.getElementById('campaignModal').classList.add('active');
        // Kampanya bilgilerini getir ve formu doldur
    }



    function pauseCampaign(id) {
        if (confirm('Bu kampanyayı durdurmak istediğinize emin misiniz?')) {
            if (confirm('Kampanya İptal Edilmesi Durumunda Kredi İadesi Yapılmayacaktır')) {
                fetch('<?=Helper::url()?>api/pauseCampaing.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        campaign_id: id,
                        '_token': '<?= $csrf->getToken() ?>',
                        'status': 'suspend'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                      
                        if (data.success) {
                            alert('Kampanya başarıyla durduruldu');
                            location.reload();
                        } else {
                            alert('Kampanya durdurulurken bir hata oluştu: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                    });
            }
            console.log('Kampanya durduruldu:', id);
        }
    }

    // Kredi İşlemleri
    function showCreditModal() {
        document.getElementById('creditModal').classList.add('active');
    }

    function closeCreditModal() {
        document.getElementById('creditModal').classList.remove('active');
    }

    // Arama ve Filtreleme
    function searchCampaigns(query) {
        console.log('Kampanya arama:', query);
    }

    function filterCampaigns(filter) {
        const buttons = document.querySelectorAll('.filter-buttons .btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        console.log('Kampanya filtreleme:', filter);
    }
</script>

<style>
    .credit-info {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow-sm);
    }

    .credit-balance {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .credit-balance i {
        font-size: 2rem;
        color: var(--primary);
    }

    .credit-details h3 {
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 5px;
    }

    .credit-amount {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
    }

    .form-text {
        font-size: 0.8rem;
        color: var(--gray);
        margin-top: 5px;
        display: block;
    }

    .coming-soon {
        text-align: center;
        padding: 40px 20px;
    }

    .coming-soon i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .coming-soon h3 {
        font-size: 1.5rem;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .coming-soon p {
        color: var(--gray);
        margin-bottom: 5px;
    }
</style>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>