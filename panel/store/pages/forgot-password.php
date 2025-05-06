<?php
require_once 'includes/config.php';

// Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
if (isset($_SESSION['store_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean($_POST['email']);
    
    if (empty($email)) {
        $error = 'Lütfen e-posta adresinizi girin.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi girin.';
    } else {
        // E-posta adresi kontrolü
        $stmt = $db->prepare('SELECT id, name FROM stores WHERE email = ? AND status = "active"');
        $stmt->execute([$email]);
        $store = $stmt->fetch();
        
        if ($store) {
            // Şifre sıfırlama token'ı oluştur
            $token = generateToken();
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Token'ı veritabanına kaydet
            $stmt = $db->prepare('INSERT INTO password_resets (store_id, token, expires_at) VALUES (?, ?, ?)');
            if ($stmt->execute([$store['id'], $token, $expires])) {
                // E-posta gönderme işlemi burada yapılacak
                // Şimdilik başarılı mesajı gösteriyoruz
                $success = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
            } else {
                $error = 'Bir hata oluştu. Lütfen tekrar deneyin.';
            }
        } else {
            // Güvenlik için aynı mesajı göster
            $success = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifremi Unuttum - Amandiyim</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <a href="index.php" class="logo">Amandi<span>yim</span></a>
            <div class="login-header">
                <h1>Şifremi Unuttum</h1>
                <p>E-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim.</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">E-posta Adresi</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Şifre Sıfırlama Bağlantısı Gönder</button>
            </form>
            
            <div class="login-footer">
                <p><a href="login.php">Giriş sayfasına dön</a></p>
            </div>
        </div>
    </div>
</body>
</html> 