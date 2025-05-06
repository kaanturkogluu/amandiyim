<?php

require_once __DIR__ . '/../includes/navbar.php';

require_once __DIR__ . '/../classes/MyLogin.php';
require_once __DIR__ . '/../classes/Router.php';



 
require_once __DIR__ . '/../vendor/autoload.php';
$client = new Google\Client;
$client->setClientId('579431488499-hvsmo6l60gund27l09o7o84r0m5il28k.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri(Helper::controller('googleloginController'));
$client->addScope('email');
$client->addScope('profile');


$url = $client->createAuthUrl();
$login = MyLogin::getInstance();// Kullanıcı zaten giriş yapmışsa yönlendir
 
if ($login->isLoggedIn()) {
    $redirectUrl = match ($login->getUserType()) {
        'admin' => '../panel/admin/dashboard',
        'store' => '../panel/store/dashboard',
        default => '../panel/customer/dashboard'
    };
    header("Location: $redirectUrl");
    exit;
}

$errors = $login->getErrors();
if (empty($errors)) {
    $errors = $session->getFlash("error");
}
$success = $session->get('success');
$login->clearErrors();
$login->clearSuccess();

// Font Awesome ekle
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';

// Kullanıcı tipi kontrolü
$validTypes = ['customer', 'store', 'admin'];
$userType = isset($_GET['type']) ? $_GET['type'] : 'customer';
$userType = in_array($userType, $validTypes) ? $userType : 'customer';

// Sayfa başlığı
$pageTitle = match ($userType) {
    'admin' => 'Yönetici Girişi',
    'store' => 'Mağaza Girişi',
    default => 'Müşteri Girişi'
};



// Form verilerini al
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$remember = isset($_POST['remember']) ? true : false;
?>

<style>
    /* Ana Container */
    .login-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 20px;
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 60px;
        /* Navbar için boşluk */
        margin-bottom: 60px;
        /* Footer için boşluk */
    }

    /* Form Container */
    .form-container {
        width: 100%;
        max-width: 500px;
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.3s ease-out;
        margin: auto;
    }

    /* Form Başlığı */
    .form-title {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-bottom: 30px;
        font-weight: 600;
    }

    /* Kullanıcı Tipi Seçici */
    .user-type-selector {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        justify-content: center;
    }

    .user-type-btn {
        padding: 10px 20px;
        border: 2px solid #4a90e2;
        border-radius: 5px;
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-type-btn:hover {
        background: #4a90e2;
        color: white;
    }

    .user-type-btn.active {
        background: #4a90e2;
        color: white;
    }

    /* Form Grupları */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #4a90e2;
    }

    /* Şifre Input */
    .password-input {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        padding: 5px;
    }

    .toggle-password:hover {
        color: #4a90e2;
    }

    /* Checkbox */
    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .form-check input[type="checkbox"] {
        width: 18px;
        height: 18px;
    }

    /* Butonlar */
    .btn {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: #4a90e2;
        color: white;
    }

    .btn-primary:hover {
        background: #357abd;
    }

    /* Google Giriş */
    .google-login-container {
        margin-bottom: 30px;
    }

    .google-login {
        width: 100%;
        padding: 12px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        color: #333;
        transition: background-color 0.3s ease;
    }

    .google-login:hover {
        background: #f8f9fa;
    }

    .google-icon {
        width: 20px;
        height: 20px;
    }

    /* Ayraç */
    .divider {
        position: relative;
        text-align: center;
        margin: 20px 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background: #ddd;
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }

    .divider span {
        background: white;
        padding: 0 10px;
        color: #666;
        font-size: 14px;
    }

    /* Linkler */
    .form-links {
        text-align: center;
        margin-top: 20px;
    }

    .form-link {
        color: #4a90e2;
        text-decoration: none;
        font-size: 14px;
    }

    .form-link:hover {
        text-decoration: underline;
    }

    /* Uyarılar */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    /* Animasyon */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .login-container {
            padding: 40px 20px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .form-container {
            padding: 20px;
        }

        .user-type-selector {
            flex-direction: column;
        }

        .user-type-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Başarı Mesajı Stili */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-dismissible {
        position: relative;
        padding-right: 35px;
    }

    .close {
        position: absolute;
        top: 0;
        right: 0;
        padding: 15px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
    }
</style>

<div class="login-container">
    <div class="form-container">
        <h2 class="form-title"><?php echo $pageTitle; ?></h2>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible">
                <?php echo $success; ?>
                <button type="button" class="close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
                <button type="button" class="close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>

        <div class="user-type-selector">
            <a href="?type=customer" class="user-type-btn <?php echo $userType === 'customer' ? 'active' : ''; ?>">
                <i class="fas fa-user"></i> Müşteri
            </a>
            <a href="?type=store" class="user-type-btn <?php echo $userType === 'store' ? 'active' : ''; ?>">
                <i class="fas fa-store"></i> Mağaza
            </a>
            <a href="?type=admin" class="user-type-btn <?php echo $userType === 'admin' ? 'active' : ''; ?>">
                <i class="fas fa-user-shield"></i> Yönetici
            </a>
        </div>

        <?php if ($userType === 'customer'): ?>
            <!-- Google ile Giriş -->
            <div class="google-login-container">
                <a href="<?php echo $url; ?>" class="google-login">
                    <img src="../assets/img/google.webp" alt="Google" class="google-icon">
                    Google ile Giriş Yap
                </a>
                <div class="divider">
                    <span>veya</span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Normal Giriş Formu -->
        <form action="<?=Helper::controller('loginController')?>" method="POST" class="login-form">
            <input type="hidden" name="user_type" value="<?php echo $userType; ?>">

            <div class="form-group">
                <label for="email" class="form-label">E-posta Adresi</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <div class="password-input">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input" <?php echo $remember ? 'checked' : ''; ?>>
                <label for="remember" class="form-check-label">Beni Hatırla</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Giriş Yap
            </button>

            <?php if ($userType === 'customer'): ?>
                <div class="form-links">
                    <a href="kayit.php" class="form-link">Hesabınız yok mu? Kayıt olun</a>
                </div>
            <?php endif; ?>
        </form>

        <div class="form-links">
            <a href="/sifremi-unuttum?type=<?php echo $userType; ?>" class="form-link">
                Şifremi Unuttum
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Form doğrulama
        const form = document.querySelector('.login-form');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Şifre görünürlüğü
        const togglePassword = document.querySelector('.toggle-password');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>