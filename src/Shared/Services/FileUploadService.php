<?php
namespace App\Shared\Services;

class FileUploadService {
    private $uploadDir;
    private $maxFileSize;
    private $allowedExtensions;
    
    public function __construct($uploadDir = 'uploads/', $maxFileSize = 5242880) { // 5MB
        $this->uploadDir = $uploadDir;
        $this->maxFileSize = $maxFileSize;
        $this->allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'txt', 'zip', 'rar'];
    }
    
    public function upload($file, $user_id) {
        $this->validateFile($file);
        
        $filename = $this->generateUniqueFilename($file['name']);
        $filepath = $this->uploadDir . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new \Exception('Failed to upload file.');
        }
        
        return [
            'original_name' => $file['name'],
            'filename' => $filename,
            'filepath' => $filepath,
            'size' => $file['size'],
            'type' => $file['type']
        ];
    }
    
    private function validateFile($file) {
        if ($file['size'] > $this->maxFileSize) {
            throw new \Exception('File size exceeds maximum limit.');
        }
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            throw new \Exception('File type not allowed.');
        }
    }
    
    private function generateUniqueFilename($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $basename = preg_replace('/[^A-Za-z0-9._-]/', '', pathinfo($originalName, PATHINFO_FILENAME));
        return $basename . '_' . uniqid() . '.' . $extension;
    }
}
