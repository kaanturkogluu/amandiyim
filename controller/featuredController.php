<?php
require_once __DIR__ . '/../classes/Helper.php';
require_once __DIR__ . '/../classes/FeaturedCampaigns.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/Session.php';


date_default_timezone_set('Europe/Istanbul');


// Session ve CSRF kontrolü için gerekli sınıfları başlat
$session = Session::getInstance();
$csrf = CsrfToken::getInstance();
$featuredCampaigns = new FeaturedCampaigns();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // CSRF token kontrolü
    if (!$csrf->validateToken($_POST['_token'])) {
        $response['message'] = 'Güvenlik doğrulaması başarısız!';
        $response['data'] = $_POST;
        echo json_encode($response);
        exit;
    }

    // İşlem tipini kontrol et
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add':
            $r = $featuredCampaigns->create(['campaign_id' => $_POST['campaign_id'], 'featured_started_date' => $_POST['featured_started_date'], 'featured_ended_date' => $_POST['featured_ended_date']]);
            if ($r) {

                $session->flash('success', 'Eklendi');
                header("Location: " . Helper::adminPanelView('featured/featured'));
                exit;
            }
            $session->flash('error', 'Eklenemedi');
            header("Location: " . Helper::adminPanelView('featured/featured'));
            break;

        case 'delete':
            $id = $_POST['id'];
            $d = $featuredCampaigns->delete($id);
            if ($d) {

                $session->flash('success', 'Silindi');
                header("Location: " . Helper::adminPanelView('featured/featured'));
                exit;

            } else {
                $session->flash('error', 'silinemedi');
                header("Location: " . Helper::adminPanelView('featured/featured'));

            }
            break;

        case 'move':
            $direction = $_POST['direction'] == 'up' ? $direction = $_POST['order'] + 1 : $direction = $_POST['order'] - 1;

            $u = $featuredCampaigns->update($_POST['id'], ['orderNumber' => $direction]);
            if ($u) {

                $session->flash('success', 'Güncellendi');
                header("Location: " . Helper::adminPanelView('featured/featured'));
                exit;

            } else {
                $session->flash('error', 'Güncellendi');
                header("Location: " . Helper::adminPanelView('featured/featured'));

            }
            break;

           
    }
}