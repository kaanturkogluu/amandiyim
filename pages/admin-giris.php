<?php
$current_page = 'admin-login';
?>
<?php 
include __DIR__.'/../includes/navbar.php';
?>

<div class="admin-login-page">
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1>Admin Girişi</h1>
                <p>Yönetim paneline erişmek için giriş yapın</p>
            </div>
            <form class="login-form" action="admin-panel.php" method="POST">
                <div class="form-group">
                    <label for="username">Kullanıcı Adı</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Şifre</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group remember-me">
                    <label>
                        <input type="checkbox" name="remember">
                        <span>Beni Hatırla</span>
                    </label>
                    <a href="#" class="forgot-password">Şifremi Unuttum</a>
                </div>
                <button type="submit" class="login-btn">Giriş Yap</button>
            </form>
        </div>
    </div>
</div>

<style>
.admin-login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px 0;
}

.login-container {
    background: var(--white);
    border-radius: 15px;
    padding: 40px;
    box-shadow: var(--shadow-lg);
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
}

.login-header {
    text-align: center;
    margin-bottom: 30px;
}

.login-header h1 {
    font-size: 2rem;
    color: var(--dark);
    margin-bottom: 10px;
}

.login-header p {
    color: var(--gray);
    font-size: 1rem;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--dark);
    font-weight: 500;
}

.form-group input[type="text"],
.form-group input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    border-color: var(--primary);
    outline: none;
}

.remember-me {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
}

.remember-me label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.remember-me input[type="checkbox"] {
    width: 16px;
    height: 16px;
}

.forgot-password {
    color: var(--primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.forgot-password:hover {
    color: var(--primary-dark);
}

.login-btn {
    width: 100%;
    padding: 12px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-btn:hover {
    background: var(--primary-dark);
}

@media (max-width: 768px) {
    .login-container {
        padding: 30px 20px;
        margin: 0 15px;
    }

    .login-header h1 {
        font-size: 1.8rem;
    }
}
</style> 
<?php 
require_once __DIR__.'/../includes/footer.php';
?>