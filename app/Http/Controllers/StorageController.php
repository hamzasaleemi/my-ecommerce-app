<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Inertia\Response;

class StorageController extends Controller
{
    public function getProductImage($filename)
    {
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
            abort(403, 'Invalid filename');
        }
        if (!Storage::exists('images/products/' . $filename)) {
            abort(404);
        }
        $contents = Storage::get('images/products/' . $filename);
        $mime = Storage::mimeType('images/products/' . $filename);
        $file = response($contents, 200)->header('Content-Type', $mime);
        return $file;
    }
}
