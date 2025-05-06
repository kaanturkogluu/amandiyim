<?php
require_once __DIR__.'/../includes/header.php';
?>

<div class="customer-content">
    <div class="content-header">
        <h1>Bildirimler</h1>
        <div class="header-actions">
            <button class="btn btn-outline btn-sm">
                <i class="fas fa-check-double"></i>
                Tümünü Okundu İşaretle
            </button>
            <button class="btn btn-outline btn-sm">
                <i class="fas fa-trash"></i>
                Tümünü Temizle
            </button>
        </div>
    </div>

    <!-- Bildirim Listesi -->
    <div class="notifications-list">
        <!-- Yeni Kampanya Bildirimi -->
        <div class="notification-item unread">
            <div class="notification-icon campaign">
                <i class="fas fa-tags"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h3>Yeni Kampanya</h3>
                    <span class="notification-time">2 saat önce</span>
                </div>
                <p>Moda Mağazası yeni bir kampanya başlattı: "Yaz İndirimi"</p>
                <div class="notification-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                        Görüntüle
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-share"></i>
                        Paylaş
                    </button>
                </div>
            </div>
        </div>

        <!-- Kampanya Bitiş Bildirimi -->
        <div class="notification-item unread">
            <div class="notification-icon warning">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h3>Kampanya Bitiş Uyarısı</h3>
                    <span class="notification-time">5 saat önce</span>
                </div>
                <p>Spor Mağazası'ndaki "Spor Ayakkabı İndirimi" kampanyası son 24 saat!</p>
                <div class="notification-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                        Görüntüle
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-share"></i>
                        Paylaş
                    </button>
                </div>
            </div>
        </div>

        <!-- Şikayet Güncelleme Bildirimi -->
        <div class="notification-item">
            <div class="notification-icon complaint">
                <i class="fas fa-flag"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h3>Şikayet Güncellemesi</h3>
                    <span class="notification-time">1 gün önce</span>
                </div>
                <p>Elektronik Mağazası'ndaki şikayetiniz incelendi ve çözüldü.</p>
                <div class="notification-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                        Detayları Gör
                    </button>
                </div>
            </div>
        </div>

        <!-- Mağaza Açılış Bildirimi -->
        <div class="notification-item">
            <div class="notification-icon store">
                <i class="fas fa-store"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h3>Mağaza Açıldı</h3>
                    <span class="notification-time">2 gün önce</span>
                </div>
                <p>Tekstil Mağazası şu anda açık ve hizmetinizde!</p>
                <div class="notification-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-directions"></i>
                        Yol Tarifi
                    </button>
                </div>
            </div>
        </div>

        <!-- Sistem Bildirimi -->
        <div class="notification-item">
            <div class="notification-icon system">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h3>Sistem Güncellemesi</h3>
                    <span class="notification-time">3 gün önce</span>
                </div>
                <p>Yeni özellikler ve iyileştirmeler ile güncellendi!</p>
                <div class="notification-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle"></i>
                        Detayları Gör
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Content Header */
.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.content-header h1 {
    font-size: 1.8rem;
    color: var(--gray-800);
}

.header-actions {
    display: flex;
    gap: 10px;
}

/* Bildirimler */
.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.notification-item {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.notification-item:hover {
    transform: translateY(-2px);
}

.notification-item.unread {
    background: var(--gray-50);
    border-left: 4px solid var(--primary);
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.notification-icon.campaign {
    background: var(--primary);
}

.notification-icon.warning {
    background: var(--warning);
}

.notification-icon.complaint {
    background: var(--danger);
}

.notification-icon.store {
    background: var(--success);
}

.notification-icon.system {
    background: var(--info);
}

.notification-content {
    flex: 1;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.notification-header h3 {
    font-size: 1.1rem;
    color: var(--gray-800);
}

.notification-time {
    font-size: 0.9rem;
    color: var(--gray-500);
}

.notification-content p {
    color: var(--gray-600);
    margin-bottom: 15px;
}

.notification-actions {
    display: flex;
    gap: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
        justify-content: space-between;
    }

    .notification-item {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .notification-header {
        flex-direction: column;
        gap: 5px;
    }

    .notification-actions {
        width: 100%;
        justify-content: center;
    }
}
</style>

<?php
require_once 'includes/footer.php';
?> 