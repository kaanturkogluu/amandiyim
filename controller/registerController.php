<?php

require_once __DIR__ . '/../classes/Register.php';

$register = Register::getInstance();
$session = Session::getInstance();

require_once __DIR__ . '/../classes/Helper.php';


// Form verilerini Helper::post ile al
$data = [
    'name' => Helper::post('name'),
    'email' => Helper::post('email'),
    'phone' => Helper::post('phone_prefix') . Helper::post('phone'), // Telefon numarasını birleştir
    'password' => Helper::post('password'),
    'password_confirm' => Helper::post('password_confirmation')
];

// Register sınıfını başlat
$register = Register::getInstance();

try {
    // Kayıt işlemini gerçekleştir
    if ($register->register($data)) {
        // Başarılı kayıt
        $_SESSION['success'] = 'Kayıt işlemi başarıyla tamamlandı.';
        header('Location:' . Helper::view('giris'));
        exit;
    } else {
        // Hata varsa
        
        $_SESSION['errors'] = $register->getErrors();
        $_SESSION['old'] = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_prefix' => Helper::post('phone_prefix'),
            'phone' => Helper::post('phone')
        ];
       
        header('Location:' . Helper::view("kayit"));
        exit;
    }
} catch (Exception $e) {
    // Beklenmeyen hata
    $_SESSION['errors'] = ['Bir hata oluştu: ' . $e->getMessage()];
    $_SESSION['old'] = [
        'name' => $data['name'],
        'email' => $data['email'],
        'phone_prefix' => Helper::post('phone_prefix'),
        'phone' => Helper::post('phone')
    ];
    header('Location: /kayit');
    exit;
}

?>