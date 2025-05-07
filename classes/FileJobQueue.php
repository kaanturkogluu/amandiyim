<?php

require_once __DIR__ ."/CampaingsView.php";
require_once __DIR__ ."/IpHelper.php";
class FileJobQueue
{
    private string $dir;
    private string $metaFile;
    private int $maxLines;
    private int $maxFiles;
    private string $logFile;
    private string $errorLogFile;
    

    public function __construct(string $dir = __DIR__.'/../websitedata', int $maxLines = 50, int $maxFiles = 100)
    {
        $this->dir = rtrim($dir, '/');
        $this->metaFile = $this->dir . '/data.json';
        $this->logFile = $this->dir . '/queue.log';
        $this->errorLogFile = $this->dir . '/error.log';
        $this->maxLines = $maxLines;
        $this->maxFiles = $maxFiles;

        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }

        if (!file_exists($this->metaFile)) {
            file_put_contents($this->metaFile, json_encode([]));
        }
    }

    public function add(array $data): bool
    {
        $meta = $this->safeReadMeta();
        if ($meta === null) return false;

        $last = end($meta);
        if (!$last || $last['line'] >= $this->maxLines || $last['isCompleted']) {
            // Önceki dosya tamamlandıysa, veritabanına aktar
            if ($last && $last['isCompleted'] && isset($last['name'])) {
                $this->transferFileDataToDb($last['name']);
            }
            $index = count($meta) + 1;
            $filename = "data_$index.json";
            $meta[] = ['name' => $filename, 'line' => 0, 'isCompleted' => false];
            $last = end($meta);
        } else {
            $filename = $last['name'];
        }

        $dataFile = $this->dir . '/' . $filename;
        $fileData = $this->safeReadFile($dataFile) ?? [];

        $fileData[] = array_merge($data, [
            'created_at' => date('Y-m-d H:i:s'),
            'ip_address' => IpHelper::getUserIp() ?? '127.0.0.1'
        ]);

        if (!$this->safeWriteFile($dataFile, $fileData)) {
            $this->logError("Unable to write to $dataFile");
            return false;
        }

        foreach ($meta as &$m) {
            if ($m['name'] === $filename) {
                $m['line'] = count($fileData);
                if ($m['line'] >= $this->maxLines) {
                    $m['isCompleted'] = true;
                }
                break;
            }
        }

        if (count($meta) > $this->maxFiles) {
            $this->logError("Max file count exceeded");
            return false;
        }

        return $this->safeWriteMeta($meta);
    }

    public function process(callable $callback): void
    {
        $meta = $this->safeReadMeta();
        if ($meta === null) return;

        $newMeta = [];

        foreach ($meta as $entry) {
            $filePath = $this->dir . '/' . $entry['name'];

            if ($entry['isCompleted'] && file_exists($filePath)) {
                $data = $this->safeReadFile($filePath);
                if (!$data) continue;

                try {
                    $callback($data);
                    unlink($filePath);
                    $this->log("Processed and deleted {$entry['name']}");
                } catch (Exception $e) {
                    $this->logError("Processing error {$entry['name']}: " . $e->getMessage());
                    $newMeta[] = $entry;
                }
            } else {
                $newMeta[] = $entry;
            }
        }

        $this->safeWriteMeta($newMeta);
    }

    private function safeReadMeta(): ?array
    {
        $fp = fopen($this->metaFile, 'r');
        if (!$fp) return null;

        if (flock($fp, LOCK_SH)) {
            $size = filesize($this->metaFile);
            $content = $size > 0 ? fread($fp, $size) : '';
            flock($fp, LOCK_UN);
            fclose($fp);
            return json_decode($content, true) ?? [];
        }

        fclose($fp);
        $this->logError("Could not read meta file safely.");
        return null;
    }

    private function safeWriteMeta(array $meta): bool
    {
        $fp = fopen($this->metaFile, 'c+');
        if (!$fp) return false;

        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, json_encode($meta, JSON_PRETTY_PRINT));
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
            return true;
        }

        fclose($fp);
        $this->logError("Could not write meta file safely.");
        return false;
    }

    private function safeReadFile(string $filePath): ?array
    {
        if (!file_exists($filePath)) return [];

        $fp = fopen($filePath, 'r');
        if (!$fp) return null;

        if (flock($fp, LOCK_SH)) {
            $size = filesize($filePath);
            $contents = $size > 0 ? fread($fp, $size) : '';
            flock($fp, LOCK_UN);
            fclose($fp);
            return json_decode($contents, true) ?? [];
        }

        fclose($fp);
        $this->logError("Could not read file $filePath safely.");
        return null;
    }

    private function safeWriteFile(string $filePath, array $data): bool
    {
        $fp = fopen($filePath, 'c+');
        if (!$fp) return false;

        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
            return true;
        }

        fclose($fp);
        $this->logError("Could not write file $filePath safely.");
        return false;
    }

    private function transferFileDataToDb(string $filename)
    {
        $dataFile = $this->dir . '/' . $filename;
        $fileData = $this->safeReadFile($dataFile);

        if (!$fileData) return;

        try {
            $campaingViews = new CampaingsView();
            $result = $campaingViews->createCollective($fileData);

            if ($result) {
                // $filename dosyasını sil
                if (file_exists($dataFile)) {
                    unlink( $dataFile);
                }
               
            }
        } catch (PDOException $e) {
            $this->logError("DB Error: " . $e->getMessage());
        }
    }

    private function startWorker(){

    }
    private function log(string $message): void
    {
        $entry = date('[Y-m-d H:i:s] ') . $message . PHP_EOL;
        file_put_contents($this->logFile, $entry, FILE_APPEND);
    }

    private function logError(string $message): void
    {
        $entry = date('[Y-m-d H:i:s] ') . "[ERROR] $message" . PHP_EOL;
        file_put_contents($this->errorLogFile, $entry, FILE_APPEND);
    }
}


 