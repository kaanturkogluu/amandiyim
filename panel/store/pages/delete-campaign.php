<?php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

// Oturum kontrolü
if (!isAuthenticated()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campaign_id'])) {
    $store_id = $_SESSION['store_id'];
    $campaign_id = filter_var($_POST['campaign_id'], FILTER_VALIDATE_INT);

    try {
        // Kampanya görselini sil
        $stmt = $db->prepare("SELECT image FROM campaigns WHERE id = ? AND store_id = ?");
        $stmt->execute([$campaign_id, $store_id]);
        $campaign = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campaign && $campaign['image']) {
            $image_path = '../' . $campaign['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Kampanyayı sil
        $stmt = $db->prepare("DELETE FROM campaigns WHERE id = ? AND store_id = ?");
        $stmt->execute([$campaign_id, $store_id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = 'Kampanya başarıyla silindi.';
        } else {
            $_SESSION['error'] = 'Kampanya bulunamadı veya silme yetkiniz yok.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
    }
}

header('Location: campaigns.php');
exit;
?> 