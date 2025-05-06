<?php
class FileUploader
{
    private $baseUpload = __DIR__."/../uploads/";
    const DEFAULT_ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif','image/webp'];
    const DEFAULT_MAX_SIZE = 10 * 1024 * 1024; // 10 MB

    // Upload function
    public function uploadPhoto($file, $uploadDir, $maxSize = self::DEFAULT_MAX_SIZE, $allowedTypes = self::DEFAULT_ALLOWED_TYPES)
    {
        // Define the full upload directory path
        $uploadDir = $this->baseUpload. '/images/' . $uploadDir;

        // Check if file was uploaded without errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Error during file upload: ' . $this->getUploadErrorMessage($file['error']);
        }

        // Check if file type is allowed
        if (!in_array($file['type'], $allowedTypes)) {
            return 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
        }

        // Check if file size exceeds the maximum allowed size
        if ($file['size'] > $maxSize) {
            return 'File exceeds the maximum allowed size of ' . ($maxSize / 1024 / 1024) . ' MB.';
        }
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        // Generate a unique name for the uploaded file
        $unique_name = uniqid('', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        // Try moving the uploaded file to the destination directory
        if (move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $unique_name)) {
            return $unique_name; // Return the unique file name
        } else {
            return 'Failed to move uploaded file. Check directory permissions.';
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


    public function deletePhoto($file, $uploadDir)
    {

        $path = $this->baseUpload.  $uploadDir ."/". $file;
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }
  
    

}
// $uploader = new FileUploader();
// $uploadResult = $uploader->uploadPhoto($_FILES['previewimage'], 'products-preview/');
