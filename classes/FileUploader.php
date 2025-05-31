<?php
class FileUploader
{
    private $baseUpload = __DIR__."/../uploads/";
    const DEFAULT_ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif','image/webp','image/jpg'];
    const DEFAULT_MAX_SIZE = 10 * 1024 * 1024; // 10 MB
    private $uploadDir;
    private $allowedTypes;
    private $maxFileSize;

    public function __construct() {
        $this->uploadDir = __DIR__ . '/../uploads/images/';
        $this->allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp','image/jpg'];
        $this->maxFileSize = 5 * 1024 * 1024; // 5MB
    }

    private function checkAndCreateDirectory($path) {
        if (!file_exists($path)) {
            // Dizin oluştur ve izinleri ayarla (755)
            if (!mkdir($path, 0755, true)) {
                throw new Exception('Dizin oluşturulamadı: ' . $path);
            }
        } else {
            // Dizin var ama yazma izni kontrol et
            if (!is_writable($path)) {
                // İzinleri güncelle (755)
                if (!chmod($path, 0755)) {
                    throw new Exception('Dizin izinleri güncellenemedi: ' . $path);
                }
            }
        }
    }

    // Upload function
    public function uploadPhoto($file, $subDir = '')
    {
        try {
            // Ana upload dizinini kontrol et
            $this->checkAndCreateDirectory($this->uploadDir);

            // Alt dizini oluştur
            $uploadPath = $this->uploadDir . $subDir . '/';
            $this->checkAndCreateDirectory($uploadPath);

            // Dosya tipini kontrol et
            if (!in_array($file['type'], $this->allowedTypes)) {
                throw new Exception('Geçersiz dosya tipi. Sadece JPEG, PNG, GIF ve WebP formatları desteklenmektedir.');
            }

            // Dosya boyutunu kontrol et
            if ($file['size'] > $this->maxFileSize) {
                throw new Exception('Dosya boyutu çok büyük. Maksimum 5MB olmalıdır.');
            }

            // Benzersiz dosya adı oluştur
            $fileName = uniqid() . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $targetPath = $uploadPath . $fileName;

            // Dosyayı yükle
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception('Dosya yüklenemedi.');
            }

            // Yüklenen dosyanın izinlerini ayarla (644)
            chmod($targetPath, 0644);

            return $fileName;

        } catch (Exception $e) {
            // Hata durumunda yüklenen dosyayı temizle
            if (isset($targetPath) && file_exists($targetPath)) {
                unlink($targetPath);
            }
            throw $e;
        }
    }

    public function uploadMultipleImages($files, $uploadDir)
    {
        $uploadedImages = [];

        // Eğer dosyalar boş değilse
        if (!empty($files['name'][0])) {
            foreach ($files['name'] as $key => $name) {
                // Dosya bilgilerini hazırlıyoruz
                $file = [
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key]
                ];

                // Fotoğrafı yükle
                $uploadedImage = $this->uploadPhoto($file, $uploadDir);


                // Eğer yükleme başarılıysa
                if ($uploadedImage && is_string($uploadedImage)) {
                    // Yüklenen dosyayı listeye ekle
                    $uploadedImages[] = $uploadedImage;
                } else {
                    // Hata durumunda sadece hatalı dosyayı atla, diğerlerini yüklemeye devam et
                    continue;
                }
            }
        }

        return $uploadedImages; // Tüm yüklenen dosyaları döndür
    }

    // Helper function to translate error codes into readable messages
    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded.';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload.';
            default:
                return 'Unknown upload error.';
        }
    }


    public function deletePhoto($fileName, $subDir = '')
    {
        $filePath = $this->uploadDir . $subDir . '/' . $fileName;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
  
    /**
     * Resmi sıkıştırır ve yeniden boyutlandırır
     * 
     * @param string $source Kaynak dosya yolu
     * @param string $destination Hedef dosya yolu
     * @param int $quality Kalite değeri (0-100)
     * @return bool İşlem başarılı ise true, değilse false
     */
    public function compressImage($sourcePath, $destinationPath, $quality = 80)
    {
        try {
            // Kaynak dosyanın varlığını ve okunabilirliğini kontrol et
            if (!file_exists($sourcePath) || !is_readable($sourcePath)) {
                throw new Exception('Kaynak dosya bulunamadı veya okunamıyor.');
            }

            // Hedef dizinin yazılabilir olduğunu kontrol et
            $destinationDir = dirname($destinationPath);
            $this->checkAndCreateDirectory($destinationDir);

            // Görsel tipini belirle
            $imageInfo = getimagesize($sourcePath);
            if ($imageInfo === false) {
                throw new Exception('Geçersiz görsel dosyası.');
            }

            // Orijinal görseli yükle
            $image = null;
            switch ($imageInfo[2]) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($sourcePath);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($sourcePath);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($sourcePath);
                    break;
                case IMAGETYPE_WEBP:
                    $image = imagecreatefromwebp($sourcePath);
                    break;
                default:
                    throw new Exception('Desteklenmeyen görsel formatı.');
            }

            if (!$image) {
                throw new Exception('Görsel yüklenemedi.');
            }

            // Orijinal boyutları al
            $width = imagesx($image);
            $height = imagesy($image);

            // Maksimum boyutları ayarla
            $maxWidth = 1920;
            $maxHeight = 1080;

            // En-boy oranını koru
            if ($width > $height) {
                if ($width > $maxWidth) {
                    $height = round($height * ($maxWidth / $width));
                    $width = $maxWidth;
                }
            } else {
                if ($height > $maxHeight) {
                    $width = round($width * ($maxHeight / $height));
                    $height = $maxHeight;
                }
            }

            // Yeni görsel oluştur
            $newImage = imagecreatetruecolor($width, $height);

            // PNG ve WebP için şeffaflığı koru
            if ($imageInfo[2] == IMAGETYPE_PNG || $imageInfo[2] == IMAGETYPE_WEBP) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
            }

            // Görseli yeniden boyutlandır
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

            // WebP formatında kaydet
            if (!imagewebp($newImage, $destinationPath, $quality)) {
                throw new Exception('Görsel kaydedilemedi.');
            }

            // Belleği temizle
            imagedestroy($image);
            imagedestroy($newImage);

            // Yeni dosyanın izinlerini ayarla (644)
            chmod($destinationPath, 0644);

            return true;

        } catch (Exception $e) {
            // Hata durumunda oluşturulan dosyayı temizle
            if (isset($destinationPath) && file_exists($destinationPath)) {
                unlink($destinationPath);
            }
            throw $e;
        }
    }
}
// $uploader = new FileUploader();
// $uploadResult = $uploader->uploadPhoto($_FILES['previewimage'], 'products-preview/');
