<?php
require_once 'includes/header.php';
require_once 'includes/auth.php';
redirectIfAuthenticated();
?>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h1>Müşteri Kaydı</h1>
            <p>Yeni bir hesap oluşturun</p>
        </div>

        <form class="auth-form" action="process-register.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Ad Soyad</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" required placeholder="Adınız Soyadınız">
                </div>
            </div>

            <div class="form-group">
                <label for="email">E-posta Adresi</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="ornek@email.com">
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Telefon Numarası</label>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="phone" name="phone" required placeholder="(5XX) XXX XX XX">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Şifre</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                    <button type="button" class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar"></div>
                    <span class="strength-text">Şifre Gücü: Zayıf</span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirm">Şifre Tekrar</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password_confirm" name="password_confirm" required placeholder="••••••••">
                    <button type="button" class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="profile_image">Profil Fotoğrafı</label>
                <div class="input-group">
                    <i class="fas fa-camera"></i>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*">
                </div>
                <small class="form-text">İsteğe bağlı. Maksimum 2MB.</small>
            </div>

            <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox" name="terms" required>
                    <span>Kullanım koşullarını ve gizlilik politikasını kabul ediyorum</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-user-plus"></i>
                Kayıt Ol
            </button>

            <div class="auth-divider">
                <span>veya</span>
            </div>

            <div class="social-login">
                <button type="button" class="btn btn-outline btn-block">
                    <i class="fab fa-google"></i>
                    Google ile Kayıt Ol
                </button>
                <button type="button" class="btn btn-outline btn-block">
                    <i class="fab fa-facebook"></i>
                    Facebook ile Kayıt Ol
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <p>Zaten hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
        </div>
    </div>
</div>

<style>
/* Mevcut auth stilleri buraya gelecek */

.password-strength {
    margin-top: 5px;
}

.strength-bar {
    height: 4px;
    background: var(--gray-200);
    border-radius: 2px;
    margin-bottom: 5px;
    overflow: hidden;
}

.strength-bar::before {
    content: '';
    display: block;
    height: 100%;
    width: 0;
    background: var(--danger);
    transition: all 0.3s ease;
}

.strength-bar.medium::before {
    width: 50%;
    background: var(--warning);
}

.strength-bar.strong::before {
    width: 100%;
    background: var(--success);
}

.strength-text {
    font-size: 0.8rem;
    color: var(--gray-600);
}

.form-text {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin-top: 5px;
    display: block;
}

input[type="file"] {
    padding: 8px;
    border: 1px dashed var(--gray-300);
    border-radius: 5px;
    width: 100%;
    cursor: pointer;
}

input[type="file"]:hover {
    border-color: var(--primary);
}
</style>

<script>
// Şifre göster/gizle
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Şifre gücü kontrolü
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.querySelector('.strength-bar');
    const strengthText = document.querySelector('.strength-text');
    
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    strengthBar.className = 'strength-bar';
    if (strength <= 2) {
        strengthBar.classList.add('weak');
        strengthText.textContent = 'Şifre Gücü: Zayıf';
    } else if (strength <= 4) {
        strengthBar.classList.add('medium');
        strengthText.textContent = 'Şifre Gücü: Orta';
    } else {
        strengthBar.classList.add('strong');
        strengthText.textContent = 'Şifre Gücü: Güçlü';
    }
});

// Form doğrulama
document.querySelector('.auth-form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    if (password !== passwordConfirm) {
        e.preventDefault();
        alert('Şifreler eşleşmiyor!');
    }
});
</script>

<?php
require_once 'includes/footer.php';
?> 