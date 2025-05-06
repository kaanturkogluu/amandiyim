<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Hata kontrolü
    $errors = [];

    // Şifre kontrolü
    if (strlen($password) < 8) {
        $errors[] = 'Şifre en az 8 karakter olmalıdır.';
    }
    if ($password !== $password_confirm) {
        $errors[] = 'Şifreler eşleşmiyor.';
    }

    if (empty($errors)) {
        try {
            // Token kontrolü
            $stmt = $db->prepare("
                SELECT pr.*, c.id as customer_id 
                FROM password_resets pr 
                JOIN customers c ON pr.customer_id = c.id 
                WHERE pr.token = ? AND pr.expires_at > NOW()
            ");
            $stmt->execute([$token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reset) {
                // Şifreyi güncelle
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE customers SET password = ? WHERE id = ?");
                $stmt->execute([$hashed_password, $reset['customer_id']]);

                // Token'ı sil
                $stmt = $db->prepare("DELETE FROM password_resets WHERE token = ?");
                $stmt->execute([$token]);

                $_SESSION['success'] = 'Şifreniz başarıyla güncellendi. Şimdi giriş yapabilirsiniz.';
                header('Location: login.php');
                exit;
            } else {
                $_SESSION['error'] = 'Geçersiz veya süresi dolmuş şifre sıfırlama bağlantısı.';
                header('Location: forgot-password.php');
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
            header('Location: forgot-password.php');
            exit;
        }
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: reset-password.php?token=' . $token);
        exit;
    }
} else {
    header('Location: forgot-password.php');
    exit;
}
?> 