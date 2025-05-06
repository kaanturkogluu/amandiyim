<?php
require_once 'includes/header.php';
require_once 'includes/auth.php';
require_once '../config/database.php';

redirectIfAuthenticated();

$token = isset($_GET['token']) ? $_GET['token'] : null;
$valid_token = false;

if ($token) {
    try {
        $stmt = $db->prepare("
            SELECT pr.*, c.email 
            FROM password_resets pr 
            JOIN customers c ON pr.customer_id = c.id 
            WHERE pr.token = ? AND pr.expires_at > NOW()
        ");
        $stmt->execute([$token]);
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($reset) {
            $valid_token = true;
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
    header('Location: forgot-password.php');
    exit;
}
?>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h1>Şifre Sıfırlama</h1>
            <p>Yeni şifrenizi belirleyin</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" action="process-reset-password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            
            <div class="form-group">
                <label for="email">E-posta Adresi</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reset['email']); ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Yeni Şifre</label>
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
                <label for="password_confirm">Yeni Şifre Tekrar</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password_confirm" name="password_confirm" required placeholder="••••••••">
                    <button type="button" class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-key"></i>
                Şifreyi Güncelle
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

.alert-danger {
    background: var(--danger-light);
    color: var(--danger);
    border: 1px solid var(--danger);
}

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

input[readonly] {
    background: var(--gray-50);
    cursor: not-allowed;
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