<?php


require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../../classes/Campaigns.php';
require_once __DIR__ . '/../../../classes/CampaignsStatics.php';
require_once __DIR__ . '/../../../classes/Credits.php';





$campaigns = new Campaigns();
$istatsitik = new CampaignsStatics();
$magazaistatistik = $istatsitik->getAllStatistics();
$sayi = $campaigns->count("WHERE campaign_status='active' AND store_id=" . $session->getUserId());



$page = 1;
$limit = 3;
$aktifkampanyalar = $campaigns->getActiveCampaignsWithPage($page);
$campaingState = ['1' => 'Aktif', '0' => 'Onay Bekleniyor', '2' => 'Süresi Doldu'];
$campaingStateColor = ['1' => 'active', '0' => 'pending', '2' => 'expired'];


$credit = new Credits();
$creditsdata = $credit->getLimitedData(10);



$creditsStates = [
    'loading' => [
        'class' => 'positive',
        'proccess' => 'Yükleme İşlemi',
        'pointer' => '+'
    ],
    'spending' => [
        'class' => 'negative',
        'proccess' => 'Harcama İşlemi',
        'pointer' => '-'
    ],
    'update' => [
        'class' => 'check',
        'proccess' => 'Güncelleme İşlemi',
        'pointer' => '#'
    ]
];


?>



<div class="store-content">
    <div class="content-header">
        <h1>Kontrol Paneli</h1>

        <?php
        ?>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="addCampaign()">
                <i class="fas fa-plus"></i> Yeni Kampanya
            </button>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-info">
                <h3>Kalan Kredi</h3>
                <p class="stat-value"><?= number_format($storeData['store_credits']) ?></p>
                <p class="stat-change">
                    <button class="btn btn-outline btn-sm" onclick="showCreditModal()">
                        <i class="fas fa-plus"></i> Kredi Yükle
                    </button>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Aktif Kampanyalar</h3>
                <p class="stat-value"><?= $sayi ?></p>
                <p class="stat-change">
                    <a href="campaigns/campaigns.php" class="btn btn-outline btn-sm">
                        <i class="fas fa-eye"></i> Tümünü Gör
                    </a>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-info">
                <h3>Toplam Görüntülenme</h3>
                <p class="stat-value"><?= number_format($magazaistatistik['total_view']) ?? 0 ?></p>
                <!-- <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> %15 artış
                </p> -->
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Farklı Cihaz Görüntülenme</h3>
                <p class="stat-value"><?= number_format($magazaistatistik['total_difrent_views']) ?? 0 ?></p>
                <!-- <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> %12 artış
                </p> -->
            </div>
        </div>
        <!-- <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Kampanya Etkileşimi</h3>
                <p class="stat-value">2,150</p>
                <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> %8 artış
                </p>
            </div>
        </div> -->
    </div>

    <!-- Aktif Kampanyalar -->
    <div class="recent-activities">
        <div class="section-header">
            <h2>Aktif Kampanyalar</h2>
            <a href="campaigns/campaigns.php" class="btn btn-outline">Tümünü Gör</a>
        </div>
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
                    if ($aktifkampanyalar['data']) {

                        foreach ($aktifkampanyalar['data'] as $a) {
                            ?>

                            <tr>




                                <td><?= $a['campaign_title'] ?> </td>
                                <td><?= $a['campaign_title'] ?> </td>
                                <td><?= $a['campaign_disscount_off'] ?> </td>
                                <td><?= $a['campaign_start_time'] ?> </td>
                                <td><?= $a['campaign_end_time'] ?> </td>

                                <td><span
                                        class="status-badge <?= $campaingStateColor[$a['isConfirmed']] ?>"><?= $campaingState[$a['isConfirmed']] ?></span>
                                </td>

                                </td>
                            </tr>
                            <?php

                            ?>

                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7"> Yeni Bir Kampanya <a href="campaigns/addcampaign.php">Başlatın</a></td>
                        </tr><?php
                    }

                    ?>


                </tbody>
            </table>
        </div>
    </div>

    <!-- Kredi Geçmişi -->
    <div class="recent-activities">
        <div class="section-header">
            <h2>Kredi Geçmişi</h2>
            <!-- <button class="btn btn-outline" onclick="exportCreditHistory()">
                <i class="fas fa-download"></i> Dışa Aktar
            </button> -->
        </div>
        <div class="content-table">
            <table>
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>İşlem</th>
                        <th>Miktar</th>
                        <th>Kalan</th>
                        <th>Detay</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($creditsdata) {
                        foreach ($creditsdata as $a) {

                            ?>

                            <tr>
                                <td><?= $a['created_at'] ?></td>
                                <td><?= $creditsStates[$a['process']]['proccess'] ?></td>
                                <td class="<?= $creditsStates[$a['process']]['class'] ?>">
                                    <?= $creditsStates[$a['process']]['pointer'] ?>         <?= number_format($a['amount']) ?>
                                </td>
                                <td><?= number_format($a['credit_value']); ?></td>
                                <td><?= json_decode($a['credit_details'], true)['description'] ?></td>
                            </tr>
                            <?php

                        }
                    }
                    ?>


                </tbody>
            </table>
        </div>
    </div>
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
        window.location.href = 'campaigns/addcampaign.php';
    }

    function editCampaign(id) {
        window.location.href = 'campaigns.php?action=edit&id=' + id;
    }

    function pauseCampaign(id) {
        if (confirm('Bu kampanyayı durdurmak istediğinize emin misiniz?')) {
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

    function exportCreditHistory() {
        console.log('Kredi geçmişi dışa aktarılıyor...');
    }
</script>

<style>
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

    .positive {
        color: #2E7D32;
    }

    .negative {
        color: #C62828;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 0.8rem;
    }
</style>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>