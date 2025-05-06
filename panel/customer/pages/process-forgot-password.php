<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    try {
        // E-posta kontrolü
        $stmt = $db->prepare("SELECT id, name FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customer) {
            // Benzersiz token oluştur
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Önceki tokenları temizle
            $stmt = $db->prepare("DELETE FROM password_resets WHERE customer_id = ?");
            $stmt->execute([$customer['id']]);

            // Yeni token kaydet
            $stmt = $db->prepare("
                INSERT INTO password_resets (customer_id, token, expires_at) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$customer['id'], $token, $expires]);

            // E-posta gönder
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/customer/reset-password.php?token=" . $token;
            
            $to = $email;
            $subject = "Şifre Sıfırlama";
            $message = "
                <html>
                <head>
                    <title>Şifre Sıfırlama</title>
                </head>
                <body>
                    <h2>Merhaba {$customer['name']},</h2>
                    <p>Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayın:</p>
                    <p><a href='{$reset_link}'>{$reset_link}</a></p>
                    <p>Bu bağlantı 1 saat süreyle geçerlidir.</p>
                    <p>Eğer şifre sıfırlama talebinde bulunmadıysanız, bu e-postayı dikkate almayın.</p>
                    <br>
                    <p>Saygılarımızla,<br>Amandiyim Ekibi</p>
                </body>
                </html>
            ";

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: noreply@amandiyim.com\r\n";

            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['success'] = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
            } else {
                $_SESSION['error'] = 'E-posta gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
            }
        } else {
            $_SESSION['success'] = 'Eğer bu e-posta adresi kayıtlıysa, şifre sıfırlama bağlantısı gönderilecektir.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
    }

    header('Location: forgot-password.php');
    exit;
} else {
    header('Location: forgot-password.php');
    exit;
}
?> 