<?php
require_once __DIR__.'/../includes/header.php';
require_once 'includes/auth.php';
redirectIfAuthenticated();
?>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h1>Şifremi Unuttum</h1>
            <p>Şifrenizi sıfırlamak için e-posta adresinizi girin</p>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" action="process-forgot-password.php" method="POST">
            <div class="form-group">
                <label for="email">E-posta Adresi</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="ornek@email.com">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-paper-plane"></i>
                Şifre Sıfırlama Bağlantısı Gönder
            </button>
        </form>

        <div class="auth-footer">
            <p>Hesabınızı hatırladınız mı? <a href="login.php">Giriş Yapın</a></p>
        </div>
    </div>
</div>

<style>
.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.alert-success {
    background: var(--success-light);
    color: var(--success);
    border: 1px solid var(--success);
}

.alert-danger {
    background: var(--danger-light);
    color: var(--danger);
    border: 1px solid var(--danger);
}
</style>

<?php
require_once 'includes/footer.php';
?> 