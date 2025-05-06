<?php

class CsrfToken {
    private static $instance = null;
    private $token = null;
    private $tokenName = '_token';
    private $tokenLength = 32;
    private $defaultExpirationMinutes = 60; // 1 saat

    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Eğer session'da token varsa, onu kullan
        if (isset($_SESSION[$this->tokenName])) {
            $this->token = $_SESSION[$this->tokenName];
        } else {
            // Yoksa yeni token oluştur
            $this->generateToken();
            $this->setExpiration($this->defaultExpirationMinutes);
        }
    }

    /**
     * Singleton instance'ı döndürür
     * 
     * @return self
     */
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Yeni bir CSRF token oluşturur
     * 
     * @return string
     */
    public function generateToken(): string {
        $this->token = bin2hex(random_bytes($this->tokenLength));
        $_SESSION[$this->tokenName] = $this->token;
        // Token oluşturulduğunda varsayılan süreyi ata
        $this->setExpiration($this->defaultExpirationMinutes);
        return $this->token;
    }

    /**
     * Mevcut token'ı döndürür
     * 
     * @return string
     */
    public function getToken(): string {
        // Token yoksa veya süresi dolmuşsa yeni token oluştur
        if ($this->token === null || $this->isExpired()) {
            return $this->generateToken();
        }
        return $this->token;
    }

    /**
     * Token'ı doğrular
     * 
     * @param string $token
     * @return bool
     */
    public function validateToken(?string $token): bool {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }

        if (!isset($_SESSION[$this->tokenName]) || $token === null) {
            return false;
        }

        if ($this->isExpired()) {
            $this->removeToken();
            return false;
        }

        return hash_equals($_SESSION[$this->tokenName], $token);
    }

    /**
     * POST verilerinden token'ı doğrular
     * 
     * @return bool
     */
    public function validatePostToken(): bool {
        if (!isset($_POST[$this->tokenName])) {
            error_log('CSRF Token validation failed: Token not found in POST data');
            return false;
        }

        $isValid = $this->validateToken($_POST[$this->tokenName]);
        if (!$isValid) {
            error_log('CSRF Token validation failed: Invalid token');
            error_log('Session token: ' . ($_SESSION[$this->tokenName] ?? 'not set'));
            error_log('Posted token: ' . $_POST[$this->tokenName]);
        }

        return $isValid;
    }

    /**
     * Token'ı yeniler
     * 
     * @return string
     */
    public function refreshToken(): string {
        $this->removeToken();
        return $this->generateToken();
    }

    /**
     * Token'ı siler
     * 
     * @return void
     */
    public function removeToken(): void {
        $this->token = null;
        unset($_SESSION[$this->tokenName]);
        unset($_SESSION[$this->tokenName . '_expires']);
    }

    /**
     * Token input field'ı oluşturur
     * 
     * @return string
     */
    public function getTokenField(): string {
        return sprintf(
            '<input type="hidden" name="%s" value="%s">',
            $this->tokenName,
            $this->getToken()
        );
    }

    /**
     * Token'ın geçerli olup olmadığını kontrol eder
     * 
     * @return bool
     */
    public function isValid(): bool {
        return $this->validatePostToken();
    }

    /**
     * Token'ın süresi dolmuş mu kontrol eder
     * 
     * @return bool
     */
    public function isExpired(): bool {
        if (!isset($_SESSION[$this->tokenName . '_expires'])) {
            return true;
        }

        return time() > $_SESSION[$this->tokenName . '_expires'];
    }

    /**
     * Token'a süre ekler
     * 
     * @param int $minutes
     * @return void
     */
    public function setExpiration(int $minutes): void {
        $_SESSION[$this->tokenName . '_expires'] = time() + ($minutes * 60);
    }
} 