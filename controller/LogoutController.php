<?php

require_once __DIR__ . '/../classes/MyLogin.php';
require_once __DIR__ . '/../classes/Session.php';

class LogoutController
{
    private $login;
    private $session;
    private $errors = [];

    public function __construct()
    {
        $this->login = MyLogin::getInstance();
        $this->session = Session::getInstance();
    }

    /**
     * Çıkış işlemini gerçekleştirir
     * 
     * @return bool
     */
    public function handleLogout(): bool
    {
        try {
            // GET isteği kontrolü
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                $this->errors[] = 'Geçersiz istek metodu.';
                return false;
            }

            // Kullanıcı tipini al
            $userType = $this->login->getUserType();

            // Session'ı temizle
            $this->session->clear();
           
       
            // Kullanıcı tipine göre yönlendirme yap
            $this->redirect($userType);

            return true;

        } catch (Exception $e) {
            $this->errors[] = 'Çıkış işlemi sırasında bir hata oluştu.';
            return false;
        }
    }

    /**
     * Hata mesajlarını döndürür
     * 
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Kullanıcı tipine göre yönlendirme yapar
     * 
     * @param string|null $userType
     * @return void
     */
    private function redirect(?string $userType): void
    {
        switch ($userType) {
            case 'admin':
                header('Location:'.Helper::view('giris'));
                break;
            case 'store':
                header('Location:'.Helper::view('giris'));
                break;
            case 'customer':
            default:
                header('Location:'.Helper::view('giris'));
                break;
        }
        exit;
    }
}
$logoutController = new LogoutController();
$logoutController->handleLogout();