<?php

class Zip {
    protected $org_files;
    protected $new_file_path;
    protected $extr_file;
    protected $extr_dirc;
    protected $useFallbackWriter;

    public function __construct(){
        $this->extr_file = 0;
        $this->new_file_path = 0;
        $this->org_files = array();
        $this->useFallbackWriter = false;
    }

    protected function hasZipArchive()
    {
        return class_exists('ZipArchive');
    }

    public function zip_start($file_path) {
        $this->new_file_path = $file_path;
        $this->useFallbackWriter = !$this->hasZipArchive();
        return true;
    }

    public function zip_add($in){
        if($this->new_file_path === 0) {
            throw new Exception('PHP-ZIP: must call zip_start before zip_add');
        }

        if(is_string($in)){
            if(file_exists($in)) {
                if(!is_dir($in)) {
                    if (is_readable($in)) {
                        $this->org_files[] = $in;
                    }
                } else {
                    $this->push_whole_dir($in);
                }
            }
        } else {
            foreach($in as $value){
                $this->zip_add($value);
            }
        }

        return true;
    }

    public function zip_end($website_path) {
        if ($this->useFallbackWriter) {
            return $this->zip_end_fallback($website_path);
        }

        $lib = new ZipArchive();
        $openResult = $lib->open($this->new_file_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($openResult !== true) {
            throw new Exception('PHP-ZIP: Unable to create the zip archive. Please verify write permissions and that the zip extension is working on this host.');
        }

        $count_before = $lib->numFiles;
        $names = $this->commonPath($this->org_files, $website_path, true);

        foreach ($this->org_files as $index => $org_file_path) {
            if (!file_exists($org_file_path) || !is_readable($org_file_path)) {
                continue;
            }

            $localName = isset($names[$index]) ? $names[$index] : basename($org_file_path);
            if ($localName === '' || $localName === false) {
                $localName = basename($org_file_path);
            }
            $localName = $this->normalizeZipPath($localName);

            $fileSize = @filesize($org_file_path);
            if ($fileSize === 0) {
                if ($lib->addFromString($localName, '') === false) {
                    throw new Exception('PHP-ZIP: Unable to add an empty file to the zip archive: ' . $org_file_path);
                }
                continue;
            }

            if ($lib->addFile($org_file_path, $localName) === false) {
                throw new Exception('PHP-ZIP: Unable to add file to the zip archive: ' . $org_file_path);
            }
        }

        $count_after = $lib->numFiles;
        $lib->close();

        if ($count_after < $count_before) {
            throw new Exception('PHP-ZIP: Archive creation did not complete successfully.');
        }

        if(!file_exists($this->new_file_path)) throw new Exception('PHP-ZIP: After doing the zipping file can not be found');
        if(filesize($this->new_file_path) === 0 && count($this->org_files) > 0) throw new Exception('PHP-ZIP: After doing the zipping file size is still 0 bytes');

        $this->org_files = array();
        return true;
    }

    protected function zip_end_fallback($website_path)
    {
        $handle = @fopen($this->new_file_path, 'wb');
        if (!$handle) {
            throw new Exception('PHP-ZIP: Unable to create the zip archive on this host. Please verify write permissions.');
        }

        $centralDirectory = '';
        $offset = 0;
        $names = $this->commonPath($this->org_files, $website_path, true);
        $addedCount = 0;

        foreach ($this->org_files as $index => $org_file_path) {
            if (!file_exists($org_file_path) || !is_readable($org_file_path) || is_dir($org_file_path)) {
                continue;
            }

            $localName = isset($names[$index]) ? $names[$index] : basename($org_file_path);
            if ($localName === '' || $localName === false) {
                $localName = basename($org_file_path);
            }
            $localName = $this->normalizeZipPath($localName);
            $nameLength = strlen($localName);

            $data = @file_get_contents($org_file_path);
            if ($data === false) {
                continue;
            }

            $uncompressedSize = strlen($data);
            $crc32 = crc32($data);
            if ($crc32 < 0) {
                $crc32 += 4294967296;
            }

            $dosTime = $this->unixToDosTime(@filemtime($org_file_path) ?: time());
            $timeField = $dosTime & 0xffff;
            $dateField = ($dosTime >> 16) & 0xffff;

            $localHeader = pack(
                'VvvvvvVVVvv',
                0x04034b50,
                20,
                0,
                0,
                $timeField,
                $dateField,
                $crc32,
                $uncompressedSize,
                $uncompressedSize,
                $nameLength,
                0
            ) . $localName;

            if (@fwrite($handle, $localHeader) === false || @fwrite($handle, $data) === false) {
                @fclose($handle);
                throw new Exception('PHP-ZIP: Unable to write the fallback zip archive.');
            }

            $centralDirectory .= pack(
                'VvvvvvvVVVvvvvvVV',
                0x02014b50,
                20,
                20,
                0,
                0,
                $timeField,
                $dateField,
                $crc32,
                $uncompressedSize,
                $uncompressedSize,
                $nameLength,
                0,
                0,
                0,
                0,
                32,
                $offset
            ) . $localName;

            $offset += strlen($localHeader) + $uncompressedSize;
            $addedCount++;
        }

        $centralDirectorySize = strlen($centralDirectory);
        if ($centralDirectorySize > 0) {
            if (@fwrite($handle, $centralDirectory) === false) {
                @fclose($handle);
                throw new Exception('PHP-ZIP: Unable to finalize the fallback zip archive.');
            }
        }

        $eocd = pack(
            'VvvvvVVv',
            0x06054b50,
            0,
            0,
            $addedCount,
            $addedCount,
            $centralDirectorySize,
            $offset,
            0
        );

        if (@fwrite($handle, $eocd) === false) {
            @fclose($handle);
            throw new Exception('PHP-ZIP: Unable to write the fallback zip footer.');
        }

        @fclose($handle);

        if(!file_exists($this->new_file_path)) throw new Exception('PHP-ZIP: After doing the zipping file can not be found');
        if(filesize($this->new_file_path) === 0 && count($this->org_files) > 0) throw new Exception('PHP-ZIP: After doing the zipping file size is still 0 bytes');

        $this->org_files = array();
        return true;
    }

    public function zip_files($files, $to, $website_path) {
        $this->zip_start($to);
        $this->zip_add($files);
        return $this->zip_end($website_path);
    }

    public function unzip_file($file_path,$target_dir=NULL) {
        if(!file_exists($file_path)) throw new Exception("PHP-ZIP: File doesn't Exist");

        $this->extr_file = $file_path;

        if($target_dir !== NULL) return $this->unzip_to($target_dir);
        else return true;
    }

    public function unzip_to($target_dir) {
        if($this->extr_file === 0) throw new Exception("PHP-ZIP: unzip_file hasn't been called");
        if(file_exists($target_dir) && (!is_dir($target_dir))) throw new Exception("PHP-ZIP: Target directory exists as a file not a directory");
        if(!file_exists($target_dir)) if(!mkdir($target_dir, 0777, true)) throw new Exception("PHP-ZIP: Directory not found, and unable to create it");

        $this->extr_dirc = $target_dir;

        if ($this->hasZipArchive()) {
            $lib = new ZipArchive;
            if($lib->open($this->extr_file) !== true) throw new Exception("PHP-ZIP: Unable to open the zip file");
            if(!$lib->extractTo($this->extr_dirc)) throw new Exception("PHP-ZIP: Unable to extract files");
            $lib->close();
            return true;
        }

        return $this->unzip_to_fallback($target_dir);
    }

    protected function unzip_to_fallback($target_dir)
    {
        $handle = @fopen($this->extr_file, 'rb');
        if (!$handle) {
            throw new Exception('PHP-ZIP: Unable to open the zip file for fallback extraction');
        }

        $entries = $this->readCentralDirectory($handle);
        foreach ($entries as $entry) {
            $name = $this->normalizeZipPath($entry['name']);
            if ($name === '' || strpos($name, '../') !== false || strpos($name, '..\\') !== false) {
                continue;
            }

            $destination = rtrim($target_dir, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $name);

            if ($this->isDirectoryEntry($entry['name'])) {
                if (!is_dir($destination) && !@mkdir($destination, 0777, true)) {
                    @fclose($handle);
                    throw new Exception('PHP-ZIP: Unable to create directory during fallback extraction: ' . $destination);
                }
                continue;
            }

            $parent = dirname($destination);
            if (!is_dir($parent) && !@mkdir($parent, 0777, true)) {
                @fclose($handle);
                throw new Exception('PHP-ZIP: Unable to create directory during fallback extraction: ' . $parent);
            }

            $data = $this->readZipEntryData($handle, $entry);
            if (@file_put_contents($destination, $data) === false) {
                @fclose($handle);
                throw new Exception('PHP-ZIP: Unable to write extracted file during fallback extraction: ' . $destination);
            }

            if (!empty($entry['mtime'])) {
                @touch($destination, $entry['mtime']);
            }
        }

        @fclose($handle);
        return true;
    }

    protected function readCentralDirectory($handle)
    {
        $stat = fstat($handle);
        $fileSize = isset($stat['size']) ? (int)$stat['size'] : 0;
        if ($fileSize <= 0) {
            throw new Exception('PHP-ZIP: Invalid zip file');
        }

        $searchLength = min($fileSize, 65557);
        fseek($handle, $fileSize - $searchLength);
        $tail = fread($handle, $searchLength);
        $eocdPos = strrpos($tail, "PK\x05\x06");
        if ($eocdPos === false) {
            throw new Exception('PHP-ZIP: Unable to locate zip directory');
        }

        $eocd = substr($tail, $eocdPos, 22);
        if (strlen($eocd) < 22) {
            throw new Exception('PHP-ZIP: Corrupt zip footer');
        }

        $eocdFields = unpack('Vsignature/vdisk/vdiskStart/ventriesDisk/ventriesTotal/VcentralSize/VcentralOffset/vcommentLength', $eocd);
        if ((int)$eocdFields['signature'] !== 0x06054b50) {
            throw new Exception('PHP-ZIP: Invalid zip footer');
        }

        fseek($handle, (int)$eocdFields['centralOffset']);
        $entries = array();
        $total = (int)$eocdFields['entriesTotal'];

        for ($i = 0; $i < $total; $i++) {
            $header = fread($handle, 46);
            if (strlen($header) < 46) {
                throw new Exception('PHP-ZIP: Corrupt central directory');
            }

            $fields = unpack(
                'Vsignature/vversionMade/vversionNeeded/vflags/vmethod/vtime/vdate/Vcrc/VcompressedSize/Vsize/vnameLength/vextraLength/vcommentLength/vdisk/vinternal/Vexternal/VlocalOffset',
                $header
            );

            if ((int)$fields['signature'] !== 0x02014b50) {
                throw new Exception('PHP-ZIP: Invalid central directory entry');
            }

            $name = $fields['nameLength'] > 0 ? fread($handle, (int)$fields['nameLength']) : '';
            if ($fields['extraLength'] > 0) {
                fread($handle, (int)$fields['extraLength']);
            }
            if ($fields['commentLength'] > 0) {
                fread($handle, (int)$fields['commentLength']);
            }

            $entries[] = array(
                'name' => $name,
                'flags' => (int)$fields['flags'],
                'method' => (int)$fields['method'],
                'crc' => (int)$fields['crc'],
                'compressed_size' => (int)$fields['compressedSize'],
                'size' => (int)$fields['size'],
                'local_offset' => (int)$fields['localOffset'],
                'mtime' => $this->dosToUnixTime((int)$fields['date'], (int)$fields['time']),
            );
        }

        return $entries;
    }

    protected function readZipEntryData($handle, $entry)
    {
        fseek($handle, (int)$entry['local_offset']);
        $localHeader = fread($handle, 30);
        if (strlen($localHeader) < 30) {
            throw new Exception('PHP-ZIP: Corrupt local file header');
        }

        $fields = unpack('Vsignature/vversion/vflags/vmethod/vtime/vdate/Vcrc/VcompressedSize/Vsize/vnameLength/vextraLength', $localHeader);
        if ((int)$fields['signature'] !== 0x04034b50) {
            throw new Exception('PHP-ZIP: Invalid local file header');
        }

        $nameLength = (int)$fields['nameLength'];
        $extraLength = (int)$fields['extraLength'];
        if ($nameLength > 0) {
            fread($handle, $nameLength);
        }
        if ($extraLength > 0) {
            fread($handle, $extraLength);
        }

        $compressedSize = (int)$entry['compressed_size'];
        if ($compressedSize < 0) {
            throw new Exception('PHP-ZIP: Invalid compressed size');
        }

        $compressedData = $compressedSize > 0 ? fread($handle, $compressedSize) : '';
        if ($compressedSize > 0 && strlen($compressedData) !== $compressedSize) {
            throw new Exception('PHP-ZIP: Unable to read zip entry data');
        }

        switch ((int)$entry['method']) {
            case 0:
                $data = $compressedData;
                break;
            case 8:
                if (!function_exists('gzinflate')) {
                    throw new Exception('PHP-ZIP: Cannot extract deflated zip entries because zlib is not available on this host.');
                }
                $data = @gzinflate($compressedData);
                if ($data === false) {
                    throw new Exception('PHP-ZIP: Unable to inflate zip entry data');
                }
                break;
            default:
                throw new Exception('PHP-ZIP: Unsupported zip compression method in fallback extractor: ' . $entry['method']);
        }

        if (strlen($data) !== (int)$entry['size']) {
            throw new Exception('PHP-ZIP: Extracted file size mismatch');
        }

        return $data;
    }

    protected function isDirectoryEntry($name)
    {
        return substr($name, -1) === '/';
    }

    protected function push_whole_dir($dir){
        $files = @scandir($dir);
        if ($files === false) {
            return;
        }

        foreach($files as $key => $value){
            if ($value === '.' || $value === '..') {
                continue;
            }

            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if ($path === false) {
                $path = $dir . DIRECTORY_SEPARATOR . $value;
            }

            if(is_dir($path)) {
                $this->push_whole_dir($path);
            } else if (is_readable($path)) {
                $this->org_files[] = $path;
            }
        }
    }

    protected function commonPath($files, $website_path, $removeWebsitePath = false){
        $result = array();
        $websitePath = rtrim(str_replace('\\', '/', $website_path), '/');

        foreach ($files as $file) {
            $normalized = str_replace('\\', '/', $file);
            if ($removeWebsitePath && strpos($normalized, $websitePath . '/') === 0) {
                $normalized = substr($normalized, strlen($websitePath) + 1);
            } else {
                $normalized = ltrim($normalized, '/');
            }
            $result[] = $normalized;
        }

        return $result;
    }

    protected function normalizeZipPath($path)
    {
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');
        return $path;
    }

    protected function unixToDosTime($timestamp)
    {
        $time = getdate($timestamp);
        if ($time['year'] < 1980) {
            $time = array(
                'year' => 1980,
                'mon' => 1,
                'mday' => 1,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
            );
        }

        return (($time['year'] - 1980) << 25)
            | ($time['mon'] << 21)
            | ($time['mday'] << 16)
            | ($time['hours'] << 11)
            | ($time['minutes'] << 5)
            | (int)($time['seconds'] / 2);
    }

    protected function dosToUnixTime($dateField, $timeField)
    {
        $day = $dateField & 0x1f;
        $month = ($dateField >> 5) & 0x0f;
        $year = (($dateField >> 9) & 0x7f) + 1980;
        $second = ($timeField & 0x1f) * 2;
        $minute = ($timeField >> 5) & 0x3f;
        $hour = ($timeField >> 11) & 0x1f;

        if ($year < 1980 || $month < 1 || $day < 1) {
            return time();
        }

        return @mktime($hour, $minute, $second, $month, $day, $year) ?: time();
    }
}
