<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';

class Register
{
    private static $instance = null;
    private $db;
    private $session;
    private $errors = [];

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
     * Kullanıcı kaydı yapar
     * 
     * @param array $data Kullanıcı bilgileri
     * @return bool
     */
    public function register(array $data): bool
    {
        // Veri doğrulama
     
      
        if (!$this->validateData($data)) {
          
            return false;
        }
 
        try {
           
          
            // Şifreyi hashle
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Kullanıcıyı kaydet
          

            $result = $this->db->sorguCalistir("INSERT INTO customers (name, email, password)", "  VALUES (?, ?, ?)", [$data['name'], $data['email'], $hashedPassword]);

          
          
            return $result;
        } catch (Exception $e) {
            $this->errors[] = 'Kayıt işlemi sırasında bir hata oluştu.';
            return false;
        }
    }

    /**
     * Verileri doğrular
     * 
     * @param array $data
     * @return bool
     */
    private function validateData(array $data): bool
    {
        
        // İsim kontrolü
        if (empty($data['name'])) {
            $this->errors[] = 'Ad Soyad gereklidir.';
            return false;
        }

        if (strlen($data['name']) < 3) {
            $this->errors[] = 'Ad Soyad en az 3 karakter olmalıdır.';
            return false;
        }

        // E-posta kontrolü
        if (empty($data['email'])) {
            $this->errors[] = 'E-posta adresi gereklidir.';
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Geçerli bir e-posta adresi giriniz.';
            return false;
        }

        // E-posta adresi kullanımda mı kontrol et
        if ($this->isEmailExists($data['email'])) {
            $this->errors[] = 'Bu e-posta adresi zaten kullanımda.';
            return false;
        }

        // Şifre kontrolü
        if (empty($data['password'])) {
            $this->errors[] = 'Şifre gereklidir.';
            return false;
        }

        if (strlen($data['password']) < 6) {
            $this->errors[] = 'Şifre en az 6 karakter olmalıdır.';
            return false;
        }

        // Şifre tekrar kontrolü
        if (empty($data['password_confirm'])) {
            $this->errors[] = 'Şifre tekrarı gereklidir.';
            return false;
        }

        if ($data['password'] !== $data['password_confirm']) {
            $this->errors[] = 'Şifreler eşleşmiyor.';
            return false;
        }

        return true;
    }

    /**
     * E-posta adresi kullanımda mı kontrol eder
     * 
     * @param string $email
     * @return bool
     */
    private function isEmailExists(string $email): bool
    {
        
        $result = $this->db->veriGetir(0, "customers", "WHERE email = ?", [$email]);
      
        return !empty($result);
    }

    /**
     * Hata mesajlarını döndürür
     * 
     * @return array
     */
    public function getErrors(): array
    {
        $this->session->set('login_errors', $this->errors);
        return $this->session->get('login_errors', []);
    }
}