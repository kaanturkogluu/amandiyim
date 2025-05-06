<?php
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../classes/Helper.php';

// Kullanıcı zaten giriş yapmışsa yönlendir
 

// Hata mesajlarını al
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

// Form verilerini al
$formData = isset($_SESSION['old']) ? $_SESSION['old'] : [];
unset($_SESSION['old']);
?>

<style>
/* Ana Container */
.register-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 80px 20px;
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 60px;
    margin-bottom: 60px;
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

/* Google Kayıt */
.google-register-container {
    margin-bottom: 30px;
}

.google-register {
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

.google-register:hover {
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

/* Telefon Input */
.phone-input {
    display: flex;
    gap: 10px;
}

.phone-prefix {
    width: 100px;
    flex-shrink: 0;
}

.phone-number {
    flex-grow: 1;
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
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
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
    .register-container {
        padding: 40px 20px;
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .form-container {
        padding: 20px;
    }

    .phone-input {
        flex-direction: column;
    }

    .phone-prefix {
        width: 100%;
    }
}
</style>

<div class="register-container">
    <div class="form-container">
        <h2 class="form-title">Müşteri Kaydı</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Google ile Kayıt -->
       

        <!-- Normal Kayıt Formu -->
        <form action="<?=Helper::controller('registerController')?>" method="POST" class="register-form">
            <div class="form-group">
                <label for="name" class="form-label">Ad Soyad</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">E-posta Adresi</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" 
                       minlength="6" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" minlength="6" required>
            </div>

            <div class="form-check">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    <a href="/kullanim-kosullari" class="form-link">Kullanım Koşulları</a>'nı ve 
                    <a href="/gizlilik-politikasi" class="form-link">Gizlilik Politikası</a>'nı okudum ve kabul ediyorum
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Kayıt Ol
            </button>
        </form>

        <div class="form-links">
            <a href="/giris" class="form-link">Zaten hesabınız var mı? Giriş yapın</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form doğrulama
    const form = document.querySelector('.register-form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Telefon numarası formatı
    const phoneInput = document.querySelector('#phone');
    phoneInput.addEventListener('input', function(e) {
        // Sadece rakamları al
        let value = e.target.value.replace(/\D/g, '');
        
        // 10 haneden fazla girilirse kes
        if (value.length > 10) {
            value = value.slice(0, 10);
        }
        
        // Formatla: 5XX XXX XX XX
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
            if (i === 3 || i === 6 || i === 8) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        
        e.target.value = formattedValue;
    });

    // Form gönderilmeden önce telefon numarasını kontrol et
    form.addEventListener('submit', function(e) {
        const phone = phoneInput.value.replace(/\D/g, '');
        if (phone.length !== 10 || phone[0] !== '5') {
            e.preventDefault();
            alert('Lütfen geçerli bir telefon numarası giriniz. (Örnek: 5XX XXX XX XX)');
        }
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?> 