<?php


class Session
{
    private static $instance = null;
    private $flash = [];
    private $old = [];
    private $started = false;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            $this->start();
        }
    }

    /**Formdan Gelen id ile sessiondaki aynı mı diye kontrol et , harici durumlarda ekstra önlem alinabilir */
    public function checkSendedUserId($sendedId)
    {
        if (self::getUserId() != $sendedId) {
            return false;
        }
        return true;
    }

    /**
     * Singleton instance'ı döndürür
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**Kullanıcının session üzerindeki id sini verir */
    public function getUserId()
    {
        return $_SESSION['user']['id'];
    }

    /**
     * /Genel  oturumlarını kontrol eder
     * @return bool
     */

    public function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']);
    }
    /**
     * /Oturum Açan mağaza mı kontrol eder
     * @return bool
     */
    public function isStore()
    {
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] == "store";
    }
    public function isAdmin()
    {

        if ($_SESSION['user_type'] == "admin") {
            return true;
        }
        return false;
    }
    /**
     * Session'ı başlatır
     */
    public function start()
    {
        if (!$this->started) {
            // Güvenli session ayarları
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.cookie_samesite', 'Lax');

            session_start();
            $this->started = true;

            // Flash mesajlarını al
            $this->flash = $_SESSION['flash'] ?? [];
            unset($_SESSION['flash']);

            // Eski form verilerini al
            $this->old = $_SESSION['old'] ?? [];
            unset($_SESSION['old']);
        }
    }

    /**
     * Session'a veri ekler
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Session'dan veri alır
     */
    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Session'dan veri siler
     */
    public function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Session'da veri var mı kontrol eder
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Flash mesajı ekler
     */
    public function flash($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    /**
     * Flash mesajı alır
     */
    public function getFlash($key, $default = null)
    {
        return $this->flash[$key] ?? $default;
    }

    /**
     * Tüm flash mesajlarını alır
     */
    public function getAllFlash()
    {
        return $this->flash;
    }

    /**
     * Form verilerini saklar
     */
    public function old($key, $default = null)
    {
        return $this->old[$key] ?? $default;
    }

    /**
     * Tüm eski form verilerini alır
     */
    public function getAllOld()
    {
        return $this->old;
    }

    /**
     * Form verilerini saklar
     */
    public function storeOld($data)
    {
        $_SESSION['old'] = $data;
    }

    /**
     * Hata mesajı ekler
     */
    public function addError($message)
    {
        if (!isset($_SESSION['errors'])) {
            $_SESSION['errors'] = [];
        }
        $_SESSION['errors'][] = $message;
    }

    /**
     * Hata mesajlarını alır
     */
    public function getErrors()
    {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        return $errors;
    }

    /**
     * Başarı mesajı ekler
     */
    public function setSuccess($message)
    {
        $_SESSION['success'] = $message;
    }

    public function kickOut($message = "Tekrar Giriş Yapınız")
    {
        $this->clear();
        $this->flash('error', $message);
        header("Location:" . Helper::view('giris'));
        exit;
    }
    /**
     * Başarı mesajını alır
     */
    public function getSuccess()
    {
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        return $success;
    }

    /**
     * Session'ı temizler
     */
    public function clear()
    {
        session_unset();
        session_destroy();
        $this->started = false;
    }

    /**
     * Session ID'sini yeniler
     */
    public function regenerate()
    {
        if ($this->started) {
            session_regenerate_id(true);
        }
    }

    /**
     * Session'ın son kullanım zamanını günceller
     */
    public function touch()
    {
        if ($this->started) {
            $_SESSION['last_activity'] = time();
        }
    }

    /**
     * Session'ın son kullanım zamanını kontrol eder
     */
    public function isExpired($lifetime = 1800)
    {
        if (!$this->started || !isset($_SESSION['last_activity'])) {
            return true;
        }

        return (time() - $_SESSION['last_activity']) > $lifetime;
    }

    /**
     * Session'ın son kullanım zamanını alır
     */
    public function getLastActivity()
    {
        return $_SESSION['last_activity'] ?? null;
    }

    /**
     * Session'ın başlatılıp başlatılmadığını kontrol eder
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * Session ID'sini alır
     */
    public function getId()
    {
        return session_id();
    }

    /**
     * Session'ın tüm verilerini alır
     */
    public function all()
    {
        return $_SESSION;
    }
}