<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';

class MyLogin
{
    private static $instance = null;
    private $db;
    private $session;
    private $errors = [];
    private const MAX_LOGIN_ATTEMPTS = 7; // Maksimum deneme sayısı
    private const LOCKOUT_TIME = 300; // 15 dakika (saniye cinsinden)

    private function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * IP adresini alır
     * 
     * @return string
     */
    private function getClientIP(): string
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
     * Giriş denemelerini kontrol eder
     * 
     * @return bool
     */
    private function checkLoginAttempts(): bool
    {
        $ip = $this->getClientIP();
        if($ip == 'UNKNOWN')
        {
            return false;
        }
        $attempts = $this->session->get("login_attempts_{$ip}", 0);
        $lastAttempt = $this->session->get("last_login_attempt_{$ip}", 0);
        $currentTime = time();

        // Eğer son deneme zamanından bu yana LOCKOUT_TIME geçtiyse sayacı sıfırla
        if ($currentTime - $lastAttempt > self::LOCKOUT_TIME) {
            $this->session->delete("login_attempts_{$ip}");
            $this->session->delete("last_login_attempt_{$ip}");
            return true;
        }

        // Eğer maksimum deneme sayısına ulaşıldıysa
        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            $remainingTime = self::LOCKOUT_TIME - ($currentTime - $lastAttempt);
            $minutes = ceil($remainingTime / 60);
            $this->errors[] = "Bu IP adresinden çok fazla başarısız deneme yapıldı. Lütfen {$minutes} dakika sonra tekrar deneyin.";
            $this->session->set('login_errors', $this->errors);
            return false;
        }

        return true;
    }

    /**
     * Giriş denemelerini kaydeder
     * 
     * @return void
     */
    private function recordLoginAttempt(): void
    {
        $ip = $this->getClientIP();
        $attempts = $this->session->get("login_attempts_{$ip}", 0);
        $this->session->set("login_attempts_{$ip}", $attempts + 1);
        $this->session->set("last_login_attempt_{$ip}", time());
    }

    /**
     * Başarılı girişte deneme sayacını sıfırlar
     * 
     * @return void
     */
    private function resetLoginAttempts(): void
    {
        $ip = $this->getClientIP();
        $this->session->delete("login_attempts_{$ip}");
        $this->session->delete("last_login_attempt_{$ip}");
    }
    

    /**
     * Giriş işlemini gerçekleştirir
     * 
     * @param string $email
     * @param string $password
     * @param string $userType
     * @return bool
     */
    public function login(string $email, string $password, string $userType): bool
    {
        try {
            // Giriş denemelerini kontrol et
            if (!$this->checkLoginAttempts()) {
                return false;
            }

            // Kullanıcı tipine göre tablo ve alanları belirle
            $table = $this->getTableByUserType($userType);

            if (!$table) {
                $this->errors[] = 'Geçersiz kullanıcı tipi.';
                $this->session->set('login_errors', $this->errors);
                return false;
            }

            // Kullanıcıyı bul
            $emailField = match($userType) {
                'admin' => 'admin_mail',
                'store' => 'store_owner_mail',
                default => 'email'
            };
           

            $user = $this->db->veriGetir(0, $table, "WHERE {$emailField} = ?", [$email]);
  
            if (empty($user)) {
                $this->errors[] = 'Kullanıcı bulunamadı.';
                $this->session->set('login_errors', $this->errors);
                $this->recordLoginAttempt();
                return false;
            }

            $user = $user[0];

            // Şifre kontrolü
            $passwordField = match($userType) {
                'admin' => 'admin_password',
                'store' => 'store_owner_password',
                default => 'password'
            };

            if (!password_verify($password, $user[$passwordField])) {
                $this->errors[] = 'Hatalı şifre.';
                $this->session->set('login_errors', $this->errors);
                $this->recordLoginAttempt();
                return false;
            }

            // Durum kontrolü
            if (isset($user['status']) && $user['status'] !== 'active') {
                $this->errors[] = 'Hesabınız aktif değil.';
                $this->session->set('login_errors', $this->errors);
                return false;
            }

            // Session oluştur
            $this->createSession($user, $userType);
            $this->session->delete('login_errors');
            $this->resetLoginAttempts(); // Başarılı girişte deneme sayacını sıfırla

            return true;

        } catch (Exception $e) {
            $this->errors[] = 'Giriş işlemi sırasında bir hata oluştu.';
            $this->session->set('login_errors', $this->errors);
            return false;
        }
    }

    /**
     * Kullanıcı tipine göre tablo adını döndürür
     * 
     * @param string $userType
     * @return string|null
     */
    private function getTableByUserType(string $userType): ?string
    {
        $tables = [
            'customer' => 'customers',
            'admin' => 'admins',
            'store' => 'stores'
        ];

        return $tables[$userType] ?? null;
    }

    /**
     * Session oluşturur
     * 
     * @param array $user
     * @param string $userType
     * @return void
     */
    private function createSession(array $user, string $userType): void
    {
        // Hassas bilgileri çıkar
        unset($user['password']);

        // Session'a kullanıcı bilgilerini kaydet
        $this->session->set('user', $user);
        $this->session->set('user_type', $userType);
        $this->session->set('is_logged_in', true);
        $this->session->set('last_activity', time());
       
    }

    /**
     * Çıkış işlemini gerçekleştirir
     * 
     * @return void
     */
    public function logout(): void
    {
        $this->session->clear();
    }

    /**
     * Kullanıcının giriş yapıp yapmadığını kontrol eder
     * 
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->session->get('is_logged_in', false);
    }

    /**
     * Giriş yapan kullanıcının tipini döndürür
     * 
     * @return string|null
     */
    public function getUserType(): ?string
    {
        return $this->session->get('user_type');
    }

    /**
     * Giriş yapan kullanıcının bilgilerini döndürür
     * 
     * @return array|null
     */
    public function getUser(): ?array
    {
        return $this->session->get('user');
    }

    /**
     * Hata mesajlarını döndürür
     * 
     * @return array
     */
    public function getErrors(): array
    {
        $errors = $this->session->get('login_errors', []);
        if (!is_array($errors)) {
            $errors = [$errors];
        }
        return $errors;
    }
    public  function clearErrors():void 
    {
        $this->session->delete('login_errors');
    }
    public function clearSuccess():void 
    {
        $this->session->delete('success');
    }

    /**
     * Kullanıcı yetkisini kontrol eder
     * 
     * @param string $requiredType
     * @return bool
     */
    public function checkPermission(string $requiredType): bool
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        return $this->getUserType() === $requiredType;
    }
}