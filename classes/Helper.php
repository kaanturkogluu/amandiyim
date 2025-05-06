<?php

class Helper
{
    private static $config = [];
    private static $envLoaded = false;
    private static $instance = null;

    /**
     * Singleton pattern için private constructor
     */
    private function __construct()
    {
        if (self::$envLoaded == false) {
            self::loadEnv();
        }
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

    /**
     * .env dosyasını bir kez yükler
     */
    private static function loadEnv()
    {
        if (self::$envLoaded) {
            return;
        }

        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    self::$config[trim($key)] = trim($value);
                }
            }
            self::$envLoaded = true;
        }
    }

    /**
     * Yapılandırma değerini alır
     */
    public static function config($key, $default = null)
    {
        self::loadEnv();
        return self::$config[$key] ?? $default;
    }

    /**
     * Base URL'i alır
     */
    public static function baseUrl()
    {
        return self::config('APP_URL');
    }

    /**
     * Tam URL oluşturur
     */
    public static function url($path = '')
    {
        return self::baseUrl() . '/' . ltrim($path, '/');
    }

    /**
     * Controller için url oluşturur
     */
    public static function controller($path)
    {
        // Diğer dosyalar için pages/ ekle
        return self::baseUrl() . '/controller/' . $path . '.php';
    }


    public static function upolads($path)
    {
        return self::baseUrl() . '/uploads/' . $path;
    }
    public static function view($path)
    {
        return self::baseUrl() . '/pages/' . $path . '.php';
    }
    public static function storePanelView($path)
    {
        return self::baseUrl() . '/panel/store/pages/' . $path . '.php';
    }
    public static function viewWithParams($path, $params, $value)
    {
        return self::baseUrl() . '/pages/' . $path . '.php?' . $params . '=' . $value;
    }
    public static function adminViewWithParams($path, $params, $value)
    {
        return self::baseUrl() . '/panel/admin/pages/' . $path . '.php?' . $params . '=' . $value;
    }

    public static function storeViewWithParams($path, $params, $value)
    {
        return self::baseUrl() . '/panel/store/pages/' . $path . '.php?' . $params . '=' . $value;
    }
    public static function customerPanelView($path)
    {
        return self::baseUrl() . '/panel/customer/pages/' . $path . '.php';
    }
    public static function adminPanelView($path)
    {
        return self::baseUrl() . '/panel/admin/pages/' . $path . '.php';
    }

    public static function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Debug modunda mı kontrol eder
     */
    public static function isDebug()
    {
        return self::config('APP_DEBUG', false) === 'true';
    }


    public static function redirect($path)
    {
        echo '<meta http-equiv="refresh" content="0;url=' . $path . '">';
        exit;
    }
    /**
     * POST verilerini güvenli bir şekilde alır
     * 
     * @param string $key POST verisinin anahtarı
     * @param mixed $default Varsayılan değer (opsiyonel)
     * @param bool $sanitize Veriyi temizleyip temizlemeyeceği (varsayılan: true)
     * @return mixed
     */
    public static function post(string $key, $default = null, bool $sanitize = true): mixed
    {
        // POST verisi var mı kontrol et
        if (!isset($_POST[$key])) {
            return $default;
        }

        $value = $_POST[$key];

        // Veri temizleme işlemi
        if ($sanitize) {
            // Dizi ise her elemanı temizle
            if (is_array($value)) {
                $value = array_map(function ($item) {
                    return self::sanitize($item);
                }, $value);
            } else {
                $value = self::sanitize($value);
            }
        }

        return $value;
    }

    /**
     * POST verisinin var olup olmadığını kontrol eder
     * 
     * @param string $key POST verisinin anahtarı
     * @return bool
     */
    public static function hasPost(string $key): bool
    {
        return isset($_POST[$key]);
    }

    /**
     * Veriyi güvenli hale getirir
     * 
     * @param mixed $data Temizlenecek veri
     * @return mixed
     */
    private static function sanitize($data): mixed
    {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }

        // HTML karakterlerini dönüştür
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        // Boşlukları temizle
        $data = trim($data);

        return $data;
    }
}