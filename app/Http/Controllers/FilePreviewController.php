<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FilePreviewController extends Controller
{
    public function show($path)
    {
        $decodedPath = urldecode($path); // penting!

        if (!Storage::disk('public')->exists($decodedPath)) {
            abort(404, 'File not found.');
        }

        // Get the full path to the file on the local filesystem
        $fullPath = Storage::disk('public')->path($decodedPath);

        // Use PHP's mime_content_type to get the MIME type
        $mime = mime_content_type($fullPath);

        if ($mime === false) {
            // Fallback or error handling if mime_content_type fails
            $mime = 'application/octet-stream'; // Generic binary type
        }


        // Use Storage::response() for a simpler and potentially more reliable file response
        return Storage::disk('public')->response($decodedPath, basename($decodedPath), [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($decodedPath) . '"',
        ]);
    }
}
