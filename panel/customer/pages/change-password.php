<?php
require_once __DIR__.'/../includes/header.php';
?>

<div class="customer-content">
    <div class="content-header">
        <h1>Şifre Değiştir</h1>
        <a href="profile.php" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Geri Dön
        </a>
    </div>

    <div class="change-password-container">
        <div class="card">
            <div class="card-header">
                <h3>Güvenli Şifre Değiştirme</h3>
                <p class="text-muted">Hesabınızın güvenliği için güçlü bir şifre belirleyin.</p>
            </div>
            <div class="card-body">
                <form class="form">
                    <!-- Mevcut Şifre -->
                    <div class="form-group">
                        <label for="current-password">Mevcut Şifre</label>
                        <div class="password-input">
                            <input type="password" id="current-password" class="form-control" required>
                            <button type="button" class="btn btn-icon toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Yeni Şifre -->
                    <div class="form-group">
                        <label for="new-password">Yeni Şifre</label>
                        <div class="password-input">
                            <input type="password" id="new-password" class="form-control" required>
                            <button type="button" class="btn btn-icon toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-progress"></div>
                            </div>
                            <span class="strength-text">Şifre gücü: Zayıf</span>
                        </div>
                    </div>

                    <!-- Yeni Şifre Tekrar -->
                    <div class="form-group">
                        <label for="confirm-password">Yeni Şifre (Tekrar)</label>
                        <div class="password-input">
                            <input type="password" id="confirm-password" class="form-control" required>
                            <button type="button" class="btn btn-icon toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Şifre Gereksinimleri -->
                    <div class="password-requirements">
                        <h4>Şifre Gereksinimleri</h4>
                        <ul>
                            <li class="requirement" data-requirement="length">
                                <i class="fas fa-circle"></i>
                                En az 8 karakter uzunluğunda olmalı
                            </li>
                            <li class="requirement" data-requirement="uppercase">
                                <i class="fas fa-circle"></i>
                                En az bir büyük harf içermeli
                            </li>
                            <li class="requirement" data-requirement="lowercase">
                                <i class="fas fa-circle"></i>
                                En az bir küçük harf içermeli
                            </li>
                            <li class="requirement" data-requirement="number">
                                <i class="fas fa-circle"></i>
                                En az bir rakam içermeli
                            </li>
                            <li class="requirement" data-requirement="special">
                                <i class="fas fa-circle"></i>
                                En az bir özel karakter içermeli
                            </li>
                        </ul>
                    </div>

                    <!-- Güvenlik İpuçları -->
                    <div class="security-tips">
                        <h4>Güvenlik İpuçları</h4>
                        <ul>
                            <li>Kişisel bilgilerinizi içeren şifreler kullanmayın</li>
                            <li>Farklı hesaplar için farklı şifreler kullanın</li>
                            <li>Şifrenizi kimseyle paylaşmayın</li>
                            <li>Düzenli olarak şifrenizi değiştirin</li>
                            <li>Güçlü bir şifre yöneticisi kullanın</li>
                        </ul>
                    </div>

                    <!-- Kaydet Butonu -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Şifreyi Güncelle
                        </button>
                    </div>
                </form>
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

/* Change Password Container */
.change-password-container {
    max-width: 600px;
    margin: 0 auto;
}

.card-header p {
    margin-top: 5px;
}

/* Password Input */
.password-input {
    position: relative;
    display: flex;
    align-items: center;
}

.password-input .form-control {
    padding-right: 40px;
}

.password-input .btn-icon {
    position: absolute;
    right: 5px;
    color: var(--gray-500);
}

.password-input .btn-icon:hover {
    color: var(--gray-700);
}

/* Password Strength */
.password-strength {
    margin-top: 10px;
}

.strength-bar {
    height: 4px;
    background: var(--gray-200);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 5px;
}

.strength-progress {
    height: 100%;
    width: 0;
    background: var(--danger);
    transition: all 0.3s ease;
}

.strength-progress.medium {
    background: var(--warning);
}

.strength-progress.strong {
    background: var(--success);
}

.strength-text {
    font-size: 0.9rem;
    color: var(--gray-600);
}

/* Password Requirements */
.password-requirements {
    margin: 20px 0;
    padding: 20px;
    background: var(--gray-50);
    border-radius: 8px;
}

.password-requirements h4 {
    font-size: 1rem;
    margin-bottom: 15px;
    color: var(--gray-800);
}

.password-requirements ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.requirement {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    color: var(--gray-600);
}

.requirement i {
    font-size: 0.8rem;
    color: var(--gray-400);
}

.requirement.valid i {
    color: var(--success);
}

/* Security Tips */
.security-tips {
    margin: 20px 0;
    padding: 20px;
    background: var(--primary-50);
    border-radius: 8px;
}

.security-tips h4 {
    font-size: 1rem;
    margin-bottom: 15px;
    color: var(--primary);
}

.security-tips ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.security-tips li {
    font-size: 0.9rem;
    color: var(--gray-600);
    display: flex;
    align-items: center;
    gap: 10px;
}

.security-tips li::before {
    content: "•";
    color: var(--primary);
}

/* Form Actions */
.form-actions {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
}

/* Responsive */
@media (max-width: 768px) {
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .form-actions {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Şifre göster/gizle
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
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
    const newPassword = document.getElementById('new-password');
    const strengthBar = document.querySelector('.strength-progress');
    const strengthText = document.querySelector('.strength-text');
    const requirements = document.querySelectorAll('.requirement');

    newPassword.addEventListener('input', function() {
        const password = this.value;
        
        // Şifre gereksinimlerini kontrol et
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password)
        };

        // Gereksinimleri güncelle
        requirements.forEach(req => {
            const type = req.dataset.requirement;
            if (checks[type]) {
                req.classList.add('valid');
            } else {
                req.classList.remove('valid');
            }
        });

        // Şifre gücünü hesapla
        const strength = Object.values(checks).filter(Boolean).length;
        const percentage = (strength / 5) * 100;

        strengthBar.style.width = `${percentage}%`;
        
        if (percentage <= 40) {
            strengthBar.className = 'strength-progress';
            strengthText.textContent = 'Şifre gücü: Zayıf';
        } else if (percentage <= 80) {
            strengthBar.className = 'strength-progress medium';
            strengthText.textContent = 'Şifre gücü: Orta';
        } else {
            strengthBar.className = 'strength-progress strong';
            strengthText.textContent = 'Şifre gücü: Güçlü';
        }
    });
});
</script>

<?php
require_once 'includes/footer.php';
?> 