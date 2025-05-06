<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $terms = isset($_POST['terms']) ? true : false;

    // Hata kontrolü
    $errors = [];

    // E-posta kontrolü
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Geçerli bir e-posta adresi giriniz.';
    }

    // E-posta benzersizlik kontrolü
    try {
        $stmt = $db->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = 'Bu e-posta adresi zaten kayıtlı.';
        }
    } catch (PDOException $e) {
        $errors[] = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
    }

    // Şifre kontrolü
    if (strlen($password) < 8) {
        $errors[] = 'Şifre en az 8 karakter olmalıdır.';
    }
    if ($password !== $password_confirm) {
        $errors[] = 'Şifreler eşleşmiyor.';
    }

    // Kullanım koşulları kontrolü
    if (!$terms) {
        $errors[] = 'Kullanım koşullarını kabul etmelisiniz.';
    }

    // Hata yoksa kayıt işlemini gerçekleştir
    if (empty($errors)) {
        try {
            // Profil fotoğrafı yükleme
            $profile_image = null;
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $max_size = 2 * 1024 * 1024; // 2MB

                if (!in_array($_FILES['profile_image']['type'], $allowed_types)) {
                    $errors[] = 'Sadece JPG, PNG ve GIF formatları desteklenir.';
                } elseif ($_FILES['profile_image']['size'] > $max_size) {
                    $errors[] = 'Dosya boyutu 2MB\'dan küçük olmalıdır.';
                } else {
                    $upload_dir = '../uploads/customers/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                    $file_name = uniqid() . '.' . $file_extension;
                    $target_path = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
                        $profile_image = 'uploads/customers/' . $file_name;
                    }
                }
            }

            if (empty($errors)) {
                // Müşteri kaydı
                $stmt = $db->prepare("
                    INSERT INTO customers (name, email, phone, password, profile_image, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->execute([$name, $email, $phone, $hashed_password, $profile_image]);

                // Başarılı kayıt sonrası oturum başlat
                $_SESSION['customer_id'] = $db->lastInsertId();
                $_SESSION['customer_name'] = $name;
                $_SESSION['customer_email'] = $email;

                // Ana sayfaya yönlendir
                header('Location: index.php');
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = 'Kayıt işlemi sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
        }
    }

    // Hata varsa kayıt sayfasına geri dön
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        header('Location: register.php');
        exit;
    }
} else {
    // POST isteği değilse kayıt sayfasına yönlendir
    header('Location: register.php');
    exit;
}
?> 