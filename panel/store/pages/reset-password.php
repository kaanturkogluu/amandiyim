<?php
require_once 'includes/config.php';

// Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
if (isset($_SESSION['store_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

// Token kontrolü
$token = $_GET['token'] ?? '';
if (empty($token)) {
    header('Location: forgot-password.php');
    exit;
}

// Token'ı kontrol et
$stmt = $db->prepare('SELECT pr.*, s.email FROM password_resets pr JOIN stores s ON pr.store_id = s.id WHERE pr.token = ? AND pr.expires_at > NOW() AND pr.used = 0');
$stmt->execute([$token]);
$reset = $stmt->fetch();

if (!$reset) {
    $error = 'Geçersiz veya süresi dolmuş şifre sıfırlama bağlantısı.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    if (empty($password) || empty($password_confirm)) {
        $error = 'Lütfen tüm alanları doldurun.';
    } elseif (strlen($password) < 6) {
        $error = 'Şifre en az 6 karakter olmalıdır.';
    } elseif ($password !== $password_confirm) {
        $error = 'Şifreler eşleşmiyor.';
    } else {
        // Şifreyi güncelle
        $stmt = $db->prepare('UPDATE stores SET password = ? WHERE id = ?');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        if ($stmt->execute([$hashed_password, $reset['store_id']])) {
            // Token'ı kullanıldı olarak işaretle
            $stmt = $db->prepare('UPDATE password_resets SET used = 1 WHERE id = ?');
            $stmt->execute([$reset['id']]);
            
            $success = 'Şifreniz başarıyla güncellendi. Şimdi giriş yapabilirsiniz.';
        } else {
            $error = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırla - Amandiyim</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="assets/images/logo.png" alt="Amandiyim Logo" class="logo">
                <h1>Şifre Sıfırla</h1>
                <p>Yeni şifrenizi belirleyin.</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (!$error && !$success): ?>
                <form method="POST" class="login-form">
                    <div class="form-group">
                        <label for="password">Yeni Şifre</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm">Yeni Şifre Tekrar</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Şifreyi Güncelle</button>
                </form>
            <?php endif; ?>
            
            <div class="login-footer">
                <p><a href="login.php">Giriş sayfasına dön</a></p>
            </div>
        </div>
    </div>
</body>
</html> 