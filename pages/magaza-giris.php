<?php
$current_page = 'store-login';
?><?php 

include __DIR__.'/../includes/navbar.php';
?>
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h2>Mağaza Girişi</h2>
            <p>Mağaza hesabınıza giriş yaparak kampanyalarınızı yönetin</p>
        </div>

        <form class="auth-form" method="POST" action="">
            <div class="form-group">
                <label for="store-email">E-posta Adresi</label>
                <input type="email" id="store-email" name="store-email" required 
                       placeholder="Mağaza e-posta adresinizi giriniz" 
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="store-password">Şifre</label>
                <input type="password" id="store-password" name="store-password" required 
                       placeholder="Mağaza şifrenizi giriniz" 
                       class="form-control">
            </div>

            <div class="form-group">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Beni hatırla
                </label>
                <a href="#" class="forgot-password">Şifremi Unuttum</a>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-store"></i> Mağaza Girişi
            </button>

            <div class="auth-divider">
                <span>veya</span>
            </div>

            <div class="auth-options">
                <a href="index.php?page=login" class="btn btn-outline btn-block">
                    <i class="fas fa-user"></i> Müşteri Girişi
                </a>
                <a href="index.php?page=admin-login" class="btn btn-outline btn-block">
                    <i class="fas fa-user-shield"></i> Admin Girişi
                </a>
            </div>
        </form>

        <div class="auth-footer">
            Mağaza hesabınız yok mu? 
            <a href="index.php?page=store-register">Mağaza Kaydı Yapın</a>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: var(--gradient-primary);
}

.auth-box {
    width: 100%;
    max-width: 400px;
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 40px;
    box-shadow: var(--shadow-lg);
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-header h2 {
    color: var(--primary);
    font-size: 2rem;
    margin-bottom: 10px;
}

.auth-header p {
    color: var(--dark);
    opacity: 0.8;
}

.auth-form .form-group {
    margin-bottom: 20px;
}

.auth-form label {
    display: block;
    margin-bottom: 8px;
    color: var(--dark);
    font-weight: 600;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 2px solid var(--light);
    border-radius: 8px;
    transition: var(--transition);
    font-size: 1rem;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.2);
    outline: none;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
}

.checkbox-container input {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--light);
    border-radius: 4px;
    display: inline-block;
    position: relative;
    transition: var(--transition);
}

.checkbox-container input:checked + .checkmark {
    background: var(--primary);
    border-color: var(--primary);
}

.checkbox-container input:checked + .checkmark::after {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: var(--white);
    font-size: 12px;
}

.forgot-password {
    float: right;
    color: var(--primary);
    text-decoration: none;
    font-size: 0.9rem;
}

.forgot-password:hover {
    text-decoration: underline;
}

.btn-block {
    width: 100%;
    padding: 14px;
    font-size: 1rem;
    margin-bottom: 15px;
}

.auth-divider {
    text-align: center;
    margin: 20px 0;
    position: relative;
}

.auth-divider::before,
.auth-divider::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 45%;
    height: 1px;
    background: var(--light);
}

.auth-divider::before {
    left: 0;
}

.auth-divider::after {
    right: 0;
}

.auth-divider span {
    background: var(--white);
    padding: 0 10px;
    color: var(--dark);
    opacity: 0.6;
}

.auth-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.auth-footer {
    text-align: center;
    margin-top: 30px;
    color: var(--dark);
}

.auth-footer a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.auth-footer a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .auth-box {
        padding: 30px 20px;
    }

    .auth-header h2 {
        font-size: 1.8rem;
    }

    .form-control {
        padding: 10px;
        font-size: 0.95rem;
    }

    .btn-block {
        padding: 12px;
        font-size: 0.95rem;
    }
}
</style> 