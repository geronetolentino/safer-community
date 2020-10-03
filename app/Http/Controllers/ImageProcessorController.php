<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;

class ImageProcessorController extends Controller
{

    public function __construct(){}

    public function index($filename)
    {
        $storage = 'app/public/';
        $folder = 'o4uw5tv89ru6oert9nb2c03m9w5093nu4w/';
        
        $path = storage_path($storage.$folder.$filename);

        if (!File::exists($path)) {
            $filename = 'default-avatar.png';
        }

        $path = storage_path($storage.$folder.$filename);

        return $this->generateOutput($path);
    }

    public function establishment($filename)
    {

        $path = storage_path('app/public/0e569ydrotjbhu3on5e8ubiho65ebyrntoy34/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        return $this->generateOutput($path);
    }
    public function generateQrCode()
    {
        $path = QrCode::size(250)->format('svg')->generate('123','123.svg');
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    private function generateOutput($path)
    {
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    
}
