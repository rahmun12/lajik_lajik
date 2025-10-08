<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mime\MimeTypes;

// Alias untuk Log facade
use Log as LogFacade;

class FileController extends Controller
{
    public function show($filename)
    {
        // Bersihkan nama file dari path yang tidak diinginkan
        $filename = basename($filename);
        
        // Log untuk debugging
        LogFacade::info('Mencoba mengunduh file:', ['filename' => $filename]);
        
        // Cari file di semua subdirektori
        $directories = Storage::disk('public')->allDirectories();
        $filePath = null;
        if (Storage::disk('public')->exists('documents/' . $filename)) {
            $filePath = 'documents/' . $filename;
        } 
        // Jika tidak ditemukan, cari di direktori lain
        else {
            foreach ($directories as $directory) {
                $path = $directory . '/' . $filename;
                if (Storage::disk('public')->exists($path)) {
                    $filePath = $path;
                    break;
                }
            }
            
            // Jika masih tidak ditemukan, coba di root
            if (!$filePath && Storage::disk('public')->exists($filename)) {
                $filePath = $filename;
            }
        }

        // Jika file masih tidak ditemukan
        if (!$filePath) {
            LogFacade::error('File tidak ditemukan di storage:', ['filename' => $filename]);
            
            // Coba cari file dengan nama yang mirip (case insensitive)
            $allFiles = Storage::disk('public')->allFiles();
            $foundFile = null;
            
            foreach ($allFiles as $file) {
                if (strtolower(basename($file)) === strtolower($filename)) {
                    $foundFile = $file;
                }
            }
            
            if ($foundFile) {
                $filePath = $foundFile;
                LogFacade::info('File ditemukan dengan case yang berbeda:', [
                    'requested' => $filename,
                    'found' => $filePath
                ]);
            }
        }

        // Jika file masih tidak ditemukan
        if (!$filePath) {
                'filename' => $filename,
                'directories_checked' => $directories
            ]);
            
            // Kembalikan gambar placeholder
            $placeholder = public_path('images/image-not-found.jpg');
            
            // Buat direktori jika belum ada
            if (!file_exists(dirname($placeholder))) {
                mkdir(dirname($placeholder), 0755, true);
            }
            
            // Buat gambar placeholder jika belum ada
            if (!file_exists($placeholder)) {
                $img = imagecreatetruecolor(400, 300);
                $bg = imagecolorallocate($img, 240, 240, 240);
                $textColor = imagecolorallocate($img, 120, 120, 120);
                
                imagefill($img, 0, 0, $bg);
                $text = 'Image Not Found';
                $fontSize = 5;
                $textWidth = imagefontwidth($fontSize) * strlen($text);
                $x = (400 - $textWidth) / 2;
                $y = 150;
                
                imagestring($img, $fontSize, $x, $y, $text, $textColor);
                imagejpeg($img, $placeholder);
                imagedestroy($img);
            }
            
            if (file_exists($placeholder)) {
                return response()->file($placeholder, [
                    'Content-Type' => 'image/jpeg',
                    'Content-Disposition' => 'inline',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            }
            
            abort(404, 'File tidak ditemukan: ' . $filename);
        }
        
        // Periksa apakah file ada dan bisa dibaca
        $fullPath = Storage::disk('public')->path($filePath);
        if (!file_exists($fullPath) || !is_readable($fullPath)) {
            LogFacade::error('File tidak dapat diakses:', [
                'path' => $filePath,
                'exists' => file_exists($fullPath) ? 'Ya' : 'Tidak',
                'readable' => is_readable($fullPath) ? 'Ya' : 'Tidak'
            ]);
            
            $placeholder = public_path('images/image-not-found.jpg');
            if (file_exists($placeholder)) {
                return response()->file($placeholder, [
                    'Content-Type' => 'image/jpeg',
                    'Content-Disposition' => 'inline'
                ]);
            }
            
            abort(404, 'File tidak dapat diakses: ' . $filePath);
        }
        
        // Dapatkan tipe MIME file
        $mimeType = mime_content_type($fullPath);
        if (!$mimeType) {
            $mimeType = 'application/octet-stream';
        }

        $file = Storage::disk('public')->path($filePath);
        LogFacade::info('File ditemukan:', ['path' => $file]);

        // Cek permission file
        if (!is_readable($file)) {
            LogFacade::error('File tidak dapat dibaca:', ['path' => $file, 'permissions' => substr(sprintf('%o', fileperms($file)), -4)]);
            abort(403, 'Akses file ditolak');
        }

        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($file) ?: 'application/octet-stream';
        
        return response()->file($file, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
